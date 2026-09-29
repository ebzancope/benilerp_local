<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioDespesaController extends Controller
{
    public function index(Request $request)
    {
        $tiposContas = $this->getTiposContas();

        $dataInicio = $request->input('data_inicio', date('Y-m-01'));
        $dataFim = $request->input('data_fim', date('Y-m-t'));

        // Dados para gráficos
        $despesasPorTipo = $this->getDespesasPorTipo($dataInicio, $dataFim);
        $despesasPorMes = $this->getDespesasPorMes($dataInicio, $dataFim);
        $totalDespesas = $this->getTotalDespesas($dataInicio, $dataFim);

        // Preparar dados para os gráficos
        $graficoPorTipoLabels = $this->getLabelsPorTipo($despesasPorTipo, $tiposContas);
        $graficoPorTipoData = $this->getDataPorTipo($despesasPorTipo);
        $graficoPorMesLabels = $this->getLabelsPorMes($despesasPorMes);
        $graficoPorMesData = $this->getDataPorMes($despesasPorMes);

        return view('relatorios.despesas.index', compact(
            'despesasPorTipo',
            'despesasPorMes',
            'totalDespesas',
            'dataInicio',
            'dataFim',
            'tiposContas',
            'graficoPorTipoLabels',
            'graficoPorTipoData',
            'graficoPorMesLabels',
            'graficoPorMesData'
        ));
    }

    // Métodos auxiliares para preparar os dados dos gráficos
    private function getLabelsPorTipo($despesasPorTipo, $tiposContas)
    {
        $labels = [];
        foreach ($despesasPorTipo as $item) {
            $labels[] = $tiposContas[$item->tipoconta] ?? $item->tipoconta;
        }
        return $labels;
    }

    private function getDataPorTipo($despesasPorTipo)
    {
        $data = [];
        foreach ($despesasPorTipo as $item) {
            $data[] = $item->total;
        }
        return $data;
    }

    private function getLabelsPorMes($despesasPorMes)
    {
        $labels = [];
        foreach ($despesasPorMes as $item) {
            $labels[] = $item->mes . '/' . $item->ano;
        }
        return $labels;
    }

    private function getDataPorMes($despesasPorMes)
    {
        $data = [];
        foreach ($despesasPorMes as $item) {
            $data[] = $item->total;
        }
        return $data;
    }

    private function getDespesasPorTipo($dataInicio, $dataFim)
    {
        return Despesas::whereBetween('competencia', [$dataInicio, $dataFim])
            ->whereNull('deleted_at')
            ->select('tipoconta', DB::raw('SUM(CAST(valor as DECIMAL(10,2))) as total'))
            ->groupBy('tipoconta')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                $item->total = (float) $item->total;
                return $item;
            });
    }

    private function getDespesasPorMes($dataInicio, $dataFim)
    {
        return Despesas::whereBetween('competencia', [$dataInicio, $dataFim])
            ->whereNull('deleted_at')
            ->select(
                DB::raw('YEAR(competencia) as ano'),
                DB::raw('MONTH(competencia) as mes'),
                DB::raw('SUM(CAST(valor as DECIMAL(10,2))) as total')
            )
            ->groupBy('ano', 'mes')
            ->orderBy('ano')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                $item->total = (float) $item->total;
                return $item;
            });
    }

    private function getTotalDespesas($dataInicio, $dataFim)
    {
        $total = Despesas::whereBetween('competencia', [$dataInicio, $dataFim])
            ->whereNull('deleted_at')
            ->sum(DB::raw('CAST(valor as DECIMAL(10,2))'));

        return (float) $total;
    }

    // Adicione este método para ter acesso aos tipos de conta
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
}
