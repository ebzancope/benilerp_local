<?php

namespace App\Http\Controllers;
use App\Models\Cronograma;
use App\Models\Equipamentos;
use App\Models\Clieforne;
use App\Models\Orcamento;
use App\Models\view_os_fatura;
use Illuminate\Http\Request;
use App\Models\numoservicos;
use Illuminate\Support\Facades\Auth;


class CronogramaController extends Controller
{
    public function index(Request $request)
    {
        session(['place' => '2']);

        $query = Cronograma::with(['equipamento', 'clienteInfo', 'user']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('estatus', $request->status);
        }

            if ($request->filled('tipo_pagamento')) {
        $query->where('tipo_pagamento', $request->tipo_pagamento);
        }


        if ($request->filled('cliente')) {
            $query->where('cliente', $request->cliente);
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('dataini', [
                $request->data_inicio,
                $request->data_fim
            ]);
        }

        if ($request->filled('text_nome')) {
            $textNome = $request->text_nome;
            $query->whereHas('clienteInfo', function ($q) use ($textNome) {
                $q->where('nome', 'like', '%' . $textNome . '%');
            });
        }

         if ($request->filled('status') && $request->status == '1') {
        // Ordenar por nome do cliente
        $query->join('cliefornes', 'cronogramas.cliente', '=', 'cliefornes.id')
              ->select('cronogramas.*')
              ->orderBy('cliefornes.nome', 'asc');
            }

        if ($request->filled('financeiro')) {
        $query->where('statuscobra', $request->financeiro);
        }



        $cronogramas = $query->latest()->paginate(20);

        $equipamentos = Equipamentos::orderBy('codigo', 'asc')->get();
        $cliefornes = Clieforne::orderBy('nome', 'asc')->get();


        // Totais para cards
        $totalAReceber = Cronograma::where('estatus', '1')->sum('valor');
        $totalPago = Cronograma::where('estatus', '2')->sum('valor');

        $totalExecucao = Cronograma::where('estatus', '3')->count();
        $totalAgendar = Cronograma::where('estatus', '4')->count();
        $totalAvisitar = Cronograma::where('estatus', '5')->count();
        $totalFinalizado = Cronograma::where('estatus', '6')->count();
        $totalAgendado = Cronograma::where('estatus', '7')->count();
        $totalOrcamento = Cronograma::where('estatus', '8')->count();
        $totalCortesia = Cronograma::where('estatus', '9')->count();

        $anoAtual = now()->year; // equivalente a YEAR(CURRENT_DATE)

        $totalValorExecucao = Cronograma::where('estatus', '3')->sum('valor');
        $totalValorAgendar = Cronograma::where('estatus', '4')->sum('valor');
        $totalValorAvisitar = Cronograma::where('estatus', '5')->sum('valor');
        $totalValorFinalizado = Cronograma::where('estatus', '6')->whereYear('datafim', $anoAtual)->sum('valor');
        $totalValorAgendado = Cronograma::where('estatus', '7')->sum('valor');
        $totalValorOrcamento = Cronograma::where('estatus', '8')->sum('valor');
        $totalValorCortesia = Cronograma::where('estatus', '9')->sum('valor');


        $totalBoleto = Cronograma::where('statuscobra', 'boleto')->sum('valor');
        $totalPago = Cronograma::where('statuscobra', 'pago')->sum('valor');
        $totalCobrado = Cronograma::where('statuscobra', 'cobrado')->sum('valor');
        $totalACobrar = Cronograma::where('statuscobra', 'a_cobrar')->sum('valor');
        $totalPendente = Cronograma::where('statuscobra', 'pendente')->sum('valor');

        $totalPix      = Cronograma::where('tipo_pagamento', 'pix')->count();
        $totalBoleto   = Cronograma::where('tipo_pagamento', 'boleto')->count();
        $totalCartao   = Cronograma::where('tipo_pagamento', 'cartao')->count();
        $totalCheque   = Cronograma::where('tipo_pagamento', 'cheque')->count();
        $totalDinheiro = Cronograma::where('tipo_pagamento', 'dinheiro')->count();
        $totalOutros   = Cronograma::where('tipo_pagamento', 'outros')->count();
        $totalCortesia = Cronograma::where('tipo_pagamento', 'cortesia')->count();


        return view('cronograma.index', compact(
            'cronogramas',
            'equipamentos',
            'cliefornes',
            'totalAReceber',
            'totalPago',
            'totalBoleto',
            'totalCobrado',
            'totalACobrar',
            'totalPendente',
            'totalExecucao',
            'totalValorExecucao',
            'totalValorAgendar',
            'totalAgendar',
            'totalValorAvisitar',
            'totalAvisitar',
            'totalValorFinalizado',
            'totalFinalizado',
            'totalValorAgendado',
            'totalAgendado',
            'totalPix',
            'totalBoleto',
            'totalCartao',
            'totalCheque',
            'totalDinheiro',
            'totalValorOrcamento',
            'totalOrcamento',
            'totalCortesia',
            'totalValorCortesia',
            'totalOutros'


        ));
    }

