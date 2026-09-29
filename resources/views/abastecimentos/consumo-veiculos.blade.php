{{-- resources/views/relatorios/abastecimentos/consumo-veiculos.blade.php --}}
@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-chart-bar"></i> Relatório de Consumo - Por Veículo</h2>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('abastecimentos.index') }}" class="btn btn-secondary rounded-pill">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <button onclick="window.print()" class="btn btn-info rounded-pill">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('relatorios.abastecimentos.consumo-veiculos') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Veículo</label>
                            <select name="veiculo" class="form-control rounded-pill">
                                <option value="">Todos os Veículos</option>
                                @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}"
                                        {{ request('veiculo') == $veiculo->id ? 'selected' : '' }}>
                                        {{ $veiculo->codigo }} - {{ $veiculo->modelo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Combustível</label>
                            <select name="combustivel" class="form-control rounded-pill">
                                <option value="">Todos</option>
                                @foreach ($tiposCombustivel as $key => $nome)
                                    <option value="{{ $key }}"
                                        {{ request('combustivel') == $key ? 'selected' : '' }}>
                                        {{ $nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Data Início</label>
                            <input type="date" name="data_inicio" class="form-control rounded-pill"
                                value="{{ $dataInicio }}">
                        </div>
                        <div class="col-md-2">
                            <label>Data Fim</label>
                            <input type="date" name="data_fim" class="form-control rounded-pill"
                                value="{{ $dataFim }}">
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resumo Geral -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5>Total Veículos</h5>
                        <h3>{{ $consumoPorVeiculo->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5>Total Litros</h5>
                        <h3>{{ number_format($consumoPorVeiculo->sum('total_litros'), 0, ',', '.') }} L</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5>Valor Total</h5>
                        <h3>R$ {{ number_format($consumoPorVeiculo->sum('total_valor'), 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h5>Consumo Médio</h5>
                        <h3>{{ number_format($consumoPorVeiculo->avg('consumo_medio') ?? 0, 1, ',', '.') }} km/L</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Consumo -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-table"></i> Consumo por Veículo
                    <small class="float-right text-muted">
                        Período: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} à
                        {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                    </small>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Veículo</th>
                                <th>Categoria</th>
                                <th>Combustível</th>
                                <th>Abastecimentos</th>
                                <th>Total Litros</th>
                                <th>Valor Total</th>
                                <th>Preço Médio/L</th>
                                <th>Km Percorrido</th>
                                <th>Consumo Médio</th>
                                <th>Custo/km</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumoPorVeiculo as $consumo)
                                <tr>
                                    <td>
                                        <strong>{{ $consumo->codigo_veiculo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $consumo->modelo_veiculo }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $consumo->categoria_veiculo }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $tiposCombustivel[$consumo->combustivel] ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $consumo->total_abastecimentos }}</td>
                                    <td class="text-right">{{ number_format($consumo->total_litros, 1, ',', '.') }} L</td>
                                    <td class="text-right text-success">
                                        <strong>R$ {{ number_format($consumo->total_valor, 2, ',', '.') }}</strong>
                                    </td>
                                    <td class="text-right">R$ {{ number_format($consumo->preco_medio_litro, 3, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        @if ($consumo->km_atual && $consumo->km_inicial)
                                            {{ number_format($consumo->km_atual - $consumo->km_inicial, 0, ',', '.') }} km
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($consumo->consumo_medio > 0)
                                            <span
                                                class="badge badge-{{ $consumo->consumo_medio >= 8 ? 'success' : ($consumo->consumo_medio >= 5 ? 'warning' : 'danger') }}">
                                                {{ number_format($consumo->consumo_medio, 1, ',', '.') }} km/L
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($consumo->custo_km > 0)
                                            R$ {{ number_format($consumo->custo_km, 3, ',', '.') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($consumoPorVeiculo->count() > 0)
                            <tfoot>
                                <tr class="table-primary">
                                    <td colspan="3"><strong>TOTAIS</strong></td>
                                    <td class="text-center">
                                        <strong>{{ $consumoPorVeiculo->sum('total_abastecimentos') }}</strong>
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($consumoPorVeiculo->sum('total_litros'), 1, ',', '.') }}
                                            L</strong>
                                    </td>
                                    <td class="text-right"><strong>R$
                                            {{ number_format($consumoPorVeiculo->sum('total_valor'), 2, ',', '.') }}</strong>
                                    </td>
                                    <td class="text-right"><strong>R$
                                            {{ number_format($consumoPorVeiculo->avg('preco_medio_litro'), 3, ',', '.') }}</strong>
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                @if ($consumoPorVeiculo->count() === 0)
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhum dado encontrado para os filtros selecionados</h5>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ranking de Consumo -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-trophy"></i> Melhores Consumos</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $melhoresConsumos = $consumoPorVeiculo
                                ->where('consumo_medio', '>', 0)
                                ->sortByDesc('consumo_medio')
                                ->take(5);
                        @endphp

                        @if ($melhoresConsumos->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($melhoresConsumos as $consumo)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $consumo->codigo_veiculo }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $consumo->modelo_veiculo }}</small>
                                        </div>
                                        <span class="badge badge-success badge-pill">
                                            {{ number_format($consumo->consumo_medio, 1, ',', '.') }} km/L
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center mb-0">Nenhum dado disponível</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Maiores Gastos</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $maioresGastos = $consumoPorVeiculo->sortByDesc('total_valor')->take(5);
                        @endphp

                        @if ($maioresGastos->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($maioresGastos as $consumo)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $consumo->codigo_veiculo }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $consumo->modelo_veiculo }}</small>
                                        </div>
                                        <span class="badge badge-danger badge-pill">
                                            R$ {{ number_format($consumo->total_valor, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center mb-0">Nenhum dado disponível</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            .card-header .float-right {
                display: none !important;
            }
        }
    </style>
@endsection
