<?php

namespace App\Http\Controllers;

use App\Models\Despesas; // Note o plural
use App\Models\Receita;
use App\Models\Clieforne;
use Illuminate\Http\Request;
use App\Models\AlmoxarifadoItem; // NOVO
use App\Models\AlmoxarifadoMovimentacao; // NOVO
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()

    {


        $anoAtual = date('Y');
        $mesAtual = date('m');

        // Resumo do Mês Atual
        $resumoMes = $this->getResumoMes($anoAtual, $mesAtual);

        // Gráfico Despesas vs Receitas (últimos 6 meses)
        $graficoMensal = $this->getGraficoMensal();

        // Despesas por Categoria (mês atual)
        $despesasPorCategoria = $this->getDespesasPorCategoria($anoAtual, $mesAtual);

        // Alertas de Vencimentos
        $alertasVencimento = $this->getAlertasVencimento();

        // Últimas Movimentações
        $ultimasDespesas = $this->getUltimasDespesas();

        // Estatísticas Rápidas
        $estatisticas = $this->getEstatisticas();

        return view('dashboard.index', compact(
            'resumoMes',
            'graficoMensal',
            'despesasPorCategoria',
            'alertasVencimento',
            'ultimasDespesas',
            'estatisticas'
        ));
    }


    // **NOVO: Método para dados do Almoxarifado**
    private function getDadosAlmoxarifado()
    {
        // Estatísticas gerais
        $totalItens = AlmoxarifadoItem::count();
        $valorTotalEstoque = AlmoxarifadoItem::sum(DB::raw('quantidade_atual * custo_medio'));
        $itensBaixoEstoque = AlmoxarifadoItem::whereRaw('quantidade_atual <= quantidade_minima')->count();
        $itensEsgotados = AlmoxarifadoItem::where('quantidade_atual', '<=', 0)->count();

        // Movimentações do mês
        $mesAtual = date('Y-m');
        $movimentacoesMes = AlmoxarifadoMovimentacao::where('data_movimentacao', 'LIKE', "{$mesAtual}%")
            ->select(
                DB::raw('COUNT(*) as total_movimentacoes'),
                DB::raw('SUM(CASE WHEN tipo = "entrada" THEN quantidade ELSE 0 END) as entradas'),
                DB::raw('SUM(CASE WHEN tipo = "saida" THEN quantidade ELSE 0 END) as saidas'),
                DB::raw('SUM(CASE WHEN tipo = "entrada" THEN valor_total ELSE 0 END) as valor_entradas'),
                DB::raw('SUM(CASE WHEN tipo = "saida" THEN valor_total ELSE 0 END) as valor_saidas')
            )
            ->first();

        // Itens mais movimentados (últimos 30 dias)
        $itensMaisMovimentados = AlmoxarifadoMovimentacao::with('item')
            ->where('data_movimentacao', '>=', now()->subDays(30))
            ->select('item_id', DB::raw('SUM(quantidade) as total_movimentado'))
            ->groupBy('item_id')
            ->orderByDesc('total_movimentado')
            ->limit(5)
            ->get();

        // Alertas de estoque baixo
        $alertasEstoque = AlmoxarifadoItem::with('fornecedor')
            ->whereRaw('quantidade_atual <= quantidade_minima')
            ->orderBy('quantidade_atual')
            ->limit(5)
            ->get();

        return [
            'estatisticas' => [
                'total_itens' => $totalItens,
                'valor_total_estoque' => (float) $valorTotalEstoque,
                'itens_baixo_estoque' => $itensBaixoEstoque,
                'itens_esgotados' => $itensEsgotados,
            ],
            'movimentacoes_mes' => [
                'total' => $movimentacoesMes->total_movimentacoes ?? 0,
                'entradas' => (float) ($movimentacoesMes->entradas ?? 0),
                'saidas' => (float) ($movimentacoesMes->saidas ?? 0),
                'valor_entradas' => (float) ($movimentacoesMes->valor_entradas ?? 0),
                'valor_saidas' => (float) ($movimentacoesMes->valor_saidas ?? 0),
            ],
            'itens_mais_movimentados' => $itensMaisMovimentados,
            'alertas_estoque' => $alertasEstoque
        ];
    }

    private function getResumoMes($ano, $mes)
    {
        $inicioMes = "{$ano}-{$mes}-01";
        $fimMes = date('Y-m-t', strtotime($inicioMes));

        $totalDespesas = Despesas::whereBetween('competencia', [$inicioMes, $fimMes])
            ->whereNull('deleted_at')
            ->sum(DB::raw('CAST(valor as DECIMAL(10,2))'));

        $totalReceitas = 0; // Receita::whereBetween('data', [$inicioMes, $fimMes])->sum('valor');

        // **NOVO: Valor de entradas no almoxarifado**
        $valorEntradasAlmoxarifado = AlmoxarifadoMovimentacao::whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->where('tipo', 'entrada')
            ->sum('valor_total');

        $saldo = $totalReceitas - $totalDespesas;

        return [
            'total_despesas' => (float) $totalDespesas,
            'total_receitas' => (float) $totalReceitas,
            'valor_entradas_almoxarifado' => (float) $valorEntradasAlmoxarifado, // NOVO
            'saldo' => $saldo,
            'mes_referencia' => $this->getNomeMes($mes) . ' / ' . $ano
        ];
    }

    private function getGraficoMensal()
    {
        $seisMesesAtras = Carbon::now()->subMonths(5)->startOfMonth();

        $dados = Despesas::where('competencia', '>=', $seisMesesAtras)
            ->whereNull('deleted_at')
            ->select(
                DB::raw('YEAR(competencia) as ano'),
                DB::raw('MONTH(competencia) as mes'),
                DB::raw('SUM(CAST(valor as DECIMAL(10,2))) as total_despesas')
            )
            ->groupBy('ano', 'mes')
            ->orderBy('ano')
            ->orderBy('mes')
            ->get();

        $labels = [];
        $despesas = [];

        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mes = $data->month;
            $ano = $data->year;

            $labels[] = $this->getNomeMesAbreviado($mes) . '/' . $ano;

            $encontrado = $dados->first(function ($item) use ($mes, $ano) {
                return $item->mes == $mes && $item->ano == $ano;
            });

            $despesas[] = $encontrado ? $encontrado->total_despesas : 0;
            $receitas[] = 0; // Substitua quando tiver receitas
        }

        return [
            'labels' => $labels,
            'despesas' => $despesas,
            'receitas' => $receitas
        ];
    }

    private function getDespesasPorCategoria($ano, $mes)
    {
        $inicioMes = "{$ano}-{$mes}-01";
        $fimMes = date('Y-m-t', strtotime($inicioMes));

        return Despesas::whereBetween('competencia', [$inicioMes, $fimMes])
            ->whereNull('deleted_at')
            ->select('tipoconta', DB::raw('SUM(CAST(valor as DECIMAL(10,2))) as total'))
            ->groupBy('tipoconta')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                $item->total = (float) $item->total;
                $item->categoria_nome = $this->getNomeCategoria($item->tipoconta);
                return $item;
            });
    }

    private function getAlertasVencimento()
    {
        // Implemente quando tiver contas a pagar
        return [];
    }

    private function getUltimasDespesas()
    {
        return Despesas::with(['clieforne']) // Relacionamento correto
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
    }

    private function getEstatisticas()
    {
        $mesAtual = date('m');
        $anoAtual = date('Y');
        $mesAnterior = date('m', strtotime('-1 month'));

        // Despesas do mês atual
        $despesasMesAtual = Despesas::whereYear('competencia', $anoAtual)
            ->whereMonth('competencia', $mesAtual)
            ->whereNull('deleted_at')
            ->sum(DB::raw('CAST(valor as DECIMAL(10,2))'));

        // Despesas do mês anterior
        $despesasMesAnterior = Despesas::whereYear('competencia', $mesAnterior == 12 ? $anoAtual - 1 : $anoAtual)
            ->whereMonth('competencia', $mesAnterior)
            ->whereNull('deleted_at')
            ->sum(DB::raw('CAST(valor as DECIMAL(10,2))'));

        // Variação percentual
        $variacao = $despesasMesAnterior > 0 ?
            (($despesasMesAtual - $despesasMesAnterior) / $despesasMesAnterior) * 100 : 0;

        return [
            'despesas_mes_atual' => (float) $despesasMesAtual,
            'despesas_mes_anterior' => (float) $despesasMesAnterior,
            'variacao_despesas' => $variacao,
            'total_despesas_ano' => (float) Despesas::whereYear('competencia', $anoAtual)
                ->whereNull('deleted_at')
                ->sum(DB::raw('CAST(valor as DECIMAL(10,2))')),
            'quantidade_despesas_mes' => Despesas::whereYear('competencia', $anoAtual)
                ->whereMonth('competencia', $mesAtual)
                ->whereNull('deleted_at')
                ->count()
        ];
    }

    // Métodos auxiliares (mantenha os mesmos)
    private function getNomeMes($mes)
    {
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];
        return $meses[$mes] ?? '';
    }

    private function getNomeMesAbreviado($mes)
    {
        $meses = [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez'
        ];
        return $meses[$mes] ?? '';
    }

    private function getNomeCategoria($codigo)
    {
        $categorias = $this->getTiposContas();
        return $categorias[$codigo] ?? $codigo;
    }

    private function getTiposContas()
    {
        return [
            '101' => 'Aluguel',
            '102' => 'Água',
            '103' => 'Energia',
            '104' => 'Telefone',
            '105' => 'Sindical',
            '106' => 'Previdência',
            '107' => 'FGTS',
            '108' => 'Internet',
            // ... resto dos tipos (mantenha igual ao anterior)
            '503' => 'Venda de Imobilizado'
        ];
    }
}