    public function create()
    {
        $equipamentos = Equipamentos::orderBy('codigo')->get();
        $cliefornes = Clieforne::orderBy('nome')->get();
        $orcamentos = Orcamento::where('status', 'aprovado')->orderByDesc('id')->get();
        return view('cronograma.create', compact('equipamentos','cliefornes','orcamentos'));
    }

    public function store(Request $request)
    {

    $valorNormalizado = str_replace('.', '', $request->valor);   // remove milhar
    $valorNormalizado = str_replace(',', '.', $valorNormalizado); // vírgula -> ponto
    $request->merge(['valor' => $valorNormalizado]);


        $request->validate([
            'cliente' => 'required|exists:cliefornes,id',
            'descricao' => 'required|exists:equipamentos,id',
            'dataini' => 'required|date',
            'datafim' => 'required|date|after_or_equal:dataini',
            'estatus' => 'required|in:1,2,3,4,5,6,7,8,9',
            'valor' => 'required|numeric|min:0',
            'vencimento' => 'nullable|date',
            'observacao' => 'nullable|string|max:500',
            'orcamento_id'=> 'nullable|exists:orcamentos,id',
            'statuscobra' => 'required|in:boleto,pago,cobrado,a_cobrar,pendente',
            'tipo_pagamento'  => 'required|in:pix,boleto,cartao,cheque,dinheiro,outros,cortesia',
            'obsercobra' => 'nullable|string|max:500',
        ]);

        Cronograma::create([
            'user_id' => session('user.id'),
            'cliente' => $request->cliente,
            'descricao' => $request->descricao,
            'dataini' => $request->dataini,
            'datafim' => $request->datafim,
            'estatus' => $request->estatus,
            'valor' => $request->valor,
            'vencimento' => $request->vencimento,
            'observacao' => $request->observacao,
            'orcamento_id' => $request->orcamento_id,
            'statuscobra' => $request->statuscobra,
            'tipo_pagamento' => $request->tipo_pagamento,
            'obsercobra' => $request->obsercobra,
        ]);

        return redirect()->route('cronograma.index')
            ->with('success', 'Cronograma criado com sucesso!');
    }

    public function show(Cronograma $cronograma)
    {
        $cronograma->load(['equipamento', 'clienteInfo', 'user']);
        return view('cronograma.show', compact('cronograma'));
    }

    public function edit(Cronograma $cronograma)
    {
        $equipamentos = Equipamentos::orderBy('codigo')->get();
        $cliefornes = Clieforne::orderBy('nome')->get();
        $faturas = numoservicos::whereNull('deleted_at')->orderBy('numos', 'desc')->get();
        $orcamentos = Orcamento::where('status', 'aprovado')->orderByDesc('id')->get();
        return view('cronograma.edit', compact('cronograma','equipamentos','cliefornes','orcamentos','faturas'));
    }

public function update(Request $request, Cronograma $cronograma)
{

$valorNormalizado = str_replace('.', '', $request->valor);   // remove milhar
$valorNormalizado = str_replace(',', '.', $valorNormalizado); // vírgula -> ponto
$request->merge(['valor' => $valorNormalizado]);

    $request->validate([
        'cliente'       => 'required|exists:cliefornes,id',
        'descricao'     => 'required|exists:equipamentos,id',
        'dataini'       => 'required|date',
        'datafim'       => 'required|date|after_or_equal:dataini',
        'estatus'       => 'required|in:1,2,3,4,5,6,7,8,9',
        'valor'         => 'required|numeric|min:0',
        'vencimento'    => 'nullable|date',
        'observacao'    => 'nullable|string|max:500',
        'orcamento_id'  => 'nullable|exists:orcamentos,id', // <-- corrigido
        'statuscobra'   => 'required|in:boleto,pago,cobrado,a_cobrar,pendente',
        'tipo_pagamento'  => 'required|in:pix,boleto,cartao,cheque,dinheiro,outros,cortesia,guardado',
        'fatura_numos' => 'nullable|exists:faturas,numos',
        'obsercobra'       => 'nullable|string|max:500',
    ]);

    $cronograma->update($request->only([
        'cliente',
        'descricao',
        'dataini',
        'datafim',
        'estatus',
        'valor',
        'vencimento',
        'observacao',
        'orcamento_id',
        'statuscobra',
        'tipo_pagamento',
        'fatura_numos',
        'obsercobra',
    ]));

    return redirect()->route('cronograma.index')
        ->with('success', 'Cronograma atualizado com sucesso!');
}

