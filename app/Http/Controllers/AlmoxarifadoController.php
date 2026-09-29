<?php
// app/Http/Controllers/AlmoxarifadoController.php

namespace App\Http\Controllers;

use App\Models\AlmoxarifadoItem;
use App\Models\AlmoxarifadoMovimentacao;
use App\Models\Clieforne;
use App\Models\Colaborador;
use App\Models\Equipamento;
use App\Models\Colaboradores;
use App\Models\Equipamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // ADICIONE ESTA LINHA

class AlmoxarifadoController extends Controller
{
    // Lista de itens
    public function index(Request $request)
    {

      session(['place' => '3']);

        $query = AlmoxarifadoItem::with('fornecedor');

        // Filtros
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('codigo', 'like', '%' . $request->search . '%')
                    ->orWhere('nome', 'like', '%' . $request->search . '%')
                    ->orWhere('descricao', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria', $request->categoria);
        }

        if ($request->has('situacao') && $request->situacao != '') {
            if ($request->situacao == 'baixo') {
                $query->baixoEstoque();
            } elseif ($request->situacao == 'esgotado') {
                $query->where('quantidade_atual', '<=', 0);
            }
        }

        $itens = $query->orderBy('nome')->paginate(20);

        $categorias = AlmoxarifadoItem::distinct()->pluck('categoria');
        $totais = [
            'total_itens' => AlmoxarifadoItem::count(),
            'valor_total_estoque' => AlmoxarifadoItem::sum(DB::raw('quantidade_atual * custo_medio')),
            'itens_baixo_estoque' => AlmoxarifadoItem::baixoEstoque()->count(),
            'itens_esgotados' => AlmoxarifadoItem::where('quantidade_atual', '<=', 0)->count()
        ];

        return view('almoxarifado.index', compact('itens', 'categorias', 'totais'));
    }

    // Formulário de criação
    public function create()
    {
        $fornecedores = Clieforne::get();
        $categorias = [
            'Peças e Componentes',
            'Ferramentas',
            'Equipamentos de Segurança',
            'Material de Escritório',
            'Material de Limpeza',
            'Combustíveis e Lubrificantes',
            'Outros'
        ];

        $unidades = [
            'UN' => 'Unidade',
            'PC' => 'Peça',
            'CX' => 'Caixa',
            'KG' => 'Quilograma',
            'L' => 'Litro',
            'M' => 'Metro',
            'M2' => 'Metro Quadrado',
            'M3' => 'Metro Cúbico'
        ];

        return view('almoxarifado.create', compact('fornecedores', 'categorias', 'unidades'));
    }

    // Salvar novo item

    public function store(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:almoxarifado_itens',
            'nome' => 'required|max:255',
            'categoria' => 'required',
            'unidade_medida' => 'required',
            'quantidade_minima' => 'required|numeric|min:0|max:9999999.99',
            'quantidade_atual' => 'required|numeric|min:0|max:9999999.99',
            'ultimo_preco' => 'required|numeric|min:0|max:9999999.99'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erro de validação. Verifique os campos.');
        }

