@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5 ">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div class="col-lg-12 "
                                style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                                <label class="section-title fst-italic " style="color: #30a300; "> <i
                                        class="fa-solid fa-gas-pump"></i> Relatório de Consumo - Por Fornecedor </label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: right">
                                        <a href="{{ route('abastecimentos.index') }}"
                                            class="btn btn-success  rounded-pill  ">
                                            <i class="fas fa-arrow-left"></i>&nbsp; Voltar
                                            &nbsp;
                                        </a> <!-- relatorio -->

                                    </div>
                                    <!-- cadastrar -->
                                </div>

                            </div>


                            <!-- Filtros -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <form method="GET"
                                        action="{{ route('relatorios.abastecimentos.consumo-fornecedores') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Fornecedor</label>
                                                <select name="fornecedor" class="form-control  rounded-pill">
                                                    <option value="">Todos os Fornecedores</option>
                                                    @foreach ($fornecedores as $fornecedor)
                                                        <option value="{{ $fornecedor->id }}"
                                                            {{ request('fornecedor') == $fornecedor->id ? 'selected' : '' }}>
                                                            {{ $fornecedor->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Combustível</label>
                                                <select name="combustivel" class="form-control  rounded-pill">
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
                                                <input type="date" name="data_inicio" class="form-control  rounded-pill"
                                                    value="{{ $dataInicio }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Data Fim</label>
                                                <input type="date" name="data_fim" class="form-control  rounded-pill"
                                                    value="{{ $dataFim }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block  rounded-pill">
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
                                    <div class="card bg-primary text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Fornecedores</h5>
                                            <h3>{{ $consumoPorFornecedor->count() }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Litros</h5>
                                            <h3>{{ number_format($consumoPorFornecedor->sum('total_litros'), 0, ',', '.') }}
                                                L</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Valor Total</h5>
                                            <h3>R$
                                                {{ number_format($consumoPorFornecedor->sum('total_valor'), 2, ',', '.') }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Preço Médio/L</h5>
                                            <h3>R$
                                                {{ number_format($consumoPorFornecedor->avg('preco_medio_litro') ?? 0, 3, ',', '.') }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela de Consumo -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-table"></i> Consumo por Fornecedor
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
                                                    <th>Fornecedor</th>
                                                    <th>Combustível</th>
                                                    <th>Abastecimentos</th>
                                                    <th>Total Litros</th>
                                                    <th>Valor Total</th>
                                                    <th>Preço Médio/L</th>
                                                    <th>% do Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $valorTotalGeral = $consumoPorFornecedor->sum('total_valor');
                                                @endphp
                                                @foreach ($consumoPorFornecedor as $consumo)
                                                    @php
                                                        $percentual =
                                                            $valorTotalGeral > 0
                                                                ? ($consumo->total_valor / $valorTotalGeral) * 100
                                                                : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $consumo->nome_fornecedor }}</strong>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-secondary">
                                                                {{ $tiposCombustivel[$consumo->combustivel] ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ $consumo->total_abastecimentos }}</td>
                                                        <td class="text-right">
                                                            {{ number_format($consumo->total_litros, 1, ',', '.') }} L</td>
                                                        <td class="text-right text-success">
                                                            <strong>R$
                                                                {{ number_format($consumo->total_valor, 2, ',', '.') }}</strong>
                                                        </td>
                                                        <td class="text-right">R$
                                                            {{ number_format($consumo->preco_medio_litro, 3, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: {{ $percentual }}%;"
                                                                    aria-valuenow="{{ $percentual }}" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                    {{ number_format($percentual, 1) }}%
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            @if ($consumoPorFornecedor->count() > 0)
                                                <tfoot>
                                                    <tr class="table-primary">
                                                        <td colspan="2"><strong>TOTAIS</strong></td>
                                                        <td class="text-center">
                                                            <strong>{{ $consumoPorFornecedor->sum('total_abastecimentos') }}</strong>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>{{ number_format($consumoPorFornecedor->sum('total_litros'), 1, ',', '.') }}
                                                                L</strong>
                                                        </td>
                                                        <td class="text-right"><strong>R$
                                                                {{ number_format($consumoPorFornecedor->sum('total_valor'), 2, ',', '.') }}</strong>
                                                        </td>
                                                        <td class="text-right"><strong>R$
                                                                {{ number_format($consumoPorFornecedor->avg('preco_medio_litro'), 3, ',', '.') }}</strong>
                                                        </td>
                                                        <td><strong>100%</strong></td>
                                                    </tr>
                                                </tfoot>
                                            @endif
                                        </table>
                                    </div>

                                    @if ($consumoPorFornecedor->count() === 0)
                                        <div class="text-center py-4">
                                            <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Nenhum dado encontrado para os filtros selecionados</h5>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Gráfico de Distribuição -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Distribuição por
                                                Fornecedor</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($consumoPorFornecedor->count() > 0)
                                                <div class="row">
                                                    @foreach ($consumoPorFornecedor->take(6) as $consumo)
                                                        @php
                                                            $percentual =
                                                                $valorTotalGeral > 0
                                                                    ? ($consumo->total_valor / $valorTotalGeral) * 100
                                                                    : 0;
                                                        @endphp
                                                        <div class="col-md-4 mb-3">
                                                            <div class="card border-0 shadow-sm">
                                                                <div class="card-body">
                                                                    <h6 class="card-title">{{ $consumo->nome_fornecedor }}
                                                                    </h6>
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="text-success font-weight-bold">
                                                                            R$
                                                                            {{ number_format($consumo->total_valor, 0, ',', '.') }}
                                                                        </span>
                                                                        <span
                                                                            class="badge badge-info">{{ number_format($percentual, 1) }}%</span>
                                                                    </div>
                                                                    <small class="text-muted">
                                                                        {{ $consumo->total_abastecimentos }} abastecimentos
                                                                        •
                                                                        {{ number_format($consumo->total_litros, 0, ',', '.') }}L
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted text-center">Nenhum dado disponível para o gráfico</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- timeline- -->
                    </div><!-- group -->
                </div><!-- card -->
            </div><!-- ol lg-->
        </div><!-- timeline-p5 -->
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
