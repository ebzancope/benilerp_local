<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Clieforne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BoletoController extends Controller
{
    public function index(Request $request)
    {
        session(['place' => '4']);

        // Query base SEM filtro de data inicial para buscar TODOS os boletos
        $queryBase = Boleto::with(['pagadorInfo', 'beneficiarioInfo'])
            ->ativos()
            ->whereNull('deleted_at');

        // Query FILTRADA para a lista (aplica TODOS os filtros)
        $queryFiltrada = (clone $queryBase);

        // Aplicar filtros na query da lista
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pagos':
                    $queryFiltrada->where('pago', 1);
                    break;
                case 'pendentes':
                    $queryFiltrada->where('pago', 0);
                    break;
                case 'vencidos':
                    $queryFiltrada->where('pago', 0)
                                 ->where('vencimento', '<', now()->format('Y-m-d'));
                    break;
                case 'a_vencer':
                    $queryFiltrada->where('pago', 0)
                                 ->whereBetween('vencimento', [now()->format('Y-m-d'), now()->addDays(7)->format('Y-m-d')]);
                    break;
            }
        }

        if ($request->filled('pagador')) {
            $queryFiltrada->where('pagador', $request->pagador);
        }

        if ($request->filled('beneficiario')) {
            $queryFiltrada->where('beneficiario', $request->beneficiario);
        }

        // FILTRO DE DATA - APENAS quando especificado
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $queryFiltrada->whereBetween('vencimento', [$request->data_inicio, $request->data_fim]);
        } else {
            // SEM filtro de data padrão - mostra TODOS os boletos
            // Isso permite que boletos pagos de qualquer data apareçam
        }

        // ORDENAÇÃO CORRIGIDA:
        // 1. Primeiro por status (não pagos primeiro, pagos por último)
        // 2. Depois por data de vencimento (mais próximos primeiro)
        $queryFiltrada->orderBy('pago', 'ASC') // 0 (não pago) vem primeiro, 1 (pago) depois
                     ->orderBy('vencimento', 'ASC'); // datas mais antigas primeiro

        // **CALCULAR TOTAIS GERAIS (SEM filtros de status/pagador/beneficiario)**
        $queryTotais = (clone $queryBase);

        // Aplica apenas filtro de data nos totais (se existir)
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $queryTotais->whereBetween('vencimento', [$request->data_inicio, $request->data_fim]);
        }
        // SEM filtro de data padrão para os totais também

        // Calcular totais
        $totalGeralAberto = (clone $queryTotais)->where('pago', 0)->sum('valor');
        $totalGeralPago = (clone $queryTotais)->where('pago', 1)
        ->whereMonth('vencimento', date('m'))
        ->whereYear('vencimento', date('Y'))
        ->sum('valor');

        // Totais para contagem - apenas para não pagos
        $totalVencidos = (clone $queryTotais)
            ->where('pago', 0)
            ->where('vencimento', '<', now()->format('Y-m-d'))
            ->count();

        $totalAVencer = (clone $queryTotais)
            ->where('pago', 0)
            ->whereBetween('vencimento', [now()->format('Y-m-d'), now()->addDays(7)->format('Y-m-d')])
            ->count();

        // Paginação da query filtrada
        $boletos = $queryFiltrada->paginate(20);

        $clientes = Clieforne::whereNull('deleted_at')->orderBy('nome')->get();

        return view('boletos.index', compact(
            'boletos',
            'clientes',
            'totalGeralAberto',
            'totalGeralPago',
            'totalVencidos',
            'totalAVencer'
        ));
    }

    public function create()
    {
        $clientes = Clieforne::whereNull('deleted_at')->orderBy('nome', 'ASC')->get();
        return view('boletos.create', compact('clientes'));
    }

    public function store(Request $request)
{
    $request->validate([
        'pagador' => 'required|exists:cliefornes,id',
        'beneficiario' => 'required|exists:cliefornes,id',
        'numdoc' => 'required|string|max:255|unique:boletos,numdoc',
        'vencimento' => 'required|date',
        'valor' => 'required|numeric|min:0.01',
        'descricao' => 'nullable|string'
    ], [
        'numdoc.unique' => 'O número do documento já existe. Informe outro número.',
    ]);

    try {
        DB::beginTransaction();

        Boleto::create([
            'user_id' => session('user.id'),
            'pagador' => $request->pagador,
            'beneficiario' => $request->beneficiario,
            'numdoc' => $request->numdoc,
            'vencimento' => $request->vencimento,
            'valor' => $request->valor,
            'descricao' => $request->descricao,
            'pago' => $request->pago ? 1 : 0
        ]);

        DB::commit();

        return redirect()->route('boletos.index')
            ->with('success', 'Boleto cadastrado com sucesso!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->with('error', 'Erro ao cadastrar boleto: ' . $e->getMessage());
    }
}

    public function show(Boleto $boleto)
    {
        $boleto->load(['pagadorInfo', 'beneficiarioInfo', 'usuario']);
        return view('boletos.show', compact('boleto'));
    }

    public function edit(Boleto $boleto)
    {
        $clientes = Clieforne::whereNull('deleted_at')->orderBy('nome')->get();
        return view('boletos.edit', compact('boleto', 'clientes'));
    }

    public function update(Request $request, Boleto $boleto)
{
    $request->validate([
        'pagador' => 'required|exists:cliefornes,id',
        'beneficiario' => 'required|exists:cliefornes,id',
        'numdoc' => [
            'required',
            'string',
            'max:255',
            Rule::unique('boletos', 'numdoc')->ignore($boleto->id),
        ],
        'vencimento' => 'required|date',
        'valor' => 'required|numeric|min:0.01',
        'descricao' => 'nullable|string'
    ], [
        'numdoc.unique' => 'O número do documento já existe. Informe outro número.',
    ]);

    try {
        DB::beginTransaction();

        $boleto->update([
            'pagador' => $request->pagador,
            'beneficiario' => $request->beneficiario,
            'numdoc' => $request->numdoc,
            'vencimento' => $request->vencimento,
            'valor' => $request->valor,
            'descricao' => $request->descricao,
            'pago' => $request->pago ? 1 : 0
        ]);

        DB::commit();

        return redirect()->route('boletos.index')
            ->with('success', 'Boleto atualizado com sucesso!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->with('error', 'Erro ao atualizar boleto: ' . $e->getMessage());
    }
}

    public function destroy(Boleto $boleto)
    {
        try {
            $boleto->delete();
            return redirect()->route('boletos.index')
                ->with('success', 'Boleto excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir boleto: ' . $e->getMessage());
        }
    }

    public function marcarComoPago(Boleto $boleto)
    {
        try {
            $boleto->update(['pago' => 1]);
            return back()->with('success', 'Boleto marcado como pago!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao marcar boleto como pago: ' . $e->getMessage());
        }
    }

    public function marcarComoPendente(Boleto $boleto)
    {
        try {
            $boleto->update(['pago' => 0]);
            return back()->with('success', 'Boleto marcado como pendente!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao marcar boleto como pendente: ' . $e->getMessage());
        }
    }

    // Métodos extras para as rotas que estão na view
    public function marcarPago($id)
    {
        try {
            $boleto = Boleto::findOrFail($id);
            $boleto->update(['pago' => 1]);
            return redirect()->route('boletos.index')
                ->with('success', 'Boleto marcado como pago!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao marcar boleto como pago: ' . $e->getMessage());
        }
    }

    public function marcarPendente($id)
    {
        try {
            $boleto = Boleto::findOrFail($id);
            $boleto->update(['pago' => 0]);
            return redirect()->route('boletos.index')
                ->with('success', 'Boleto marcado como pendente!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao marcar boleto como pendente: ' . $e->getMessage());
        }
    }
}
