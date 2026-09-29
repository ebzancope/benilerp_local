<?php
// app/Http/Controllers/ImportacaoController.php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Models\Equipamento; // Adicione este use
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportacaoController extends Controller
{
    public function importForm()
    {
        return view('importacao.abastecimento');
    }

    public function import(Request $request)
    {
        // $request->validate([
        //    'arquivo' => 'required|file|mimes:csv,txt|max:10240'
        // ]);

        try {
            $arquivo = $request->file('arquivo');
            $importados = 0;
            $erros = [];

            DB::beginTransaction();

            $handle = fopen($arquivo->getPathname(), 'r');

            if (!$handle) {
                throw new \Exception('Não foi possível abrir o arquivo.');
            }

            // Detectar delimitador automaticamente
            $primeiraLinha = fgets($handle, 1000);
            $delimitador = $this->detectarDelimitador($primeiraLinha);

            // Voltar para o início do arquivo
            rewind($handle);

            // Pular cabeçalho (primeira linha)
            $cabecalho = fgetcsv($handle, 1000, $delimitador);

            $numeroLinha = 1;
            $equipamentosNaoEncontrados = [];

            while (($linha = fgetcsv($handle, 1000, $delimitador)) !== FALSE) {
                $numeroLinha++;

                try {
                    // Ignorar linhas vazias
                    if (empty(array_filter($linha)) || count($linha) < 2) {
                        continue;
                    }

                    // Garantir que temos pelo menos 12 colunas
                    $dadosLinha = array_pad($linha, 12, null);

                    // Validar dados essenciais
                    if (empty($dadosLinha[0]) || empty($dadosLinha[1]) || empty($dadosLinha[2]) || empty($dadosLinha[3])) {
                        $erros[] = "Linha {$numeroLinha}: Dados essenciais faltando (data, cupom, litros ou valor)";
                        continue;
                    }

                    // **BUSCAR EQUIPAMENTO PELO CÓDIGO**
                    $codigoEquipamento = $this->extrairNumeroVeiculo($dadosLinha[4]);
                    $equipamento = $this->buscarEquipamentoPorCodigo($codigoEquipamento);

                    if (!$equipamento) {
                        $equipamentosNaoEncontrados[] = $codigoEquipamento;
                        $erros[] = "Linha {$numeroLinha}: Equipamento código '{$codigoEquipamento}' não encontrado na base de dados";
                        continue;
                    }

                    $dados = [

                        'user_id' => session('user.id'),
                        'datacad' => $this->converterData($dadosLinha[0]),
                        'descricao' => 'Cupom: ' . ($dadosLinha[1] ?? ''),
                        'combustivel' => $this->extrairNumero($dadosLinha[2]),
                        'requisicao' => $this->extrairNumero($dadosLinha[3]),
                        'veiculo' => $equipamento->id, // **AQUI USAMOS O ID DO EQUIPAMENTO**
                        'litros' => $this->formatarDecimal($dadosLinha[5]),
                        'qtda' => $this->formatarDecimal($dadosLinha[6]),
                        'desconto' => $this->formatarDecimal($dadosLinha[8]),
                        'totala' => $this->formatarDecimal($dadosLinha[9]),
                        'fornecedor' => $this->extrairNumero($dadosLinha[10]),
                        'created_at' => now(),
                        'updated_at' => now()

                    ];

                    // Validar se os dados são válidos antes de criar
                    if (!$this->validarDados($dados)) {
                        $erros[] = "Linha {$numeroLinha}: Dados inválidos";
                        continue;
                    }

                    Abastecimento::create($dados);
                    $importados++;
                } catch (\Exception $e) {
                    $erros[] = "Linha {$numeroLinha}: " . $e->getMessage();
                }
            }

            fclose($handle);
            DB::commit();

            // Mensagem final com estatísticas
            $mensagem = "✅ Importação concluída! {$importados} registros importados com sucesso.";

            if (!empty($erros)) {
                $mensagem .= " ⚠️ Erros: " . count($erros);
            }

            if (!empty($equipamentosNaoEncontrados)) {
                $equipamentosUnicos = array_unique($equipamentosNaoEncontrados);
                $mensagem .= " 🚫 Equipamentos não encontrados: " . implode(', ', $equipamentosUnicos);
            }

            return redirect()->route('importacao.form')
                ->with('success', $mensagem)
                ->with('erros', $erros)
                ->with('equipamentos_nao_encontrados', $equipamentosNaoEncontrados);
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            return redirect()->back()
                ->with('error', '❌ Erro na importação: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Buscar equipamento pelo código
     */
    private function buscarEquipamentoPorCodigo($codigo)
    {
        if (empty($codigo)) {
            return null;
        }

        // Buscar na tabela equipamentos pelo código
        return DB::table('equipamentos')
            ->where('codigo', $codigo)
            ->first();
    }

    /**
     * Extrair número do equipamento (já existe, mas vamos melhorar)
     */
    private function extrairNumeroVeiculo($equipamento)
    {
        if (empty($equipamento)) {
            return null;
        }

        $equipamento = strval($equipamento);

        // Se já for número, retornar como int
        if (is_numeric($equipamento)) {
            return intval($equipamento);
        }

        // Extrair números do texto
        if (preg_match('/\d+/', $equipamento, $matches)) {
            return intval($matches[0]);
        }

        return null;
    }

    private function detectarDelimitador($linha)
    {
        $delimitadores = [',', ';', "\t"];
        $counts = [];

        foreach ($delimitadores as $delimiter) {
            $counts[$delimiter] = count(str_getcsv($linha, $delimiter));
        }

        return array_keys($counts, max($counts))[0];
    }

    private function validarDados($dados)
    {
        // Validar data
        if (empty($dados['datacad']) || $dados['datacad'] == '0000-00-00 00:00:00') {
            return false;
        }

        // Validar litros (deve ser maior que 0)
        if ($dados['litros'] <= 0) {
            return false;
        }

        // Validar valor total (deve ser maior que 0)
        if ($dados['totala'] <= 0) {
            return false;
        }

        return true;
    }

    private function converterData($dataBr)
    {
        if (empty($dataBr)) {
            return now();
        }

        // Se já estiver no formato YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataBr)) {
            return $dataBr . ' 00:00:00';
        }

        // Se for timestamp Excel
        if (is_numeric($dataBr) && $dataBr > 25569) { // Excel timestamp base
            $timestamp = ($dataBr - 25569) * 86400; // Converter para Unix timestamp
            return date('Y-m-d H:i:s', $timestamp);
        }

        // Tentar vários formatos de data
        $formatos = [
            'd/m/Y',
            'd/m/Y H:i:s',
            'd-m-Y',
            'd-m-Y H:i:s',
            'Y-m-d',
            'Y-m-d H:i:s',
            'Y/m/d',
            'Y/m/d H:i:s'
        ];

        foreach ($formatos as $formato) {
            $data = \DateTime::createFromFormat($formato, $dataBr);
            if ($data !== false) {
                return $data->format('Y-m-d H:i:s');
            }
        }

        // Última tentativa: converter de DD/MM/YYYY
        $partes = explode('/', $dataBr);
        if (count($partes) === 3) {
            if (checkdate($partes[1], $partes[0], $partes[2])) {
                return $partes[2] . '-' . $partes[1] . '-' . $partes[0] . ' 00:00:00';
            }
        }

        // Se nada funcionar, usar data atual
        return now();
    }

    private function formatarDecimal($valor)
    {
        if (empty($valor)) {
            return 0;
        }

        // Se já for numérico
        if (is_numeric($valor)) {
            return floatval($valor);
        }

        // Remover possíveis espaços e caracteres especiais
        $valor = trim(strval($valor));
        $valor = preg_replace('/[^\d,.-]/', '', $valor);

        // Verificar se tem múltiplos pontos (formato americano)
        if (substr_count($valor, '.') > 1 && substr_count($valor, ',') === 0) {
            // Formato americano: 1.234.56 → 1234.56
            $valor = str_replace('.', '', $valor);
        } else {
            // Formato brasileiro: 1.234,56 → 1234.56
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        }

        $resultado = floatval($valor);

        // Validar se é um número válido
        if (!is_finite($resultado)) {
            return 0;
        }

        return $resultado;
    }


    private function extrairNumero($valor)
    {
        if (empty($valor)) {
            return null;
        }

        $valor = strval($valor);

        if (is_numeric($valor)) {
            $numero = intval($valor);
            return $numero > 0 ? $numero : null;
        }

        // Extrair apenas números
        if (preg_match('/\d+/', $valor, $matches)) {
            $numero = intval($matches[0]);
            return $numero > 0 ? $numero : null;
        }

        return null;
    }

    private function mapearCombustivel($combustivelTexto)
    {
        if (empty($combustivelTexto)) {
            return 1; // Default para DIESEL
        }

        $combustivelTexto = strval($combustivelTexto);

        $mapeamento = [
            'DIESEL B COMUM' => 1,
            'DIESEL S10' => 2,
            'GASOLINA' => 3,
            'ETANOL' => 4,
            'GASOLINA COMUM' => 3,
            'GASOLINA ADITIVADA' => 3,
            'DIESEL' => 1,
            'DIESEL COMUM' => 1,
            'DIESEL B' => 1,
            // Adicione outros conforme necessário
        ];

        $combustivelUpper = strtoupper(trim($combustivelTexto));

        return $mapeamento[$combustivelUpper] ?? 1; // Default para DIESEL
    }
}
