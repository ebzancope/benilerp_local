@extends('layouts.layout')

@section('title', 'Gestão de Almoxarifado')

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
                                    <i class="fa-solid fa-warehouse"></i> Gestão de Almoxarifado
                                </label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: right">
                                        <a href="{{ route('almoxarifado.create') }}" class="btn btn-success rounded-pill">
                                            <i class="fa-solid fa-circle-plus"></i> Novo Item
                                        </a>
                                        <a href="{{ route('almoxarifado.relatorio') }}" class="btn btn-info rounded-pill">
                                            <i class="fas fa-chart-bar"></i> Relatório
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtros -->
                            <div class="card mb-4 mt-3">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('almoxarifado.index') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Buscar</label>
                                                <input type="text" name="search" class="form-control rounded-pill"
                                                    value="{{ request('search') }}" placeholder="Código, nome...">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Categoria</label>
                                                <select name="categoria" class="form-control rounded-pill">
                                                    <option value="">Todas</option>
                                                    @foreach ($categorias as $categoria)
                                                        <option value="{{ $categoria }}"
                                                            {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                                            {{ $categoria }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Situação</label>
                                                <select name="situacao" class="form-control rounded-pill">
                                                    <option value="">Todas</option>
                                                    <option value="baixo"
                                                        {{ request('situacao') == 'baixo' ? 'selected' : '' }}>Estoque Baixo
                                                    </option>
                                                    <option value="esgotado"
                                                        {{ request('situacao') == 'esgotado' ? 'selected' : '' }}>Esgotado
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block rounded-pill">
                                                    <i class="fas fa-filter"></i> Filtrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Itens</h5>
                                            <h3>{{ $totais['total_itens'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Valor Estoque</h5>
                                            <h3>R$ {{ number_format($totais['valor_total_estoque'], 2, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Baixo Estoque</h5>
                                            <h3>{{ $totais['itens_baixo_estoque'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger text-white rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Esgotados</h5>
                                            <h3>{{ $totais['itens_esgotados'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela de Itens -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Item</th>
                                                    <th>Categoria</th>
                                                    <th>Estoque</th>
                                                    <th>Mínimo</th>
                                                    <th>Custo Médio</th>
                                                    <th>Valor Estoque</th>
                                                    <th>Situação</th>
                                                    <th width="150">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($itens as $item)
                                                    <tr>
                                                        <td><strong>{{ $item->codigo }}</strong></td>
                                                        <td>
                                                            <strong>{{ $item->nome }}</strong>
                                                            @if ($item->descricao)
                                                                <br><small
                                                                    class="text-muted">{{ Str::limit($item->descricao, 50) }}</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->categoria }}</td>
                                                        <td>
                                                            <strong>{{ number_format($item->quantidade_atual, 2, ',', '.') }}
                                                                {{ $item->unidade_medida }}</strong>
                                                        </td>
                                                        <td>{{ number_format($item->quantidade_minima, 2, ',', '.') }}
                                                            {{ $item->unidade_medida }}</td>
                                                        <td>R$ {{ number_format($item->custo_medio, 2, ',', '.') }}</td>
                                                        <td>
                                                            <strong class="text-success">R$
                                                                {{ number_format($item->valor_total_estoque, 2, ',', '.') }}</strong>
                                                        </td>
                                                        <td>
                                                            @if ($item->situacao_estoque == 'esgotado')
                                                                <span class="badge badge-danger">Esgotado</span>
                                                            @elseif($item->situacao_estoque == 'baixo')
                                                                <span class="badge badge-warning">Baixo</span>
                                                            @else
                                                                <span class="badge badge-success">Normal</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('almoxarifado.show', $item->id) }}"
                                                                    class="btn btn-sm btn-info rounded-pill"
                                                                    title="Visualizar">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('almoxarifado.edit', $item->id) }}"
                                                                    class="btn btn-sm btn-warning rounded-pill"
                                                                    title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('almoxarifado.entrada', $item->id) }}"
                                                                    class="btn btn-sm btn-success rounded-pill"
                                                                    title="Entrada">
                                                                    <i class="fas fa-arrow-down"></i>
                                                                </a>
                                                                <a href="{{ route('almoxarifado.saida', $item->id) }}"
                                                                    class="btn btn-sm btn-primary rounded-pill"
                                                                    title="Saída">
                                                                    <i class="fas fa-arrow-up"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Paginação -->
                                    @if ($itens->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted small">
                                                Mostrando {{ $itens->firstItem() }} a {{ $itens->lastItem() }} de
                                                {{ $itens->total() }} registros
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-sm mb-0">
                                                    @if ($itens->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link">‹</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $itens->previousPageUrl() }}"
                                                                rel="prev">‹</a>
                                                        </li>
                                                    @endif

                                                    @php
                                                        $current = $itens->currentPage();
                                                        $last = $itens->lastPage();
                                                        $start = max(1, $current - 2);
                                                        $end = min($last, $current + 2);
                                                    @endphp

                                                    @for ($page = $start; $page <= $end; $page++)
                                                        <li class="page-item {{ $page == $current ? 'active' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $itens->url($page) }}">{{ $page }}</a>
                                                        </li>
                                                    @endfor

                                                    @if ($itens->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $itens->nextPageUrl() }}"
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
