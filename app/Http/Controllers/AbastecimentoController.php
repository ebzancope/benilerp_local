<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Models\Equipamentos;
use App\Models\Clieforne;
use App\Models\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbastecimentoController extends Controller
{

    // No AbastecimentoController - método index
    // No método index do AbastecimentoController
    public function index(Request $request)

    {

         session(['place' => '5']);

        $query = Abastecimento::with(['veiculoInfo', 'fornecedorInfo']);

        // Aplicar filtros...
        if ($request->has('veiculo') && $request->veiculo != '') {
            $query->where('veiculo', $request->veiculo);
        }

        if ($request->has('fornecedor') && $request->fornecedor != '') {
            $query->where('fornecedor', $request->fornecedor);
        }

        if ($request->has('combustivel') && $request->combustivel != '') {
            $query->where('combustivel', $request->combustivel);
        }

        if ($request->has('data_inicio') && $request->data_inicio != '') {
            $query->whereDate('datacad', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim') && $request->data_fim != '') {
            $query->whereDate('datacad', '<=', $request->data_fim);
        }

        // **DADOS PARA PAGINAÇÃO**
        $abastecimentos = $query->orderBy('datacad', 'desc')->paginate(15);

        // **DADOS PARA TOTAIS - USANDO AGREGADOS DO BANCO**
        $totais = [
            'total_registros' => $query->count(),
            'total_litros' => $query->sum('litros') ?? 0,
            'total_valor' => $query->sum('totala') ?? 0,
            'preco_medio' => $query->avg('qtda') ?? 0
        ];

        // Outros dados...
        $veiculos = Equipamentos::all();
        $fornecedores = Clieforne::all();
        $tiposCombustivel = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];

        return view('abastecimentos.index', compact(
            'abastecimentos',
            'totais',
            'veiculos',
            'fornecedores',
            'tiposCombustivel'
        ));
    }

    public function create()
    {
        $veiculos = Equipamentos::whereNull('deleted_at')->get();
        $fornecedores = Clieforne::whereNull('deleted_at')->orderBy('nome')->get();
       $colaboradores = Colaboradores::whereNull('deleted_at')
        ->orderBy('nome') // ascending (A–Z)
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

        $tiposAbastecimento = [
            1 => 'Normal',
            2 => 'Completo',
            3 => 'Parcial',
            4 => 'Emergencial'
        ];

        return view('abastecimentos.create', compact(
            'veiculos',
            'fornecedores',
            'colaboradores',
            'tiposCombustivel',
            'tiposAbastecimento'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'datacad' => 'required|date',
            'veiculo' => 'required|exists:equipamentos,id',
            'fornecedor' => 'required|exists:cliefornes,id',
            'litros' => 'required|numeric|min:0.001',
            'combustivel' => 'required|integer',
            'qtda' => 'required|numeric|min:0.001',
            'totala' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::beginTransaction();

            Abastecimento::create([
                'user_id' =>  session('user.id'),
                'datacad' => $request->datacad,
                'fornecedor' => $request->fornecedor,
                'requisicao' => $request->requisicao,
                'veiculo' => $request->veiculo,
                'colaborador' => $request->colaborador,
                'litros' => $request->litros,
                'descricao' => $request->descricao,
                'combustivel' => $request->combustivel,
                'qtda' => $request->qtda,
                'desconto' => $request->desconto ?? 0,
                'totala' => $request->totala,
                'km' => $request->km,
                'horimini' => $request->horimini,
                'tipo' => $request->tipo ?? 1
            ]);

            DB::commit();

            return redirect()->route('abastecimentos.index')
                ->with('success', 'Abastecimento registrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao registrar abastecimento: ' . $e->getMessage());
        }
    }

    public function show(Abastecimento $abastecimento)
    {
        $abastecimento->load(['veiculoInfo', 'fornecedorInfo', 'colaboradorInfo', 'usuario']);
        return view('abastecimentos.show', compact('abastecimento'));
    }

    public function edit(Abastecimento $abastecimento)
    {
        $veiculos = Equipamentos::whereNull('deleted_at')->get();
        $fornecedores = Clieforne::whereNull('deleted_at')->get();
        $colaboradores = Colaboradores::whereNull('deleted_at')->get();

        $tiposCombustivel = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];

        $tiposAbastecimento = [
            1 => 'Normal',
            2 => 'Completo',
            3 => 'Parcial',
            4 => 'Emergencial'
        ];

        return view('abastecimentos.edit', compact(
            'abastecimento',
            'veiculos',
            'fornecedores',
            'colaboradores',
            'tiposCombustivel',
            'tiposAbastecimento'
        ));
    }

    public function update(Request $request, Abastecimento $abastecimento)
    {
        $request->validate([
            'datacad' => 'required|date',
            'veiculo' => 'required|exists:equipamentos,id',
            'fornecedor' => 'required|exists:cliefornes,id',
            'litros' => 'required|numeric|min:0.001',
            'combustivel' => 'required|integer',
            'qtda' => 'required|numeric|min:0.001',
            'totala' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::beginTransaction();

            $abastecimento->update($request->all());

            DB::commit();

            return redirect()->route('abastecimentos.index')
                ->with('success', 'Abastecimento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar abastecimento: ' . $e->getMessage());
        }
    }

    public function destroy(Abastecimento $abastecimento)
    {
        try {
            $abastecimento->delete();
            return redirect()->route('abastecimentos.index')
                ->with('success', 'Abastecimento excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir abastecimento: ' . $e->getMessage());
        }
    }
}
