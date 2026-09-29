<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EquipamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipamentos::with(['usuario'])->ativos();

        // Filtros
        if ($request->categoria) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->marca) {
            $query->where('marca', 'like', "%{$request->marca}%");
        }

        if ($request->placa) {
            $query->where('placa', 'like', "%{$request->placa}%");
        }

        if ($request->modelo) {
            $query->where('modelo', 'like', "%{$request->modelo}%");
        }

        // Busca por código
        if ($request->codigo) {
            $query->where('codigo', 'like', "%{$request->codigo}%");
        }

        $equipamentos = $query->orderBy('codigo')->paginate(20);

        // Totais para os cards
        $totalEquipamentos = Equipamentos::ativos()->count();
        $totalComPlaca = Equipamentos::ativos()->whereNotNull('placa')->count();
        $totalSemPlaca = Equipamentos::ativos()->whereNull('placa')->count();
        $categoriasCount = Equipamentos::ativos()->distinct()->pluck('categoria')->count();

        // Agrupar por categoria para os cards
        $equipamentosPorCategoria = Equipamentos::ativos()
            ->select('categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('categoria')
            ->get();

        $categorias = Equipamentos::ativos()->distinct()->pluck('categoria');
        $marcas = Equipamentos::ativos()->distinct()->pluck('marca');

        return view('equipamentos.index', compact(
            'equipamentos',
            'categorias',
            'marcas',
            'totalEquipamentos',
            'totalComPlaca',
            'totalSemPlaca',
            'categoriasCount',
            'equipamentosPorCategoria'
        ));
    }

    public function create()
    {
        $categoriasComuns = ['Caminhão', 'Carro', 'Moto', 'Trator', 'Colheitadeira', 'Pulverizador', 'Implemento', 'Máquina', 'Equipamento', 'Ônibus', 'Caminhonete', 'Reboque'];
        return view('equipamentos.create', compact('categoriasComuns'));
    }

    public function store(Request $request)
    {

    $valor = str_replace('.', '', $request->valor); // remove milhar
    $valor = str_replace(',', '.', $valor);        // troca vírgula por ponto
    $request->merge(['valor' => $valor]);



        $request->validate([
            'codigo' => 'required|string|max:255|unique:equipamentos,codigo',
            'modelo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
            'ano' => 'nullable|string|max:4',
            'chassi' => 'nullable|string|max:255',
            'renavam' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'valor' => 'nullable|numeric|min:0',
            'venc' => 'nullable|date'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['user_id'] = session('user.id');

            // Upload da imagem
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('equipamentos', $imageName, 'public');
                $data['image'] = $imageName;
            }

            // Formatar valor se necessário
            if ($request->filled('valor')) {
                $data['valor'] = str_replace(['.', ','], ['', '.'], $request->valor);
            }

            Equipamentos::create($data);

            DB::commit();

            return redirect()->route('equipamentos.index')
                ->with('success', 'Equipamento cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao cadastrar equipamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $equipamento = Equipamentos::with(['usuario', 'abastecimentos', 'manutencoes'])
            ->findOrFail($id);

        // Estatísticas
        $totalAbastecimentos = $equipamento->abastecimentos->count();
        $totalGastoAbastecimento = $equipamento->custoTotalAbastecimento();
        $consumoMedio = $equipamento->consumoMedio();
        $totalManutencoes = $equipamento->manutencoes->count();
        $custoTotalManutencao = $equipamento->manutencoes->sum('valor');

        return view('equipamentos.show', compact(
            'equipamento',
            'totalAbastecimentos',
            'totalGastoAbastecimento',
            'consumoMedio',
            'totalManutencoes',
            'custoTotalManutencao'
        ));
    }

    public function edit($id)
    {
        $equipamento = Equipamentos::findOrFail($id);
        $categoriasComuns = ['Caminhão', 'Carro', 'Moto', 'Trator', 'Colheitadeira', 'Pulverizador', 'Implemento', 'Máquina', 'Equipamento', 'Ônibus', 'Caminhonete', 'Reboque'];

        return view('equipamentos.edit', compact('equipamento', 'categoriasComuns'));
    }

    public function update(Request $request, $id)
    {
        $equipamento = Equipamentos::findOrFail($id);


        $valor = str_replace('.', '', $request->valor); // remove milhar
        $valor = str_replace(',', '.', $valor);        // troca vírgula por ponto
        $request->merge(['valor' => $valor]);



        $request->validate([
            'codigo' => 'required|string|max:255|unique:equipamentos,codigo,' . $equipamento->id,
            'modelo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
            'ano' => 'nullable|string|max:4',
            'chassi' => 'nullable|string|max:255',
            'renavam' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'valor' => 'nullable|numeric|min:0',
            'venc' => 'nullable|date'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Upload da nova imagem
            if ($request->hasFile('image')) {
                // Remove imagem antiga se existir
                if ($equipamento->image) {
                    Storage::disk('public')->delete('equipamentos/' . $equipamento->image);
                }

                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('equipamentos', $imageName, 'public');
                $data['image'] = $imageName;
            }

            // Formatar valor se necessário
            if ($request->filled('valor')) {
                $data['valor'] = str_replace(['.', ','], ['', '.'], $request->valor);
            }

            $equipamento->update($data);

            DB::commit();

            return redirect()->route('equipamentos.index')
                ->with('success', 'Equipamento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar equipamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $equipamento = Equipamentos::findOrFail($id);

            // Remove imagem se existir
            if ($equipamento->image) {
                Storage::disk('public')->delete('equipamentos/' . $equipamento->image);
            }

            $equipamento->delete();

            return redirect()->route('equipamentos.index')
                ->with('success', 'Equipamento excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir equipamento: ' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        $totalEquipamentos = Equipamentos::ativos()->count();
        $totalPorCategoria = Equipamentos::ativos()
            ->select('categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('categoria')
            ->get();

        $equipamentosComPlaca = Equipamentos::ativos()->whereNotNull('placa')->count();
        $equipamentosSemPlaca = Equipamentos::ativos()->whereNull('placa')->count();

        $ultimosCadastrados = Equipamentos::ativos()
            ->with('abastecimentos')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('equipamentos.dashboard', compact(
            'totalEquipamentos',
            'totalPorCategoria',
            'equipamentosComPlaca',
            'equipamentosSemPlaca',
            'ultimosCadastrados'
        ));
    }
}
