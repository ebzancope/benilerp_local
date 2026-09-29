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
                                        class="fa-solid fa-gas-pump"></i> Relatório de Consumo - Por Combustível </label>
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
                                        action="{{ route('relatorios.abastecimentos.consumo-combustiveis') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Data Início</label>
                                                <input type="date" name="data_inicio" class="form-control rounded-pill"
                                                    value="{{ $dataInicio }}">
                                            </div>
                                            <div class="col-md-3">
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
                                    <div class="card bg-primary text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Tipos de Combustível</h5>
                                            <h3>{{ $consumoPorCombustivel->count() }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Litros</h5>
                                            <h3>{{ number_format($consumoPorCombustivel->sum('total_litros'), 0, ',', '.') }}
                                                L</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Valor Total</h5>
                                            <h3>R$
                                                {{ number_format($consumoPorCombustivel->sum('total_valor'), 2, ',', '.') }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Abastecimentos</h5>
                                            <h3>{{ $consumoPorCombustivel->sum('total_abastecimentos') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela de Consumo por Combustível -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-table"></i> Consumo por Tipo de Combustível
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
                                                    <th>Combustível</th>
                                                    <th>Abastecimentos</th>
                                                    <th>Total Litros</th>
                                                    <th>Valor Total</th>
                                                    <th>Preço Médio/L</th>
                                                    <th>% do Total</th>
                                                    <th>Litros/Abast.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $valorTotalGeral = $consumoPorCombustivel->sum('total_valor');
                                                    $litrosTotalGeral = $consumoPorCombustivel->sum('total_litros');
                                                @endphp
                                                @foreach ($consumoPorCombustivel as $consumo)
                                                    @php
                                                        $percentualValor =
                                                            $valorTotalGeral > 0
                                                                ? ($consumo->total_valor / $valorTotalGeral) * 100
                                                                : 0;
                                                        $percentualLitros =
                                                            $litrosTotalGeral > 0
                                                                ? ($consumo->total_litros / $litrosTotalGeral) * 100
                                                                : 0;
                                                        $litrosPorAbastecimento =
                                                            $consumo->total_abastecimentos > 0
                                                                ? $consumo->total_litros /
                                                                    $consumo->total_abastecimentos
                                                                : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $tiposCombustivel[$consumo->combustivel] ?? 'Combustível ' . $consumo->combustivel }}</strong>
                                                        </td>
                                                        <td class="text-center">{{ $consumo->total_abastecimentos }}</td>
                                                        <td class="text-right">
                                                            {{ number_format($consumo->total_litros, 1, ',', '.') }} L
                                                            <br>
                                                            <small
                                                                class="text-muted">({{ number_format($percentualLitros, 1) }}%)</small>
                                                        </td>
                                                        <td class="text-right text-success">
                                                            <strong>R$
                                                                {{ number_format($consumo->total_valor, 2, ',', '.') }}</strong>
                                                            <br>
                                                            <small
                                                                class="text-muted">({{ number_format($percentualValor, 1) }}%)</small>
                                                        </td>
                                                        <td class="text-right">
                                                            R$
                                                            {{ number_format($consumo->preco_medio_litro, 3, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: {{ $percentualValor }}%;"
                                                                    aria-valuenow="{{ $percentualValor }}"
                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                    {{ number_format($percentualValor, 1) }}%
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format($litrosPorAbastecimento, 1, ',', '.') }} L
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            @if ($consumoPorCombustivel->count() > 0)
                                                <tfoot>
                                                    <tr class="table-primary">
                                                        <td><strong>TOTAIS</strong></td>
                                                        <td class="text-center">
                                                            <strong>{{ $consumoPorCombustivel->sum('total_abastecimentos') }}</strong>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>{{ number_format($consumoPorCombustivel->sum('total_litros'), 1, ',', '.') }}
                                                                L</strong>
                                                        </td>
                                                        <td class="text-right"><strong>R$
                                                                {{ number_format($consumoPorCombustivel->sum('total_valor'), 2, ',', '.') }}</strong>
                                                        </td>
                                                        <td class="text-right"><strong>R$
                                                                {{ number_format($consumoPorCombustivel->avg('preco_medio_litro'), 3, ',', '.') }}</strong>
                                                        </td>
                                                        <td><strong>100%</strong></td>
                                                        <td class="text-right">
                                                            <strong>
                                                                @php
                                                                    $mediaGeral =
                                                                        $consumoPorCombustivel->sum(
                                                                            'total_abastecimentos',
                                                                        ) > 0
                                                                            ? $consumoPorCombustivel->sum(
                                                                                    'total_litros',
                                                                                ) /
                                                                                $consumoPorCombustivel->sum(
                                                                                    'total_abastecimentos',
                                                                                )
                                                                            : 0;
                                                                @endphp
                                                                {{ number_format($mediaGeral, 1, ',', '.') }} L
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            @endif
                                        </table>
                                    </div>

                                    @if ($consumoPorCombustivel->count() === 0)
                                        <div class="text-center py-4">
                                            <i class="fas fa-oil-can fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Nenhum dado encontrado para os filtros selecionados</h5>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Cards de Comparação -->
                            <div class="row mt-4">
                                @foreach ($consumoPorCombustivel as $consumo)
                                    @php
                                        $percentualValor =
                                            $valorTotalGeral > 0 ? ($consumo->total_valor / $valorTotalGeral) * 100 : 0;
                                    @endphp
                                    <div class="col-md-4 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-primary">
                                                    {{ $tiposCombustivel[$consumo->combustivel] ?? 'Combustível ' . $consumo->combustivel }}
                                                </h5>

                                                <div class="row mt-3">
                                                    <div class="col-6">
                                                        <div class="border rounded p-2 bg-light">
                                                            <small class="text-muted">Valor Total</small>
                                                            <h6 class="text-success mb-0">R$
                                                                {{ number_format($consumo->total_valor, 0, ',', '.') }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="border rounded p-2 bg-light">
                                                            <small class="text-muted">Total Litros</small>
                                                            <h6 class="text-info mb-0">
                                                                {{ number_format($consumo->total_litros, 0, ',', '.') }}L
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <div class="border rounded p-2 bg-light">
                                                            <small class="text-muted">Preço Médio</small>
                                                            <h6 class="text-warning mb-0">R$
                                                                {{ number_format($consumo->preco_medio_litro, 3, ',', '.') }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="border rounded p-2 bg-light">
                                                            <small class="text-muted">Abastecimentos</small>
                                                            <h6 class="text-primary mb-0">
                                                                {{ $consumo->total_abastecimentos }}</h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <div class="progress" style="height: 10px;">
                                                        <div class="progress-bar bg-info"
                                                            style="width: {{ $percentualValor }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ number_format($percentualValor, 1) }}% do
                                                        total gasto</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