        try {
            DB::beginTransaction();

            // Calcular valor total e verificar limite
            $valorTotal = $request->quantidade_atual * $request->ultimo_preco;

            if ($valorTotal > 9999999.99) {
                return redirect()->back()
                    ->with('error', 'Valor total muito alto. Reduza a quantidade ou o preço.')
                    ->withInput();
            }

            // Criar item
            $item = AlmoxarifadoItem::create([
                'codigo' => $request->codigo,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'categoria' => $request->categoria,
                'unidade_medida' => $request->unidade_medida,
                'quantidade_minima' => $request->quantidade_minima,
                'quantidade_atual' => $request->quantidade_atual,
                'custo_medio' => $request->ultimo_preco,
                'ultimo_preco' => $request->ultimo_preco,
                'localizacao' => $request->localizacao,
                'numero_serie' => $request->numero_serie,
                'fabricante' => $request->fabricante,
                'modelo' => $request->modelo,
                'fornecedor_id' => $request->fornecedor_id,
                'ativo' => true,
                'observacoes' => $request->observacoes
            ]);

            // Criar movimentação se houver estoque inicial
            if ($request->quantidade_atual > 0) {
                AlmoxarifadoMovimentacao::create([
                    'item_id' => $item->id,
                    'tipo' => 'entrada',
                    'quantidade' => $request->quantidade_atual,
                    'valor_unitario' => $request->ultimo_preco,
                    'valor_total' => $valorTotal,
                    'motivo' => 'Estoque inicial',
                    'fornecedor_id' => $request->fornecedor_id,
                    'user_id' => session('user.id'),
                    'data_movimentacao' => now(),
                    'observacoes' => 'Cadastro inicial do item'
                ]);
            }

            DB::commit();

            return redirect()->route('almoxarifado.index')
                ->with('success', 'Item cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar item: ' . $e->getMessage())
                ->withInput();
        }
    }






























    // Mostrar detalhes do item
    public function show(AlmoxarifadoItem $almoxarifado)
    {
        $movimentacoes = $almoxarifado->movimentacoes()
            ->with(['fornecedor', 'equipamento', 'colaborador', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('almoxarifado.show', compact('almoxarifado', 'movimentacoes'));
    }

    // Formulário de edição
    public function edit(AlmoxarifadoItem $almoxarifado)
    {
        $fornecedores = Clieforne::get();
        $categorias = [
            'Peças e Componentes',
            'Ferramentas',
            'Equipamentos de Segurança',
            'Material de Escritório',
            'Material de Limpeza',
            'Combustíveis e Lubrificantes',
            'Outros'
        ];

        $unidades = [
            'UN' => 'Unidade',
            'PC' => 'Peça',
            'CX' => 'Caixa',
            'KG' => 'Quilograma',
            'L' => 'Litro',
            'M' => 'Metro',
            'M2' => 'Metro Quadrado',
            'M3' => 'Metro Cúbico'
        ];

        return view('almoxarifado.edit', compact('almoxarifado', 'fornecedores', 'categorias', 'unidades'));
    }

    // Atualizar item
    public function update(Request $request, AlmoxarifadoItem $almoxarifado)
    {
        $request->validate([
            'codigo' => 'required|unique:almoxarifado_itens,codigo,' . $almoxarifado->id,
            'nome' => 'required|max:255',
            'categoria' => 'required',
            'unidade_medida' => 'required',
            'quantidade_minima' => 'required|numeric|min:0'
        ]);

        try {
            $almoxarifado->update($request->all());

            return redirect()->route('almoxarifado.index')
                ->with('success', 'Item atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar item: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Excluir item
    public function destroy(AlmoxarifadoItem $almoxarifado)
    {
        try {
            // Verificar se há movimentações
            if ($almoxarifado->movimentacoes()->exists()) {
                return redirect()->back()
                    ->with('error', 'Não é possível excluir o item pois existem movimentações vinculadas.');
            }

            $almoxarifado->delete();

            return redirect()->route('almoxarifado.index')
                ->with('success', 'Item excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir item: ' . $e->getMessage());
        }
    }

    // Formulário de entrada
    public function createEntrada(AlmoxarifadoItem $almoxarifado)
    {
        $fornecedores = Clieforne::where('tipo', 'fornecedor')->orWhere('tipo', 'ambos')->get();

        return view('almoxarifado.entrada', compact('almoxarifado', 'fornecedores'));
    }

    // Processar entrada
    public function storeEntrada(Request $request, AlmoxarifadoItem $almoxarifado)
    {
        $request->validate([
            'quantidade' => 'required|numeric|min:0.01',
            'valor_unitario' => 'required|numeric|min:0',
            'documento' => 'nullable|max:100',
            'motivo' => 'required|max:255',
            'data_movimentacao' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            // Criar movimentação
            $movimentacao = AlmoxarifadoMovimentacao::create([
                'item_id' => $almoxarifado->id,
                'tipo' => 'entrada',
                'quantidade' => $request->quantidade,
                'valor_unitario' => $request->valor_unitario,
                'documento' => $request->documento,
                'motivo' => $request->motivo,
                'fornecedor_id' => $request->fornecedor_id,
                'user_id' => session('user.id'),
                'data_movimentacao' => $request->data_movimentacao,
                'observacoes' => $request->observacoes
            ]);

            // Atualizar estoque e custos do item
            $novaQuantidade = $almoxarifado->quantidade_atual + $request->quantidade;
            $novoCustoMedio = (($almoxarifado->quantidade_atual * $almoxarifado->custo_medio) +
                ($request->quantidade * $request->valor_unitario)) / $novaQuantidade;

            $almoxarifado->update([
                'quantidade_atual' => $novaQuantidade,
                'custo_medio' => $novoCustoMedio,
                'ultimo_preco' => $request->valor_unitario
            ]);

            DB::commit();

            return redirect()->route('almoxarifado.show', $almoxarifado)
                ->with('success', 'Entrada de estoque registrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao registrar entrada: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Formulário de saída
    public function createSaida(AlmoxarifadoItem $almoxarifado)
    {
        $equipamentos = Equipamentos::all();
        $colaboradores = Colaboradores::all();

        return view('almoxarifado.saida', compact('almoxarifado', 'equipamentos', 'colaboradores'));
    }

    // Processar saída
    public function storeSaida(Request $request, AlmoxarifadoItem $almoxarifado)
    {
        $request->validate([
            'quantidade' => 'required|numeric|min:0.01',
            'motivo' => 'required|max:255',
            'data_movimentacao' => 'required|date'
        ]);

        // Verificar estoque suficiente
        if ($almoxarifado->quantidade_atual < $request->quantidade) {
            return redirect()->back()
                ->with('error', 'Quantidade insuficiente em estoque. Disponível: ' . $almoxarifado->quantidade_atual)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Criar movimentação
            $movimentacao = AlmoxarifadoMovimentacao::create([
                'item_id' => $almoxarifado->id,
                'tipo' => 'saida',
                'quantidade' => $request->quantidade,
                'valor_unitario' => $almoxarifado->custo_medio, // Usa custo médio para saída
                'documento' => $request->documento,
                'motivo' => $request->motivo,
                'equipamento_id' => $request->equipamento_id,
                'colaborador_id' => $request->colaborador_id,
                'user_id' => session('user.id'),
                'data_movimentacao' => $request->data_movimentacao,
                'observacoes' => $request->observacoes
            ]);

            // Atualizar estoque
            $almoxarifado->decrement('quantidade_atual', $request->quantidade);

            DB::commit();

            return redirect()->route('almoxarifado.show', $almoxarifado)
                ->with('success', 'Saída de estoque registrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao registrar saída: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Relatório de movimentações
    public function relatorio(Request $request)
    {
        $query = AlmoxarifadoMovimentacao::with(['item', 'fornecedor', 'equipamento', 'colaborador']);

        if ($request->has('data_inicio') && $request->data_inicio != '') {
            $query->whereDate('data_movimentacao', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim') && $request->data_fim != '') {
            $query->whereDate('data_movimentacao', '<=', $request->data_fim);
        }

        if ($request->has('tipo') && $request->tipo != '') {
            $query->where('tipo', $request->tipo);
        }

        if ($request->has('item_id') && $request->item_id != '') {
            $query->where('item_id', $request->item_id);
        }

        $movimentacoes = $query->orderBy('data_movimentacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $itens = AlmoxarifadoItem::orderBy('nome')->get();

        return view('almoxarifado.relatorio', compact('movimentacoes', 'itens'));
    }
}
