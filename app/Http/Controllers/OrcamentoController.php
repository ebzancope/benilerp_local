<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrcamentoRequest;
use App\Models\Orcamento;
use App\Models\OrcamentoItem;
use App\Models\Clieforne;
use App\Services\OrcamentoCalculadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrcamentoController extends Controller
{
    public function index(Request $request)
    {

     session(['place' => '2']);


        $q = Orcamento::with('cliente')
            ->when($request->status, fn($qb) => $qb->where('status', $request->status))
            ->when($request->cliente, fn($qb) => $qb->where('cliente_id', $request->cliente))
            ->when($request->data_inicio, fn($qb) => $qb->whereDate('data_emissao', '>=', $request->data_inicio))
            ->when($request->data_fim, fn($qb) => $qb->whereDate('data_emissao', '<=', $request->data_fim))
            ->when($request->text_nome, function ($qb) use ($request) {
                $t = $request->text_nome;
                $qb->where(function ($w) use ($t) {
                    $w->where('titulo', 'like', "%$t%")
                      ->orWhere('numero', 'like', "%$t%");
                });
            })
            ->orderByDesc('id');

        $orcamentos = $q->paginate(15)->appends($request->all());

        // cards/resumo
        $clientes = Clieforne::orderBy('nome')->get();

        $resumoRaw = Orcamento::selectRaw("status, COUNT(*) qty, SUM(valor_total) total")
            ->groupBy('status')
            ->get();
        $resumo = $resumoRaw->pluck('qty','status');
        $resumoTotals = $resumoRaw->pluck('total','status');

        return view('orcamentos.index', compact('orcamentos','resumo','resumoTotals','clientes'));
    }

    public function create()
    {
        $clientes = Clieforne::orderBy('nome')->get();
        return view('orcamentos.create', [
            'clientes' => $clientes,
            'orcamento' => new Orcamento(['status' => 'rascunho', 'data_emissao' => now(), 'data_validade' => now()->addDays(15)]),
        ]);
    }

    public function store(OrcamentoRequest $request, OrcamentoCalculadora $calc)
{
    return DB::transaction(function () use ($request, $calc) {
        $orcamento = Orcamento::create([
            'numero'              => $this->gerarNumero(),
            'cliente_id'          => $request->cliente_id,
            'titulo'              => $request->titulo,
            'local'               => $request->local,
            'descricao'           => $request->descricao,
            'status'              => $request->status ?? 'rascunho',
            'data_emissao'        => $request->data_emissao ?: now(),
            'data_validade'       => $request->data_validade,
            'condicoes_pagamento' => $request->condicoes_pagamento,
            'prazo_execucao'      => $request->prazo_execucao,
            'desconto_total'      => $request->desconto_total,
            'acrescimo_total'     => 0, // removido do form
            'created_by'          => session('user.id'),


        ]);

        foreach ($request->itens as $i => $item) {
            OrcamentoItem::create([
                'orcamento_id'         => $orcamento->id,
                'tipo_item'            => $item['tipo_item'],
                'local'                => $item['local'] ?? null,
                'descricao'            => $item['descricao'],
                'quantidade'           => $item['quantidade'],
                'unidade'              => $item['unidade'] ?? null,
                'preco_unitario'       => $item['preco_unitario'],
                'desconto_percentual'  => $item['desconto_percentual'] ?? 0,
                'desconto_valor'       => $item['desconto_valor'] ?? 0,
                'ordem'                => $item['ordem'] ?? $i,
                'obs'                  => $item['obs'] ?? null,
            ]);
        }

        // Recalcula e salva o valor_total
        $orcamento = $calc->recalcular($orcamento->fresh('itens'));
        $orcamento->save();

        return redirect()->route('orcamentos.show', $orcamento->id)
            ->with('success', 'Orçamento criado.');
    });
}
    public function show($id)
    {
        $orcamento = Orcamento::with('cliente','itens')->findOrFail($id);
        return view('orcamentos.show', compact('orcamento'));
    }

    public function edit($id)
    {
        $orcamento = Orcamento::with('itens')->findOrFail($id);
        $clientes = Clieforne::orderBy('nome')->get();
        return view('orcamentos.edit', compact('orcamento','clientes'));
    }

 public function update(OrcamentoRequest $request, $id, OrcamentoCalculadora $calc)
{
    return DB::transaction(function () use ($request, $id, $calc) {
        $orcamento = Orcamento::with('itens')->findOrFail($id);

        $orcamento->fill([
            'cliente_id'          => $request->cliente_id,
            'titulo'              => $request->titulo,
            'descricao'           => $request->descricao,
            'status'              => $request->status ?? 'rascunho',
            'data_emissao'        => $request->data_emissao,
            'data_validade'       => $request->data_validade,
            'condicoes_pagamento' => $request->condicoes_pagamento,
            'prazo_execucao'      => $request->prazo_execucao,
            'local'               => $request->local,
            'desconto_total'      => $request->desconto_total,
            'acrescimo_total'     => 0, // removido do form
        ]);
        $orcamento->updated_by = session('user.id');
        $orcamento->save();

        // ressincroniza itens
        $orcamento->itens()->delete();
        foreach ($request->itens as $i => $item) {
            $orcamento->itens()->create([
                'local'               => $item['local'] ?? null,
                'tipo_item'           => $item['tipo_item'],
                'descricao'           => $item['descricao'],
                'quantidade'          => $item['quantidade'],
                'unidade'             => $item['unidade'] ?? null,
                'preco_unitario'      => $item['preco_unitario'],
                'desconto_percentual' => $item['desconto_percentual'] ?? 0,
                'desconto_valor'      => $item['desconto_valor'] ?? 0,
                'ordem'               => $item['ordem'] ?? $i,
                'obs'                 => $item['obs'] ?? null,
            ]);
        }

        // recalcula e salva o valor_total
        $orcamento = $calc->recalcular($orcamento->fresh('itens'));
        $orcamento->save();

        return redirect()->route('orcamentos.show', $orcamento->id)
            ->with('success', 'Orçamento atualizado.');
    });
}

    public function destroy($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->delete();
        return back()->with('success', 'Orçamento removido.');
    }

    public function aprovar($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->status = 'aprovado';
        $orcamento->approved_by = session('user.id');
        $orcamento->save();

        return back()->with('success', 'Orçamento aprovado.');
    }

    public function rejeitar($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->status = 'rejeitado';
        $orcamento->save();

        return back()->with('success', 'Orçamento rejeitado.');
    }

    public function cancelar($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->status = 'cancelado';
        $orcamento->save();

        return back()->with('success', 'Orçamento cancelado.');
    }

    public function enviar($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->status = 'enviado';
        $orcamento->save();
        // opcional: enviar e-mail e anexar PDF
        return back()->with('success', 'Orçamento marcado como enviado.');
    }

    public function converterOs($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        // TODO: criar OS e vincular ID retornado
        $orcamento->status = 'convertido';
        $orcamento->converted_os_id = null; // atribuir ID da OS criada
        $orcamento->save();

        return back()->with('success', 'Orçamento convertido em OS.');
    }

private function gerarNumero(): string
{
    $ano = now()->format('Y');
    $prefix = "ORC-{$ano}-";

    // trava a leitura dentro da transação corrente
    $ultimo = DB::table('orcamentos')
        ->whereYear('created_at', $ano)
        ->where('numero', 'like', $prefix.'%')
        ->lockForUpdate()
        ->max('numero');

    $proximo = 1;
    if ($ultimo) {
        // pega os 4 últimos dígitos
        $seq = (int) substr($ultimo, -4);
        $proximo = $seq + 1;
    }

    return sprintf('%s%04d', $prefix, $proximo);
}

    public function pdf($id)
    {
        $orcamento = Orcamento::with('cliente','itens')->findOrFail($id);
      //  $pdf = Pdf::loadView('orcamentos.pdf', compact('orcamento'));
        $filename = $orcamento->numero . '.pdf';
       // return $pdf->download($filename);
    }

    // Helper opcional: badge CSS por status (use na view)
    public static function statusBadgeClass(string $status): string
    {
        return [
            'rascunho'   => 'secondary',
            'enviado'    => 'info',
            'aprovado'   => 'success',
            'rejeitado'  => 'danger',
            'cancelado'  => 'dark',
            'convertido' => 'primary',
        ][$status] ?? 'secondary';
    }

    public function print($id)
{
    $orcamento = Orcamento::with('cliente','itens')->findOrFail($id);
    return view('orcamentos.print', compact('orcamento'));
}

public function downloadPdf($id)
{
    $orcamento = Orcamento::with('cliente','itens')->findOrFail($id);

    $pdf = Pdf::loadView('orcamentos.pdf', compact('orcamento'))
        ->setPaper('a4', 'portrait');

    $filename = $orcamento->numero . '.pdf';

    return $pdf->download($filename);
}




}
