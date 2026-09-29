<?php

namespace App\Http\Controllers;

use App\Models\Cobranca;
use Illuminate\Http\Request;
use App\Models\Clieforne;

class CobrancaController extends Controller
{
    public static function statusBadgeClass($status)
    {
        return [
            'a_cobrar' => 'secondary',
            'cobrado'  => 'info',
            'pago'     => 'success',
            'cancelado'=> 'dark',
            'nilton'   => 'warning',
            'hebert'   => 'danger',
            'cortesia' => 'dark',
            'outros'   => 'primary',
        ][$status] ?? 'secondary';
    }

    public function index(Request $request)
    {

     session(['place' => '4']);


        $query = Cobranca::with('cliente');

        if ($request->filled('status'))     $query->where('status', $request->status);
        if ($request->filled('cliente'))    $query->where('cliente_id', $request->cliente);
        if ($request->filled('numero_os'))  $query->where('numero_os', $request->numero_os);
        if ($request->filled('data_inicio'))$query->whereDate('data_vencimento','>=',$request->data_inicio);
        if ($request->filled('data_fim'))   $query->whereDate('data_vencimento','<=',$request->data_fim);
        if ($request->filled('contabanc'))  $query->where('contabanc', $request->contabanc);
        if ($request->filled('text')) {
            $t = $request->text;
            $query->where(function($q) use ($t){
                $q->where('observacao','like',"%$t%")
                  ->orWhere('numero','like',"%$t%");
            });
        }

        $cobrancas = $query->orderBy('data_vencimento','desc')->paginate(15);

        // resumo por status
        $resumo = Cobranca::selectRaw('status, count(*) as total')
        ->whereMonth('data_vencimento', date('m'))
        ->whereYear('data_vencimento', date('Y'))
            ->groupBy('status')->pluck('total','status');
        $resumoTotals = Cobranca::selectRaw('status, sum(valor) as total')
            ->whereMonth('data_vencimento', date('m'))
            ->whereYear('data_vencimento', date('Y'))
            ->groupBy('status')->pluck('total','status');

        $map = ['a_cobrar'=>'secondary','cobrado'=>'info','pago'=>'success','cancelado'=>'dark'];
        $clientes = Clieforne::orderBy('nome')->get();

        return view('cobrancas.index', compact('cobrancas','resumo','resumoTotals','map','clientes'));
    }

public function create()
{
    $clientes = Clieforne::orderBy('nome')->get();
    $cobranca = new \App\Models\Cobranca(['status'=>'a_cobrar','tipo_pagamento'=>'pix']);
    return view('cobrancas.create', compact('clientes','cobranca'));
}

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $cob = Cobranca::create($data);
        return redirect()->route('cobrancas.show', $cob->id)->with('success','Cobrança criada');
    }

    public function show(Cobranca $cobranca)
    {
       $cobranca->load(['cliente','eventos']);
        $clientes = Clieforne::orderBy('nome')->get();
        return view('cobrancas.show', compact('cobranca','clientes'));
    }

public function edit(\App\Models\Cobranca $cobranca)
{
    $clientes = Clieforne::orderBy('nome')->get();
    return view('cobrancas.edit', compact('cobranca','clientes'));
}
    public function update(Request $request, Cobranca $cobranca)
    {
        $data = $this->validateData($request);
        $cobranca->update($data);
        return redirect()->route('cobrancas.show', $cobranca->id)->with('success','Cobrança atualizada');
    }

    public function destroy(Cobranca $cobranca)
    {
        $cobranca->delete();
        return redirect()->route('cobrancas.index')->with('success','Cobrança removida');
    }

    public function atualizarStatus(Request $request, Cobranca $cobranca)
    {
        $request->validate(['status' => 'required|in:a_cobrar,cobrado,pago,cancelado,nilton,hebert,cortesia,outros']);
        $cobranca->update(['status' => $request->status]);
        return back()->with('success','Status atualizado');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'cliente_id'      => 'required|exists:cliefornes,id',
            'numero_os'       => 'required|numeric',
            'valor'           => 'required|numeric|min:0',
            'status'          => 'required|in:a_cobrar,cobrado,pago,cancelado,nilton,hebert,cortesia,outros',
            'tipo_pagamento'  => 'required|in:pix,boleto,cartao,cheque,dinheiro,outros',
            'data_vencimento' => 'nullable|date',
            'observacao'      => 'nullable|string|max:500',
            'contabanc'       => 'required|in:benloca,benpavi,niltonm,outros',
        ]);
    }


            public function printRelatorio(Request $request)
{
    $query = Cobranca::with('cliente');

    if ($request->filled('status'))      $query->where('status', $request->status);
    if ($request->filled('cliente'))     $query->where('cliente_id', $request->cliente);
    if ($request->filled('numero_os'))   $query->where('numero_os', $request->numero_os);
    if ($request->filled('data_inicio')) $query->whereDate('data_vencimento', '>=', $request->data_inicio);
    if ($request->filled('data_fim'))    $query->whereDate('data_vencimento', '<=', $request->data_fim);
    if ($request->filled('contabanc'))   $query->where('contabanc', $request->contabanc);
    if ($request->filled('text')) {
        $t = $request->text;
        $query->where(function ($q) use ($t) {
            $q->where('observacao', 'like', "%$t%")
              ->orWhere('numero', 'like', "%$t%");
        });
    }

    // Ordenação personalizada de status, depois data_vencimento asc
    $query->orderByRaw("
        FIELD(
            status,
            'pago',
            'cobrado',
            'a_cobrar',
            'cortesia',
            'nilton',
            'hebert',
            'outros',
            'cancelado'
        ) ASC
    ")->orderBy('data_vencimento', 'asc');

    $cobrancas = $query->get();

    // Total recebido: somatório de valor onde status = pago
    $totalRecebido = $cobrancas->where('status', 'pago')->sum('valor');

    return view('cobrancas.print', [
        'cobrancas' => $cobrancas,
        'totalRecebido' => $totalRecebido,
    ]);
}
}
