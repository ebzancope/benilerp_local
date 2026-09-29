@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="card pd-15" style="border-radius:10px">
        <div class="card-body">
            <h4 class="mb-3"><i class="fas fa-eye"></i> Detalhes</h4>
            <dl class="row">
                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9">{{ $item->nome }}</dd>
                <dt class="col-sm-3">Código</dt>
                <dd class="col-sm-9">{{ $item->codigo ?? '—' }}</dd>
                <dt class="col-sm-3">Unidade</dt>
                <dd class="col-sm-9">{{ $item->unidade_medida }}</dd>
                <dt class="col-sm-3">Preço Diário</dt>
                <dd class="col-sm-9">R$ {{ number_format($item->preco_diario,2,',','.') }}</dd>
                <dt class="col-sm-3">Preço Semanal</dt>
                <dd class="col-sm-9">R$ {{ number_format($item->preco_semanal,2,',','.') }}</dd>
                <dt class="col-sm-3">Preço Mensal</dt>
                <dd class="col-sm-9">R$ {{ number_format($item->preco_mensal,2,',','.') }}</dd>
                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-{{ $item->status_badge['class'] }}">{{ $item->status_badge['text']
                        }}</span>
                </dd>
                <dt class="col-sm-3">Observação</dt>
                <dd class="col-sm-9">{{ $item->observacao ?? '—' }}</dd>
            </dl>
            <a href="{{ route('preco-equipamentos.edit', $item) }}" class="btn btn-warning rounded-pill">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('preco-equipamentos.index') }}" class="btn btn-secondary rounded-pill">
                <i class="fas fa-undo"></i> Voltar
            </a>
        </div>
    </div>
</div>
@endsection