<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Models\Equipamentos;
use App\Models\Clieforne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioAbastecimentoController extends Controller
{
    public function consumoVeiculos(Request $request)
    {
        $dataInicio = $request->data_inicio ?? now()->subDays(30)->format('Y-m-d');
        $dataFim = $request->data_fim ?? now()->format('Y-m-d');
        $veiculo = $request->veiculo;
        $combustivel = $request->combustivel;

        // Consumo por Veículo
        $query = DB::table('abastecimentos as a')
            ->join('equipamentos as e', 'a.veiculo', '=', 'e.id')
            ->whereBetween('a.datacad', [$dataInicio, $dataFim])
            ->whereNull('a.deleted_at')
            ->select([
                'a.veiculo',
                'e.codigo as codigo_veiculo',
                'e.modelo as modelo_veiculo',
                'e.categoria as categoria_veiculo',
                'a.combustivel',
                DB::raw('COUNT(*) as total_abastecimentos'),
                DB::raw('SUM(a.litros) as total_litros'),
                DB::raw('SUM(a.totala) as total_valor'),
                DB::raw('AVG(a.qtda) as preco_medio_litro'),
                DB::raw('MAX(a.km) as km_atual'),
                DB::raw('MIN(a.km) as km_inicial')
            ])
            ->groupBy('a.veiculo', 'e.codigo', 'e.modelo', 'e.categoria', 'a.combustivel');

        if ($veiculo) {
            $query->where('a.veiculo', $veiculo);
        }

        if ($combustivel) {
            $query->where('a.combustivel', $combustivel);
        }

        $consumoPorVeiculo = $query->get();

        // Calcular consumo médio (km/l) para cada veículo
        foreach ($consumoPorVeiculo as $consumo) {
            $kmPercorrido = $consumo->km_atual - $consumo->km_inicial;
            $consumo->consumo_medio = $kmPercorrido > 0 && $consumo->total_litros > 0 ?
                $kmPercorrido / $consumo->total_litros : 0;
            $consumo->custo_km = $kmPercorrido > 0 ? $consumo->total_valor / $kmPercorrido : 0;
        }

        $veiculos = Equipamentos::whereNull('deleted_at')->get();

        $tiposCombustivel = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];

        return view('relatorios.abastecimentos.consumo-veiculos', compact(
            'consumoPorVeiculo',
            'veiculos',
            'tiposCombustivel',
            'dataInicio',
            'dataFim',
            'veiculo',
            'combustivel'
        ));
    }

    public function consumoFornecedores(Request $request)
    {
        $dataInicio = $request->data_inicio ?? now()->subDays(30)->format('Y-m-d');
        $dataFim = $request->data_fim ?? now()->format('Y-m-d');
        $fornecedor = $request->fornecedor;
        $combustivel = $request->combustivel;

        $query = DB::table('abastecimentos as a')
            ->join('cliefornes as c', 'a.fornecedor', '=', 'c.id')
            ->whereBetween('a.datacad', [$dataInicio, $dataFim])
            ->whereNull('a.deleted_at')
            ->select([
                'a.fornecedor',
                'c.nome as nome_fornecedor',
                'a.combustivel',
                DB::raw('COUNT(*) as total_abastecimentos'),
                DB::raw('SUM(a.litros) as total_litros'),
                DB::raw('SUM(a.totala) as total_valor'),
                DB::raw('AVG(a.qtda) as preco_medio_litro')
            ])
            ->groupBy('a.fornecedor', 'c.nome', 'a.combustivel')
            ->orderBy('total_valor', 'desc');

        if ($fornecedor) {
            $query->where('a.fornecedor', $fornecedor);
        }

        if ($combustivel) {
            $query->where('a.combustivel', $combustivel);
        }

        $consumoPorFornecedor = $query->get();

        $fornecedores = Clieforne::whereNull('deleted_at')->get();

        $tiposCombustivel = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];

        return view('relatorios.abastecimentos.consumo-fornecedores', compact(
            'consumoPorFornecedor',
            'fornecedores',
            'tiposCombustivel',
            'dataInicio',
            'dataFim',
            'fornecedor',
            'combustivel'
        ));
    }

    public function consumoCombustiveis(Request $request)
    {
        $dataInicio = $request->data_inicio ?? now()->subDays(30)->format('Y-m-d');
        $dataFim = $request->data_fim ?? now()->format('Y-m-d');

        $consumoPorCombustivel = DB::table('abastecimentos')
            ->whereBetween('datacad', [$dataInicio, $dataFim])
            ->whereNull('deleted_at')
            ->select([
                'combustivel',
                DB::raw('COUNT(*) as total_abastecimentos'),
                DB::raw('SUM(litros) as total_litros'),
                DB::raw('SUM(totala) as total_valor'),
                DB::raw('AVG(qtda) as preco_medio_litro')
            ])
            ->groupBy('combustivel')
            ->orderBy('total_valor', 'desc')
            ->get();

        $tiposCombustivel = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];

        return view('relatorios.abastecimentos.consumo-combustiveis', compact(
            'consumoPorCombustivel',
            'tiposCombustivel',
            'dataInicio',
            'dataFim'
        ));
    }

    public function evolucaoMensal(Request $request)
    {
        $ano = $request->ano ?? date('Y');
        $combustivel = $request->combustivel;

        $query = DB::table('abastecimentos')
            ->whereYear('datacad', $ano)
            ->whereNull('deleted_at')
            ->select([
                DB::raw('MONTH(datacad) as mes'),
                DB::raw('YEAR(datacad) as ano'),
                'combustivel',
                DB::raw('SUM(litros) as total_litros'),
                DB::raw('SUM(totala) as total_valor'),
                DB::raw('COUNT(*) as total_abastecimentos')
            ])
            ->groupBy('ano', 'mes', 'combustivel')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc');

        if ($combustivel) {
            $query->where('combustivel', $combustivel);
        }

        $evolucaoMensal = $query->get();

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

        $tiposCombustivel = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];

        return view('relatorios.abastecimentos.evolucao-mensal', compact(
            'evolucaoMensal',
            'meses',
            'tiposCombustivel',
            'ano',
            'combustivel'
        ));
    }
}