    public function destroy(Cronograma $cronograma)
    {
        $cronograma->delete();

        return redirect()->route('cronograma.index')
            ->with('success', 'Cronograma excluído com sucesso!');
    }

    // No CronogramaController
    public function marcarComoPago(Cronograma $cronograma)
    {
        $cronograma->update(['estatus' => '2']); // Pago

        return redirect()->back()->withInput()
            ->with('success', 'Cronograma marcado como Pago!');
    }

    public function marcarComoExecucao(Cronograma $cronograma)
    {
        $cronograma->update(['estatus' => '3']); // Em execução

         return redirect()->back()->withInput()
            ->with('success', 'Cronograma marcado como Em Execução!');
    }

    public function marcarComoAgendar(Cronograma $cronograma)
    {
        $cronograma->update(['estatus' => '4']); // Agendar

        return redirect()->back()->withInput()
            ->with('success', 'Cronograma marcado como Agendar!');
    }

    public function marcarComoFinalizado(Cronograma $cronograma)
    {
        $cronograma->update(['estatus' => '6']); // Finalizado

        return redirect()->back()->withInput()
        ->with('success', 'Cronograma marcado como Finalizado!');

       // return redirect()->route('cronograma.index')
           // ->with('success', 'Cronograma marcado como Finalizado!');
    }

    public function marcarComoOrcamento(Cronograma $cronograma)
    {
        $cronograma->update(['estatus' => '8']); // Orçamento

        return redirect()->back()->withInput()
            ->with('success', 'Cronograma marcado como Orçamento!');
    }

    public function print(Request $request)
    {
        $query = Cronograma::with(['clienteInfo', 'equipamento']);

        $status     = $request->input('status');
        $cliente    = $request->input('cliente');
        $dataInicio = $request->input('data_inicio');
        $dataFim    = $request->input('data_fim');

        if ($status !== null && $status !== '') {
            $query->where('estatus', $status);
        }
        if ($cliente !== null && $cliente !== '') {
            $query->where('cliente', $cliente);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('dataini', [$dataInicio, $dataFim]);
        } elseif ($dataInicio) {
            $query->whereDate('dataini', '>=', $dataInicio);
        } elseif ($dataFim) {
            $query->whereDate('dataini', '<=', $dataFim);
        }

        // Opcional: filtros de vencimento, se existirem no request
        if ($request->filled('vencimento_inicio') && $request->filled('vencimento_fim')) {
            $query->whereBetween('vencimento', [$request->vencimento_inicio, $request->vencimento_fim]);
        } elseif ($request->filled('vencimento')) {
            $query->whereDate('vencimento', $request->vencimento);
        }

        $query->orderByRaw("FIELD(estatus,5,4,7,3,6,1,8,2,9) ASC")
            ->orderBy('dataini', 'asc');

        $itens = $query->get();
        $totalValor = $itens->sum('valor');

        // Mapa local para texto do status (mesmo do accessor)
        $statusMap = [
            '1' => 'A Receber',
            '2' => 'Pago',
            '3' => 'Em Execução',
            '4' => 'Agendar',
            '5' => 'A Visitar',
            '6' => 'Finalizado',
            '7' => 'Agendado',
            '8' => 'Orçamento',
            '9' => 'Cortesia',
        ];

        $filtrosAplicados = [
            'Status'      => $status ? ($statusMap[$status] ?? $status) : 'Todos',
            'Cliente'     => optional(Clieforne::find($cliente))->nome ?? 'Todos',
            'Data Início' => $dataInicio ? \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') : '—',
            'Data Fim'    => $dataFim ? \Carbon\Carbon::parse($dataFim)->format('d/m/Y') : '—',
        ];

        return view('cronograma.relatorio.print', compact('itens', 'totalValor', 'filtrosAplicados'));
    }


}
