@extends('layouts.layout')
@section('content')
<style>
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-12">
                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                    <h2><i class="fas fa-barcode"></i> Gerenciamento de Cobranças</h2>
                </div>
                <div class="col-md-6 text-right ">
                    <a href="{{ route('cobrancas.create') }}" class="btn btn-success rounded-pill">
                        <i class="fas fa-plus"></i> Nova Cobrança
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- Cards de resumo por status --}}
    <div class="row mb-3">
        @php
        $map = [
        'a_cobrar' => 'secondary',
        'cobrado' => 'info',
        'pago' => 'success',
        'cancelado'=> 'dark',
        'nilton' => 'warning',
        'hebert' => 'danger',
        'cortesia' => 'dark',
        'outros' => 'primary',
        ];
        @endphp
        @foreach($map as $st => $color)
        <div class="col-sm-3 mb-2">
            <a href="{{ route('cobrancas.index') }}?status={{ $st }}" class="text-decoration-none">
                <div class="card bg-{{ $color }} text-white rounded-pill hover-card">
                    <div class="card-body py-3 text-center">
                        <div class="small text-uppercase">{{ ucwords(str_replace('_',' ', $st)) }}</div>
                        <div class="h6 mb-0">
                            {{ $resumo[$st] ?? 0 }} (R$ {{ number_format($resumoTotals[$st] ?? 0, 2, ',', '.') }})
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    {{-- Filtros --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('cobrancas.index') }}">
                <div class="row g-2">
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-select rounded-pill">
                            <option value="">Todos</option>
                            @foreach($map as $st => $color)
                            <option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_',' ', $st)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cliente</label>
                        <select name="cliente" class="form-select rounded-pill">
                            <option value="">Todos</option>
                            @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ request('cliente')==$c->id ? 'selected' : '' }}>
                                {{ $c->nome }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Data início</label>
                        <input type="date" name="data_inicio" value="{{ request('data_inicio') }}"
                            class="form-control rounded-pill">
                    </div>
                    <div class="col-md-2">
                        <label>Data fim</label>
                        <input type="date" name="data_fim" value="{{ request('data_fim') }}"
                            class="form-control rounded-pill">
                    </div>
                    <div class="col-md-2">
                        <label>Busca</label>
                        <input type="text" name="text" value="{{ request('text') }}" class="form-control rounded-pill"
                            placeholder="Título, ref ou obs">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100 rounded-pill">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <a href="{{ route('cobrancas.print', request()->all()) }}"
                            class="btn btn-outline-secondary rounded-pill" target="_blank">
                            <i class="fas fa-print"></i> Imprimir
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Tabela --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Pagamento</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cobrancas as $cob)
                    <tr>

                        <td>{{ optional($cob->data_vencimento)->format('d/m/Y') }}</td>

                        <td>{{ $cob->cliente->nome ?? 'N/A' }}</td>
                        <td>R$ {{ number_format($cob->valor, 2, ',', '.') }}</td>
                        <td>{{ strtoupper($cob->tipo_pagamento) }}
                        </td>
                        <td><span
                                class="badge bg-{{ \App\Http\Controllers\CobrancaController::statusBadgeClass($cob->status) }}">
                                {{ ucwords(str_replace('_',' ', $cob->status)) }}
                            </span></td>
                        <td class="text-end">
                            <a href="{{ route('cobrancas.show', $cob->id) }}" class="btn btn-sm btn-info rounded-pill">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('cobrancas.edit', $cob->id) }}"
                                class="btn btn-sm btn-warning rounded-pill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cobrancas.atualizar-status', $cob->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="pago">
                                <button class="btn btn-sm btn-success rounded-pill" title="Marcar como pago">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('cobrancas.destroy', $cob->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Excluir cobrança?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">Nenhuma cobrança encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $cobrancas->links() }}
        </div>
    </div>
</div>
@endsection