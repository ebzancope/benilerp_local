@extends('layouts.layout')

@section('title', 'Relatório de Movimentações - Almoxarifado')

@section('content')
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div class="col-lg-12"
                                style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                                <label class="section-title fst-italic" style="color: #30a300;">
                                    <i class="fas fa-chart-bar"></i> Relatório de Movimentações
                                </label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-0">Histórico de Entradas e Saídas</h5>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('almoxarifado.index') }}" class="btn btn-secondary rounded-pill">
                                            <i class="fas fa-arrow-left"></i> Voltar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtros -->
                            <div class="card mb-4 mt-3">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('almoxarifado.relatorio') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Data Início</label>
                                                <input type="date" name="data_inicio" class="form-control rounded-pill"
                                                    value="{{ request('data_inicio') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Data Fim</label>
                                                <input type="date" name="data_fim" class="form-control rounded-pill"
                                                    value="{{ request('data_fim') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Tipo</label>
                                                <select name="tipo" class="form-control rounded-pill">
                                                    <option value="">Todos</option>
                                                    <option value="entrada"
                                                        {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entradas
                                                    </option>
                                                    <option value="saida"
                                                        {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saídas</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Item</label>
                                                <select name="item_id" class="form-control rounded-pill">
                                                    <option value="">Todos os Itens</option>
                                                    @foreach ($itens as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->codigo }} - {{ $item->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-success rounded-pill">
                                                    <i class="fas fa-filter"></i> Filtrar
                                                </button>
                                                <a href="{{ route('almoxarifado.relatorio') }}"
                                                    class="btn btn-outline-secondary rounded-pill">
                                                    Limpar
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Estatísticas -->
                            @php
                                $totalEntradas = $movimentacoes->where('tipo', 'entrada')->sum('quantidade');
                                $totalSaidas = $movimentacoes->where('tipo', 'saida')->sum('quantidade');
                                $valorEntradas = $movimentacoes->where('tipo', 'entrada')->sum('valor_total');
                                $valorSaidas = $movimentacoes->where('tipo', 'saida')->sum('valor_total');
                            @endphp

                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-success text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Entradas</h5>
                                            <h3>{{ number_format($totalEntradas, 2, ',', '.') }}</h3>
                                            <small>R$ {{ number_format($valorEntradas, 2, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Saídas</h5>
                                            <h3>{{ number_format($totalSaidas, 2, ',', '.') }}</h3>
                                            <small>R$ {{ number_format($valorSaidas, 2, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Saldo</h5>
                                            <h3>{{ number_format($totalEntradas - $totalSaidas, 2, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Movimentações</h5>
                                            <h3>{{ $movimentacoes->total() }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela de Movimentações -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Item</th>
                                                    <th>Tipo</th>
                                                    <th>Quantidade</th>
                                                    <th>Valor Unit.</th>
                                                    <th>Valor Total</th>
                                                    <th>Motivo</th>
                                                    <th>Documento</th>
                                                    <th>Usuário</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($movimentacoes as $movimentacao)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($movimentacao->data_movimentacao)->format('d/m/Y') }}
                                                        </td>
                                                        <td>
                                                            <strong>{{ $movimentacao->item->codigo }}</strong>
                                                            <br><small>{{ $movimentacao->item->nome }}</small>
                                                        </td>
                                                        <td>
                                                            @if ($movimentacao->tipo == 'entrada')
                                                                <span class="badge badge-success">Entrada</span>
                                                            @else
                                                                <span class="badge badge-primary">Saída</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($movimentacao->quantidade, 2, ',', '.') }}
                                                            {{ $movimentacao->item->unidade_medida }}</td>
                                                        <td>R$
                                                            {{ number_format($movimentacao->valor_unitario, 2, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            <strong
                                                                class="{{ $movimentacao->tipo == 'entrada' ? 'text-success' : 'text-primary' }}">
                                                                R$
                                                                {{ number_format($movimentacao->valor_total, 2, ',', '.') }}
                                                            </strong>
                                                        </td>
                                                        <td>{{ $movimentacao->motivo }}</td>
                                                        <td>{{ $movimentacao->documento ?? '-' }}</td>
                                                        <td>{{ $movimentacao->usuario->name ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Paginação -->
                                    @if ($movimentacoes->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted small">
                                                Mostrando {{ $movimentacoes->firstItem() }} a
                                                {{ $movimentacoes->lastItem() }} de {{ $movimentacoes->total() }}
                                                registros
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-sm mb-0">
                                                    @if ($movimentacoes->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link">‹</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $movimentacoes->previousPageUrl() }}"
                                                                rel="prev">‹</a>
                                                        </li>
                                                    @endif

                                                    @php
                                                        $current = $movimentacoes->currentPage();
                                                        $last = $movimentacoes->lastPage();
                                                        $start = max(1, $current - 2);
                                                        $end = min($last, $current + 2);
                                                    @endphp

                                                    @for ($page = $start; $page <= $end; $page++)
                                                        <li class="page-item {{ $page == $current ? 'active' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $movimentacoes->url($page) }}">{{ $page }}</a>
                                                        </li>
                                                    @endfor

                                                    @if ($movimentacoes->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $movimentacoes->nextPageUrl() }}"
                                                                rel="next">›</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link">›</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
