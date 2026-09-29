@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1" style="color:#30a300;">
                    <i class="fas fa-search-dollar"></i> Cobrança #{{ $cobranca->numero ?? $cobranca->id }}
                </h2>
                <div class="text-muted">
                    Cliente: <strong>{{ $cobranca->cliente->nome ?? 'N/A' }}</strong> |
                    Valor: <strong>R$ {{ number_format($cobranca->valor,2,',','.') }}</strong> |
                    Status: <span
                        class="badge bg-{{ \App\Http\Controllers\CobrancaController::statusBadgeClass($cobranca->status) }}">
                        {{ ucwords(str_replace('_',' ', $cobranca->status)) }}
                    </span>
                </div>
            </div>
            <a href="{{ route('cobrancas.index') }}" class="btn btn-outline-secondary rounded-pill">Voltar</a>
        </div>
    </div>

    {{-- Aqui apenas leitura: dados e timeline, sem _form --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Dados da Cobrança</h5>
                    <p><strong>Tipo pagamento:</strong> {{ strtoupper($cobranca->tipo_pagamento) }}</p>
                    <p><strong>Pagamento:</strong> {{ optional($cobranca->data_vencimento)->format('d/m/Y') }}</p>
                    <p><strong>Observação:</strong> {{ $cobranca->observacao ?: '-' }}</p>
                    <p><strong>Criado em:</strong> {{ optional($cobranca->created_at)->format('d/m/Y H:i') }}</p>
                    <p><strong>Atualizado em:</strong> {{ optional($cobranca->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Linha do tempo</h5>
                    <ul class="timeline list-unstyled">
                        @forelse($cobranca->eventos as $ev)
                        <li class="mb-3 d-flex">
                            <div class="me-3 text-center" style="width:32px;">
                                <span class="badge bg-{{ $ev->badge_color ?? 'secondary' }}"><i
                                        class="{{ $ev->icon ?? 'fas fa-dot-circle' }}"></i></span>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $ev->titulo }}</div>
                                <div class="text-muted small">{{ optional($ev->created_at)->format('d/m/Y H:i') }}</div>
                                <div>{{ $ev->descricao }}</div>
                            </div>
                        </li>
                        @empty
                        <li>Nenhum evento registrado.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection