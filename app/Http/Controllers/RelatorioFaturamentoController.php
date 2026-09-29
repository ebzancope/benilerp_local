<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clieforne;
use App\Models\Colaboradores;
use App\Models\Equipamentos;

class RelatorioFaturamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('view_os_faturas')
            ->select('*')
            ->whereNull('deleted_at');

        // Filtros
        if ($request->filled('cliente')) {
            $query->where('idclie', $request->cliente);
        }

        if ($request->filled('equipamento')) {
            $query->where('idequip', $request->equipamento);
        }

        if ($request->filled('operador')) {
            $query->where('idcolab', $request->operador);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('datacadfat', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('datacadfat', '<=', $request->data_fim);
        }

        if ($request->filled('status')) {
            $query->where('aprovada', $request->status);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'datacadfat');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        // Executar query
        $faturas = $query->whereNull('deleted_at')->get();

        // Cálculos totais
        $totais = $this->calcularTotais($faturas);

        // Dados para filtros
        $clientes = Clieforne::orderBy('nome')->whereNull('deleted_at')->get();
        $operadores = Colaboradores::where('ativo', '1')->orderBy('nome')->whereNull('deleted_at')->get();
        $equipamentos = Equipamentos::orderBy('codigo')->whereNull('deleted_at')->get();

        // Agrupamentos para gráficos
        $agrupamentos = $this->agruparDados($faturas, $request->get('agrupar_por', 'cliente'));

        return view('relatorios.faturamento.index', compact(
            'faturas',
            'totais',
            'clientes',
            'operadores',
            'equipamentos',
            'agrupamentos'
        ));
    }

    private function calcularTotais($faturas)
    {
        return [
            'total_faturamento' => $faturas->sum('totmaquina') + $faturas->sum('totala'),
            'total_horas' => $faturas->sum('tothmaquina'),
            'total_maquina' => $faturas->sum('totmaquina'),
            'total_acessorios' => $faturas->sum('totala'),
            'quantidade_os' => $faturas->count(),
            'media_hora' => $faturas->avg('valhora'),
            'media_horas_por_os' => $faturas->avg('tothmaquina'),
        ];
    }

    private function agruparDados($faturas, $agruparPor = 'cliente')
    {
        $agrupados = [];

        foreach ($faturas as $fatura) {
            $chave = '';

            switch ($agruparPor) {
                case 'cliente':
                    $chave = $fatura->nome . ' (' . $fatura->apelido . ')';
                    break;
                case 'equipamento':
                    $chave = $fatura->codigo . ' - ' . $fatura->modelo;
                    break;
                case 'operador':
                    $chave = $fatura->nomeclie;
                    break;
                case 'mes':
                    $chave = date('m/Y', strtotime($fatura->datacadfat));
                    break;
                case 'dia':
                    $chave = date('d/m/Y', strtotime($fatura->datacadfat));
                    break;
                default:
                    $chave = $fatura->nome;
            }

            if (!isset($agrupados[$chave])) {
                $agrupados[$chave] = [
                    'total_faturamento' => 0,
                    'total_horas' => 0,
                    'quantidade_os' => 0,
                    'media_hora' => 0,
                ];
            }

            $agrupados[$chave]['total_faturamento'] += ($fatura->totmaquina + $fatura->totala);
            $agrupados[$chave]['total_horas'] += $fatura->tothmaquina;
            $agrupados[$chave]['quantidade_os']++;
        }

        // Calcular médias
        foreach ($agrupados as &$grupo) {
            if ($grupo['total_horas'] > 0) {
                $grupo['media_hora'] = $grupo['total_faturamento'] / $grupo['total_horas'];
            }
        }

        // Ordenar por faturamento
        uasort($agrupados, function($a, $b) {
            return $b['total_faturamento'] <=> $a['total_faturamento'];
        });

        return $agrupados;
    }

    public function exportarExcel(Request $request)
    {
        $faturas = DB::table('view_os_faturas')
            ->whereNull('deleted_at')
            ->when($request->filled('data_inicio'), function($q) use ($request) {
                $q->whereDate('datacadfat', '>=', $request->data_inicio);
            })
            ->when($request->filled('data_fim'), function($q) use ($request) {
                $q->whereDate('datacadfat', '<=', $request->data_fim);
            })
            ->orderBy('datacadfat', 'desc')
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=relatorio_faturamento_" . date('Ymd_His') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($faturas) {
            $file = fopen('php://output', 'w');

            // Cabeçalho
            fputcsv($file, [
                'OS', 'Data', 'Cliente', 'Equipamento', 'Operador',
                'Horas Trabalhadas', 'Valor Hora', 'Total Máquina',
                'Total Acessórios', 'Total Faturamento', 'Status'
            ]);

            // Dados
            foreach ($faturas as $fatura) {
                fputcsv($file, [
                    $fatura->numos,
                    date('d/m/Y', strtotime($fatura->datacadfat)),
                    $fatura->nome,
                    $fatura->codigo . ' - ' . $fatura->modelo,
                    $fatura->nomeclie,
                    number_format($fatura->tothmaquina, 2, ',', '.'),
                    'R$ ' . number_format($fatura->valhora, 2, ',', '.'),
                    'R$ ' . number_format($fatura->totmaquina, 2, ',', '.'),
                    'R$ ' . number_format($fatura->totala, 2, ',', '.'),
                    'R$ ' . number_format(($fatura->totmaquina + $fatura->totala), 2, ',', '.'),
                    $fatura->aprovada ? 'Aprovada' : 'Pendente'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function dashboard()
    {
        // Dados para dashboard
        $mesAtual = date('Y-m');
        $mesAnterior = date('Y-m', strtotime('-1 month'));

        // Faturamento do mês atual
        $faturamentoMesAtual = DB::table('view_os_faturas')
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->where(DB::raw('DATE_FORMAT(datacadfat, "%Y-%m")'), $mesAtual)
            ->sum(DB::raw('totmaquina + totala'));

        // Faturamento mês anterior
        $faturamentoMesAnterior = DB::table('view_os_faturas')
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->where(DB::raw('DATE_FORMAT(datacadfat, "%Y-%m")'), $mesAnterior)
            ->sum(DB::raw('totmaquina + totala'));

        // Total de horas mês atual
        $horasMesAtual = DB::table('view_os_faturas')
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->where(DB::raw('DATE_FORMAT(datacadfat, "%Y-%m")'), $mesAtual)
            ->sum('tothmaquina');

        // Clientes atendidos mês atual
        $clientesMesAtual = DB::table('view_os_faturas')
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->where(DB::raw('DATE_FORMAT(datacadfat, "%Y-%m")'), $mesAtual)
            ->distinct('idclie')
            ->count('idclie');

        // Equipamentos mais utilizados
        $equipamentosTop = DB::table('view_os_faturas')
            ->select('codigo', 'modelo', DB::raw('COUNT(*) as total_os'), DB::raw('SUM(tothmaquina) as total_horas'))
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->groupBy('codigo', 'modelo')
            ->orderByDesc('total_horas')
            ->limit(5)
            ->get();

        // Clientes que mais faturam
        $clientesTop = DB::table('view_os_faturas')
            ->select('nome', 'apelido', DB::raw('SUM(totmaquina + totala) as total_faturado'))
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->groupBy('nome', 'apelido')
            ->orderByDesc('total_faturado')
            ->limit(5)
            ->get();

        // Faturamento por mês (últimos 12 meses)
        $faturamentoMensal = DB::table('view_os_faturas')
            ->select(
                DB::raw('DATE_FORMAT(datacadfat, "%Y-%m") as mes'),
                DB::raw('SUM(totmaquina + totala) as total')
            )
            ->whereNull('deleted_at')
            ->where('aprovada', 1)
            ->where('datacadfat', '>=', date('Y-m-01', strtotime('-11 months')))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('relatorios.faturamento.dashboard', compact(
            'faturamentoMesAtual',
            'faturamentoMesAnterior',
            'horasMesAtual',
            'clientesMesAtual',
            'equipamentosTop',
            'clientesTop',
            'faturamentoMensal'
        ));
    }
}
