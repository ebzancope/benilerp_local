@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="row g-3 mb-3 section-title fst-italic" style="color: #30a300; ">
                <h2><i class="fas fa-money-bill-alt"></i> {{ $orcamento->numero }} - {{ $orcamento->cliente->nome ??
                    'N/A' }}</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('orcamentos.edit',$orcamento->id) }}" class="btn btn-warning rounded-pill">Editar</a>
                <a href="{{ route('orcamentos.print',$orcamento->id) }}" class="btn btn-secondary rounded-pill"
                    target="_blank">Imprimir</a>

                <form action="{{ route('orcamentos.aprovar',$orcamento->id) }}" method="POST" class="d-inline">@csrf
                    <button class="btn btn-success rounded-pill">Aprovar</button>
                </form>
                <form action="{{ route('orcamentos.rejeitar',$orcamento->id) }}" method="POST" class="d-inline">@csrf
                    <button class="btn btn-danger rounded-pill">Rejeitar</button>
                </form>
                <form action="{{ route('orcamentos.cancelar',$orcamento->id) }}" method="POST" class="d-inline">@csrf
                    <button class="btn btn-dark rounded-pill">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body row">
            <div class="col-md-3">
                <div class="text-muted">Status</div>
                <span
                    class="badge bg-{{ \App\Http\Controllers\OrcamentoController::statusBadgeClass($orcamento->status) }}">{{
                    ucfirst($orcamento->status) }}</span>
            </div>
            <div class="col-md-3">
                <div class="text-muted">Emissão</div>
                <div>{{ optional($orcamento->data_emissao)->format('d/m/Y') }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted">Validade</div>
                <div>{{ optional($orcamento->data_validade)->format('d/m/Y') }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted">Valor total</div>
                <div class="h5 mb-0">R$ {{ number_format($orcamento->valor_total,2,',','.') }}</div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h6>Itens</h6>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Qtd</th>
                            <th>Unid</th>
                            <th>Preço</th>
                            <th>Desc %</th>
                            <th>Desc R$</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orcamento->itens as $it)
                        <tr>
                            <td>{{ $it->tipo_item }}</td>
                            <td>{{ $it->descricao }}</td>
                            <td>{{ $it->quantidade }}</td>
                            <td>{{ $it->unidade }}</td>
                            <td>R$ {{ number_format($it->preco_unitario,2,',','.') }}</td>
                            <td>{{ $it->desconto_percentual }}%</td>
                            <td>R$ {{ number_format($it->desconto_valor,2,',','.') }}</td>
                            <td>R$ {{ number_format($it->total_item,2,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($orcamento->condicoes_pagamento)
    <div class="card mb-3">
        <div class="card-body">
            <h6>Condições de pagamento</h6>
            <p class="mb-0">{{ $orcamento->condicoes_pagamento }}</p>
        </div>
    </div>
    @endif

    @if($orcamento->descricao)
    <div class="card mb-3">
        <div class="card-body">
            <h6>Observações / Escopo</h6>
            <p class="mb-0">{{ $orcamento->descricao }}</p>
        </div>
    </div>
    @endif
</div>
@endsection