<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RelatorioDespesasController extends Controller
{


    public function index(Request $request)
{
    // ✅ USAR REQUEST PRIMEIRO, SEM Carbon::now()
    $dataInicio = $request->input('data_inicio', date('Y-m-01'));
    $dataFim = $request->input('data_fim', date('Y-m-t'));

    // ✅ TENTAR FORMATAR, SE FALHAR USA DATA ATUAL
    try {
        $dataInicio = date('Y-m-d', strtotime($dataInicio));
        $dataFim = date('Y-m-d', strtotime($dataFim));
    } catch (\Exception $e) {
        $dataInicio = date('Y-m-01');
        $dataFim = date('Y-m-t');
    }

    // ✅ VALIDAR SE FIM É MENOR QUE INÍCIO
    if (strtotime($dataFim) < strtotime($dataInicio)) {
        $temp = $dataInicio;
        $dataInicio = $dataFim;
        $dataFim = $temp;
    }

    $dataInicioFormatada = date('d/m/Y', strtotime($dataInicio));
    $dataFimFormatada = date('d/m/Y', strtotime($dataFim));

    // ✅ CALCULAR DIAS
    $numeroDias = (strtotime($dataFim) - strtotime($dataInicio)) / 86400 + 1;
    if ($numeroDias < 1) $numeroDias = 1;

    $viewData = [
        'dadosGraficoPorTipo' => [],
        'dadosGraficoPorMes' => ['dados' => [], 'meses' => []],
        'dadosGraficoPizza' => [],
        'dataInicioFormatada' => $dataInicioFormatada,
        'dataFimFormatada' => $dataFimFormatada,
        'dataInicio' => $dataInicio,
        'dataFim' => $dataFim,
        'totalRegistros' => 0,
        'erro' => null,
        'totalDespesas' => 0,
        'despesasPorTipo' => new Collection(),
        'graficoPorTipoLabels' => [],
        'graficoPorTipoData' => [],
        'graficoPorMesLabels' => [],
        'graficoPorMesData' => [],
        'mediaDiaria' => 0,
        'numeroDias' => $numeroDias,
        'maiorDespesa' => 0,
        'tipoMaiorDespesa' => '',
        'variacaoPercentual' => 0,
        'tiposContas' => $this->getTiposContas(),
    ];

    try {
        // ✅ BUSCAR DESPESAS
        $query = DB::table('despesas')
            ->whereNull('deleted_at');

        // ✅ FILTRAR POR DATA
        $query->where(function($q) use ($dataInicio, $dataFim) {
            $q->where('competencia', '>=', $dataInicio)
              ->where('competencia', '<=', $dataFim .  ' 23:59:59');
        });

        // ✅ FILTRAR POR TIPO DE CONTA
        if ($request->filled('tipo_conta')) {
            $query->where('tipoconta', $request->input('tipo_conta'));
        }

        $despesasRaw = $query->get();

        // ✅ DEBUG
        \Log::info('Despesas encontradas:', [
            'count' => $despesasRaw->count(),
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'tipoConta' => $request->input('tipo_conta', 'Todos')
        ]);

        if (! is_object($despesasRaw)) {
            $despesas = collect($despesasRaw);
        } else {
            $despesas = $despesasRaw;
        }

        if (! $despesas instanceof Collection) {
            $despesas = collect($despesas->toArray());
        }

        $viewData['totalRegistros'] = $despesas->count();

        if ($despesas->count() > 0) {
            // ✅ PROCESSAR DESPESAS POR TIPO
            $despesasPorTipo = $this->processarDespesasPorTipo($despesas);

            $ordenar = $request->input('ordenar', 'valor_desc');
            $despesasPorTipo = $this->ordenarDespesas($despesasPorTipo, $ordenar);

            // ✅ CALCULAR TOTAL
            $totalDespesas = 0;
            foreach ($despesasPorTipo as $item) {
                $totalDespesas += $item->total;
            }
            $viewData['totalDespesas'] = $totalDespesas;

            // ✅ MÉDIA DIÁRIA
            if ($numeroDias > 0) {
                $viewData['mediaDiaria'] = $totalDespesas / $numeroDias;
            }

            // ✅ MAIOR DESPESA
            if ($despesasPorTipo->count() > 0) {
                $maiorItem = null;
                $maiorValor = 0;
                foreach ($despesasPorTipo as $item) {
                    if ($item->total > $maiorValor) {
                        $maiorValor = $item->total;
                        $maiorItem = $item;
                    }
                }
                if ($maiorItem) {
                    $viewData['maiorDespesa'] = $maiorItem->total;
                    $tiposContas = $this->getTiposContas();
                    $viewData['tipoMaiorDespesa'] = $tiposContas[$maiorItem->tipoconta] ?? $maiorItem->tipoconta;
                }
            }

            // ✅ VARIAÇÃO PERCENTUAL
            $viewData['variacaoPercentual'] = $this->calcularVariacaoPercentual($dataInicio, $dataFim, $totalDespesas);

            // ✅ ORGANIZAR DADOS PARA GRÁFICOS
            $viewData['despesasPorTipo'] = $despesasPorTipo;

            $labels = [];
            $data = [];
            foreach ($despesasPorTipo as $item) {
                $tiposContas = $this->getTiposContas();
                $labels[] = $tiposContas[$item->tipoconta] ?? $item->tipoconta;
                $data[] = $item->total;
            }
            $viewData['graficoPorTipoLabels'] = $labels;
            $viewData['graficoPorTipoData'] = $data;

            $dadosPorMes = $this->processarDadosPorMes($despesas);
            $viewData['graficoPorMesLabels'] = array_keys($dadosPorMes['dados'] ?? []);
            $viewData['graficoPorMesData'] = array_values($dadosPorMes['dados'] ?? []);

            $viewData['dadosGraficoPorTipo'] = $this->processarDadosPorTipo($despesas);
            $viewData['dadosGraficoPorMes'] = $dadosPorMes;
            $viewData['dadosGraficoPizza'] = $this->processarDadosPizza($despesas);

            \Log::info('✅ Relatório gerado com sucesso:', [
                'totalDespesas' => $viewData['totalDespesas'],
                'totalRegistros' => $viewData['totalRegistros'],
                'dias' => $numeroDias
            ]);
        }

    } catch (\Throwable $e) {
        $viewData['erro'] = 'Erro ao processar relatório: ' . $e->getMessage();
        \Log::error('❌ Erro no relatório:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }

    return view('relatorios.despesas. index', $viewData);
}

    private function processarDespesasPorTipo($despesas)
    {
        $tiposContas = $this->getTiposContas();
        $agrupados = [];

        foreach ($despesas as $despesa) {
            $tipoConta = $despesa->tipoconta ??  '';
            // ✅ USAR valortotal
            $valor = $this->converterParaFloat($despesa->valortotal ??  $despesa->valor ??  0);

            if (!isset($agrupados[$tipoConta])) {
                $agrupados[$tipoConta] = (object)[
                    'tipoconta' => $tipoConta,
                    'total' => 0,
                    'count' => 0
                ];
            }

            $agrupados[$tipoConta]->total += $valor;
            $agrupados[$tipoConta]->count++;
        }

        return collect(array_values($agrupados));
    }

    private function ordenarDespesas($despesasPorTipo, $ordenar)
    {
        $array = $despesasPorTipo->toArray();

        switch ($ordenar) {
            case 'valor_asc':
                usort($array, function($a, $b) {
                    return $a->total <=> $b->total;
                });
                break;
            case 'nome_asc':
                $tiposContas = $this->getTiposContas();
                usort($array, function($a, $b) use ($tiposContas) {
                    $nomeA = $tiposContas[$a->tipoconta] ??  $a->tipoconta;
                    $nomeB = $tiposContas[$b->tipoconta] ?? $b->tipoconta;
                    return strcasecmp($nomeA, $nomeB);
                });
                break;
            case 'valor_desc':
            default:
                usort($array, function($a, $b) {
                    return $b->total <=> $a->total;
                });
                break;
        }

        return collect($array);
    }

    private function calcularVariacaoPercentual($dataInicio, $dataFim, $totalAtual)
    {
        try {
            $inicio = Carbon::parse($dataInicio);
            $fim = Carbon::parse($dataFim);
            $diasPeriodo = $inicio->diffInDays($fim);

            $inicioAnterior = $inicio->copy()->subDays($diasPeriodo + 1);
            $fimAnterior = $inicio->copy()->subDay();

            $totalAnterior = 0;
            // ✅ USAR DATE() E valortotal
            $despesasAnteriores = DB::table('despesas')
                ->whereBetween(DB::raw('DATE(competencia)'), [$inicioAnterior->format('Y-m-d'), $fimAnterior->format('Y-m-d')])
                ->whereNull('deleted_at')
                ->get();

            foreach ($despesasAnteriores as $despesa) {
                $totalAnterior += $this->converterParaFloat($despesa->valortotal ?? $despesa->valor ?? 0);
            }

            if ($totalAnterior > 0) {
                return (($totalAtual - $totalAnterior) / $totalAnterior) * 100;
            } elseif ($totalAtual > 0) {
                return 100;
            }

            return 0;
        } catch (\Exception $e) {

            return 0;
        }
    }

    private function processarDadosPorTipo($despesas)
    {
        $tiposContas = $this->getTiposContas();
        $agrupados = [];

        foreach ($despesas as $despesa) {
            if (isset($tiposContas[$despesa->tipoconta])) {
                $nomeTipo = $tiposContas[$despesa->tipoconta];
                // ✅ USAR valortotal
                $valor = $this->converterParaFloat($despesa->valortotal ?? $despesa->valor ?? 0);

                if (!isset($agrupados[$nomeTipo])) {
                    $agrupados[$nomeTipo] = 0;
                }
                $agrupados[$nomeTipo] += $valor;
            }
        }

        arsort($agrupados);
        return array_slice($agrupados, 0, 10, true);
    }

    private function processarDadosPorMes($despesas)
    {
        $agrupados = [];

        foreach ($despesas as $despesa) {
            try {
                $mes = Carbon::parse($despesa->competencia)->format('m/Y');
                // ✅ USAR valortotal
                $valor = $this->converterParaFloat($despesa->valortotal ?? $despesa->valor ?? 0);

                if (!isset($agrupados[$mes])) {
                    $agrupados[$mes] = 0;
                }
                $agrupados[$mes] += $valor;
            } catch (\Exception $e) {

            }
        }

        ksort($agrupados);
        return ['dados' => $agrupados, 'meses' => array_keys($agrupados)];
    }

    private function processarDadosPizza($despesas)
    {
        $tiposDocumentos = $this->getTiposDocumentos();
        $agrupados = [];

        foreach ($despesas as $despesa) {
            if (isset($tiposDocumentos[$despesa->tipodocumento])) {
                $nomeDocumento = $tiposDocumentos[$despesa->tipodocumento];
                // ✅ USAR valortotal
                $valor = $this->converterParaFloat($despesa->valortotal ?? $despesa->valor ?? 0);

                if (!isset($agrupados[$nomeDocumento])) {
                    $agrupados[$nomeDocumento] = 0;
                }
                $agrupados[$nomeDocumento] += $valor;
            }
        }

        arsort($agrupados);
        return $agrupados;
    }

    private function converterParaFloat($valor)
    {
        if (is_null($valor) || $valor === '' || $valor === 0) {
            return 0;
        }

        if (is_numeric($valor)) {
            return (float)$valor;
        }

        $valor = str_replace(['R$', '. ', ' '], '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = trim($valor);

        return (float)$valor;
    }

    private function getTiposContas()
    {
        return [
            '101' => 'Aluguel',
            '402' => 'Assessoria Contábil',
            '408' => 'Assessoria Jurídica',
            '102' => 'Conta de Água',
            '103' => 'Conta de Energia',
            '104' => 'Conta de Telefone',
            '105' => 'Contribuição Sindical',
            '106' => 'Despesas Previdenciárias (GPS)',
            '107' => 'FGTS',
            '221' => 'Fretes/Transportes',
            '108' => 'Internet',
            '109' => 'IPTU',
            '110' => 'Vale Refeição',
            '111' => 'Salário',
            '112' => '13º Salário',
            '113' => 'Férias',
            '114' => 'IRRF (Darf)',
            '115' => 'Medicina do Trabalho',
            '116' => 'Rescisão Trabalhista',
            '117' => 'Taxa Bancária',
            '118' => 'Uniformes',
            '119' => 'Honorários',
            '120' => 'Retirada Pró-Labore',
            '201' => 'Abastecimento da Frota',
            '202' => 'Alimentação',
            '203' => 'Comissão de Vnd e Gratificação',
            '204' => 'Hora Extra',
            '205' => 'Hospedagem',
            '206' => 'Pedágio',
            '207' => 'Manutenção Predial',
            '209' => 'Manutenção da Frota',
            '210' => 'Material de Consumo/Limpeza',
            '211' => 'Material de Escritório',
            '212' => 'Matéria Prima',
            '213' => 'Despesa Bancária e com Cartão',
            '214' => 'Despesa Eventual',
            '215' => 'IRPJ (Darf)',
            '216' => 'Saúde Pessoal e EPI',
            '217' => 'Serviços de Terceiros',
            '218' => 'Simples Nacional (DAS)',
            '219' => 'Seguros',
            '220' => 'Correios/Licitação/Sindicato',
            '222' => 'Tributo Municipal',
            '223' => 'Tributo Estadual (Dae)',
            '301' => 'Compra de Mercadoria Estoque',
            '302' => 'Propaganda e Publicidade',
            '303' => 'Consultoria e Assist Técnica',
            '304' => 'Treinamento',
            '305' => 'Software, Câmera, Som, TV',
            '306' => 'Compra de Imobilizado',
            '307' => 'Nova Sede',
            '401' => 'Empréstimos de Terceiros',
            '402' => 'Pagamento de empréstimos',
            '403' => 'Juros de empréstimos',
            '405' => 'Doação',
            '406' => 'Aumento de Capital',
            '407' => 'Adiantamento a Sócio',
            '501' => 'Receita da Locação',
            '502' => 'Receita de Vendas',
            '503' => 'Venda de Imobilizado'
        ];
    }

    private function getTiposDocumentos()
    {
        return [
            '1' => 'Boleto',
            '2' => 'Cartão',
            '3' => 'Cheque',
            '4' => 'Contrato',
            '5' => 'Darf',
            '6' => 'Débito aut',
            '7' => 'Duplicata',
            '8' => 'Honorário',
            '9' => 'N Fiscal',
            '10' => 'Pix',
            '11' => 'Outros'
        ];
    }

    public function exportar(Request $request, $formato)
    {
        // Implementar lógica de exportação
    }

    public function detalhesTipo(Request $request, $tipoConta)
    {
        $dataInicio = $request->input('data_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->input('data_fim', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // ✅ USAR DATE() E valortotal
        $despesas = DB::table('despesas')
            ->where('tipoconta', $tipoConta)
            ->whereBetween(DB::raw('DATE(competencia)'), [$dataInicio, $dataFim])
            ->whereNull('deleted_at')
            ->orderBy('competencia', 'desc')
            ->get()
            ->map(function($item) {
                $item->valor_numerico = $this->converterParaFloat($item->valortotal ??  $item->valor ?? 0);
                return $item;
            });

        $tiposContas = $this->getTiposContas();
        $tipoNome = $tiposContas[$tipoConta] ?? $tipoConta;

        $total = 0;
        foreach ($despesas as $despesa) {
            $total += $despesa->valor_numerico;
        }

        return response()->json([
            'tipo' => $tipoConta,
            'nome' => $tipoNome,
            'periodo' => ['inicio' => $dataInicio, 'fim' => $dataFim],
            'total' => $total,
            'quantidade' => $despesas->count(),
            'despesas' => $despesas
        ]);
    }


/**
 * Exibir relatório para impressão com filtros aplicados
 */
public function imprimir(Request $request)
{
    $dataInicio = $request->input('data_inicio');
    $dataFim = $request->input('data_fim');
    $tipoConta = $request->input('tipo_conta');  // ✅ NOVO

    if (empty($dataInicio)) {
        $dataInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
    }
    if (empty($dataFim)) {
        $dataFim = Carbon:: now()->endOfMonth()->format('Y-m-d');
    }

    try {
        $dataInicio = Carbon::parse($dataInicio)->format('Y-m-d');
        $dataFim = Carbon:: parse($dataFim)->format('Y-m-d');
    } catch (\Exception $e) {
        return back()->with('error', 'Formato de data inválido');
    }

    $dataInicioFormatada = Carbon::parse($dataInicio)->format('d/m/Y');
    $dataFimFormatada = Carbon::  parse($dataFim)->format('d/m/Y');

    try {
        // ✅ BUSCAR DESPESAS COM FILTROS
        $query = DB::table('despesas')
            ->whereDate('competencia', '>=', $dataInicio)
            ->whereDate('competencia', '<=', $dataFim)
            ->whereNull('deleted_at');

        // ✅ APLICAR FILTRO DE TIPO DE CONTA
        if (! empty($tipoConta)) {
            $query->where('tipoconta', $tipoConta);
        }

        $despesas = $query->get();

        // Debug
        \Log::info('Despesas encontradas:', [
            'count' => $despesas->count(),
            'filtros' => [
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFim,
                'tipo_conta' => $tipoConta
            ]
        ]);

        if (!  $despesas instanceof Collection) {
            $despesas = collect($despesas->toArray());
        }

        // ✅ PROCESSAR DESPESAS POR TIPO
        $despesasPorTipo = $this->processarDespesasPorTipo($despesas);

        // ✅ CALCULAR TOTAIS
        $totalDespesas = 0;
        foreach ($despesasPorTipo as $item) {
            $totalDespesas += $item->total;
        }

        $totalRegistros = $despesas->count();

        $startDate = Carbon::parse($dataInicio);
        $endDate = Carbon::  parse($dataFim);
        $numeroDias = max(1, $startDate->diffInDays($endDate) + 1);

        $mediaDiaria = $numeroDias > 0 ? $totalDespesas / $numeroDias : 0;

        // ✅ ENCONTRAR MAIOR DESPESA
        $maiorDespesa = 0;
        $tipoMaiorDespesa = 'N/A';

        if ($despesasPorTipo->count() > 0) {
            $maiorItem = $despesasPorTipo->sortByDesc('total')->first();
            if ($maiorItem) {
                $maiorDespesa = $maiorItem->total;
                $tiposContas = $this->getTiposContas();
                $tipoMaiorDespesa = $tiposContas[$maiorItem->tipoconta] ?? $maiorItem->tipoconta;
            }
        }

        $tiposContas = $this->getTiposContas();

        return view('relatorios.despesas.imprimir', [
            'despesasPorTipo' => $despesasPorTipo,
            'totalDespesas' => $totalDespesas,
            'totalRegistros' => $totalRegistros,
            'mediaDiaria' => $mediaDiaria,
            'maiorDespesa' => $maiorDespesa,
            'tipoMaiorDespesa' => $tipoMaiorDespesa,
            'tiposContas' => $tiposContas,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'dataInicioFormatada' => $dataInicioFormatada,
            'dataFimFormatada' => $dataFimFormatada,
            'numeroDias' => $numeroDias,
            'filtroTipoConta' => $tipoConta ?  ($tiposContas[$tipoConta] ?? $tipoConta) : 'Todos',  // ✅ NOVO
            'erro' => null
        ]);

    } catch (\Exception $e) {
        \Log::error('Erro ao gerar relatório:', ['error' => $e->getMessage()]);

        return view('relatorios.despesas. imprimir', [
            'despesasPorTipo' => collect(),
            'totalDespesas' => 0,
            'totalRegistros' => 0,
            'mediaDiaria' => 0,
            'maiorDespesa' => 0,
            'tipoMaiorDespesa' => 'N/A',
            'tiposContas' => $this->getTiposContas(),
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'dataInicioFormatada' => $dataInicioFormatada,
            'dataFimFormatada' => $dataFimFormatada,
            'numeroDias' => 0,
            'filtroTipoConta' => 'N/A',
            'erro' => 'Erro ao processar:    ' . $e->getMessage()
        ]);
    }
}


}
