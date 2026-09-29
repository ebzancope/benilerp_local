@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="row g-3 mb-3 section-title fst-italic" style="color: #30a300; ">
                    <h2><i class="fas fa-money-bill-alt"></i> Gerenciamento de Orçamentos</h2>
                </div>
                <a href="{{ route('orcamentos.create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-plus"></i> Novo Orçamento
                </a>
            </div>
        </div>
    </div>

    {{-- Cards de resumo --}}
    <div class="row mb-3">
        @php
        $map =
        ['rascunho'=>'secondary','enviado'=>'info','aprovado'=>'success','rejeitado'=>'danger','cancelado'=>'dark','convertido'=>'primary'];
        @endphp
        @foreach($map as $st => $color)
        <div class="col-sm-2 mb-2">
            <div class="card bg-{{ $color }} text-white rounded-pill hover-card">
                <div class="card-body py-3 text-center">
                    <div class="small text-uppercase">{{ ucfirst($st) }}</div>
                    <div class="h6 mb-0">{{ $resumo[$st] ?? 0 }} (R$ {{ number_format($resumoTotals[$st] ?? 0,2,',','.')
                        }})</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filtros --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('orcamentos.index') }}">
                <div class="row g-2">
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-select rounded-pill">
                            <option value="">Todos</option>
                            @foreach($map as $st => $color)
                            <option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>{{ ucfirst($st) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Cliente</label>
                        <select name="cliente" class="form-select rounded-pill">
                            <option value="">Todos</option>
                            @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ request('cliente')==$c->id ? 'selected' : '' }}>{{ $c->nome
                                }}</option>
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
                        <input type="text" name="text_nome" value="{{ request('text_nome') }}"
                            class="form-control rounded-pill" placeholder="Número ou título">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100 rounded-pill"><i class="fas fa-filter"></i></button>
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
                        <th>Cod.</th>
                        <th>Cliente</th>
                        <th>Emissão</th>
                        <th>Validade</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orcamentos as $o)
                    <tr>
                        <td>{{ $o->numero }}</td>
                        <td>{{ $o->cliente->nome ?? 'N/A' }}</td>
                        <td>{{ optional($o->data_emissao)->format('d/m/Y') }}</td>
                        <td>{{ optional($o->data_validade)->format('d/m/Y') }}</td>
                        <td>R$ {{ number_format($o->valor_total, 2, ',', '.') }}</td>
                        <td><span
                                class="badge bg-{{ \App\Http\Controllers\OrcamentoController::statusBadgeClass($o->status) }}">{{
                                ucfirst($o->status) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('orcamentos.show',$o->id) }}" class="btn btn-sm btn-info rounded-pill"><i
                                    class="fas fa-eye"></i></a>
                            <a href="{{ route('orcamentos.edit',$o->id) }}"
                                class="btn btn-sm btn-warning rounded-pill"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('orcamentos.aprovar',$o->id) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-sm btn-success rounded-pill" title="Aprovar"><i
                                        class="fas fa-check"></i></button></form>
                            <form action="{{ route('orcamentos.rejeitar',$o->id) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-sm btn-danger rounded-pill" title="Rejeitar"><i
                                        class="fas fa-times"></i></button></form>
                            <a href="{{ route('orcamentos.print',$o->id) }}" class="btn btn-secondary rounded-pill"
                                target="_blank">Imprimir</a>

                            <form action="{{ route('orcamentos.destroy',$o->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Excluir?')">@csrf @method('DELETE')<button
                                    class="btn btn-sm btn-outline-danger rounded-pill"><i
                                        class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">Nenhum orçamento.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $orcamentos->links() }}
        </div>
    </div>
</div>
@endsection