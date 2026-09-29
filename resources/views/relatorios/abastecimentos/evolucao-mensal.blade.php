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
                                        class="fa-solid fa-gas-pump"></i> Abastecimentos </label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: right">
                                        <a href="#"
                                            class="btn btn-success  rounded-pill @disabled(true)  ">
                                            <i class="fa-solid fa-magnifying-glass"></i>&nbsp; <i
                                                class="fa-solid fa-file-lines"></i>
                                            &nbsp;
                                        </a> <!-- relatorio -->
                                        <a href="{{ route('cadAbastecimento') }}" class="btn btn-success  rounded-pill">
                                            <i class="fa-solid fa-circle-plus"></i>&nbsp; <i
                                                class="fa-solid fa-gas-pump"></i>
                                            &nbsp;
                                        </a>
                                    </div>
                                    <!-- cadastrar -->
                                </div>
                                <div class="row mg-b-25 align-items-end ">
                                    <!-- linha form -->
                                    <div class="col-lg-2" style="text-align: right">
                                        <form action="{{ route('Abastecimento') }}">
                                            @csrf
                                            <div class="search-box ">
                                                <input type="text" class="form-control" name="text_nome" id="text_nome"
                                                    placeholder="Código ou Fornecedor">
                                                <button class="btn  bd-0 rounded-pill"
                                                    style=" float: right; color: #ffffff; background-color: #30a300;"
                                                    type="submit"> <i class="fa fa-search"></i>
                                                </button>
                                            </div><!-- search-box -->
                                        </form>
                                    </div><!-- col-4 -->
                                </div><!-- row  25 -->
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h2><i class="fas fa-chart-line"></i> Evolução Mensal - Consumo de Combustível</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('abastecimentos.index') }}" class="btn btn-secondary  rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                    <button onclick="window.print()" class="btn btn-info  rounded-pill">
                                        <i class="fas fa-print"></i> Imprimir
                                    </button>
                                </div>
                            </div>

                            <!-- Filtros -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('relatorios.abastecimentos.evolucao-mensal') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Ano</label>
                                                <select name="ano" class="form-control  rounded-pill">
                                                    @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $ano == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Combustível</label>
                                                <select name="combustivel" class="form-control  rounded-pill">
                                                    <option value="">Todos os Combustíveis</option>
                                                    @foreach ($tiposCombustivel as $key => $nome)
                                                        <option value="{{ $key }}"
                                                            {{ $combustivel == $key ? 'selected' : '' }}>
                                                            {{ $nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
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

                            <!-- Resumo do Ano -->
                            @php
                                $totalAnoValor = $evolucaoMensal->sum('total_valor');
                                $totalAnoLitros = $evolucaoMensal->sum('total_litros');
                                $totalAnoAbastecimentos = $evolucaoMensal->sum('total_abastecimentos');
                                $mediaMensalValor =
                                    $evolucaoMensal->count() > 0 ? $totalAnoValor / $evolucaoMensal->count() : 0;
                                $mediaMensalLitros =
                                    $evolucaoMensal->count() > 0 ? $totalAnoLitros / $evolucaoMensal->count() : 0;
                            @endphp

                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Total Ano {{ $ano }}</h5>
                                            <h3>R$ {{ number_format($totalAnoValor, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Litros Ano {{ $ano }}</h5>
                                            <h3>{{ number_format($totalAnoLitros, 0, ',', '.') }} L</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Abastecimentos</h5>
                                            <h3>{{ $totalAnoAbastecimentos }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white  rounded-pill">
                                        <div class="card-body text-center">
                                            <h5>Média Mensal</h5>
                                            <h3>R$ {{ number_format($mediaMensalValor, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela de Evolução Mensal -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-table"></i> Evolução Mensal - Ano {{ $ano }}
                                        @if ($combustivel)
                                            <small class="text-muted">- {{ $tiposCombustivel[$combustivel] }}</small>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Mês</th>
                                                    <th>Combustível</th>
                                                    <th>Abastecimentos</th>
                                                    <th>Total Litros</th>
                                                    <th>Valor Total</th>
                                                    <th>Preço Médio/L</th>
                                                    <th>Variação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $mesAnteriorValor = null;
                                                @endphp
                                                @foreach ($evolucaoMensal->sortBy('mes') as $mes)
                                                    @php
                                                        $variacao = null;
                                                        if ($mesAnteriorValor !== null && $mesAnteriorValor > 0) {
                                                            $variacao =
                                                                (($mes->total_valor - $mesAnteriorValor) /
                                                                    $mesAnteriorValor) *
                                                                100;
                                                        }
                                                        $mesAnteriorValor = $mes->total_valor;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $meses[$mes->mes] ?? 'Mês ' . $mes->mes }}</strong>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-secondary">
                                                                {{ $tiposCombustivel[$mes->combustivel] ?? 'Combustível ' . $mes->combustivel }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ $mes->total_abastecimentos }}</td>
                                                        <td class="text-right">
                                                            {{ number_format($mes->total_litros, 1, ',', '.') }} L</td>
                                                        <td class="text-right text-success">
                                                            <strong>R$
                                                                {{ number_format($mes->total_valor, 2, ',', '.') }}</strong>
                                                        </td>
                                                        <td class="text-right">R$
                                                            {{ number_format($mes->preco_medio_litro ?? 0, 3, ',', '.') }}
                                                        </td>
                                                        <td class="text-right">
                                                            @if ($variacao !== null)
                                                                <span
                                                                    class="badge badge-{{ $variacao >= 0 ? 'danger' : 'success' }}">
                                                                    {{ $variacao >= 0 ? '+' : '' }}{{ number_format($variacao, 1, ',', '.') }}%
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            @if ($evolucaoMensal->count() > 0)
                                                <tfoot>
                                                    <tr class="table-primary">
                                                        <td colspan="2"><strong>TOTAIS ANO {{ $ano }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <strong>{{ $totalAnoAbastecimentos }}</strong>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>{{ number_format($totalAnoLitros, 1, ',', '.') }}
                                                                L</strong>
                                                        </td>
                                                        <td class="text-right"><strong>R$
                                                                {{ number_format($totalAnoValor, 2, ',', '.') }}</strong>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>
                                                                R$
                                                                {{ number_format($totalAnoLitros > 0 ? $totalAnoValor / $totalAnoLitros : 0, 3, ',', '.') }}
                                                            </strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            @endif
                                        </table>
                                    </div>

                                    @if ($evolucaoMensal->count() === 0)
                                        <div class="text-center py-4">
                                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Nenhum dado encontrado para o ano {{ $ano }}
                                            </h5>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Gráfico de Barras Simulado -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Evolução Mensal - Valor
                                                Gasto (R$)</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($evolucaoMensal->count() > 0)
                                                <div class="row">
                                                    @foreach ($evolucaoMensal->sortBy('mes') as $mes)
                                                        @php
                                                            $maxValor = $evolucaoMensal->max('total_valor');
                                                            $altura =
                                                                $maxValor > 0
                                                                    ? ($mes->total_valor / $maxValor) * 100
                                                                    : 0;
                                                        @endphp
                                                        <div class="col-md-2 mb-3">
                                                            <div class="text-center">
                                                                <div class="mb-2">
                                                                    <small
                                                                        class="text-muted">{{ substr($meses[$mes->mes] ?? 'Mês', 0, 3) }}</small>
                                                                </div>
                                                                <div class="d-flex align-items-end justify-content-center"
                                                                    style="height: 120px;">
                                                                    <div class="bg-primary rounded"
                                                                        style="width: 30px; height: {{ $altura }}%;">
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <small class="text-success">
                                                                        R$
                                                                        {{ number_format($mes->total_valor, 0, ',', '.') }}
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

                            <!-- Comparação por Combustível -->
                            @if (!$combustivel)
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0"><i class="fas fa-balance-scale"></i> Comparação por
                                                    Tipo de Combustível - Ano
                                                    {{ $ano }}</h5>
                                            </div>
                                            <div class="card-body">
                                                @php
                                                    $agrupadoPorCombustivel = $evolucaoMensal->groupBy('combustivel');
                                                @endphp

                                                @if ($agrupadoPorCombustivel->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Combustível</th>
                                                                    <th>Total Valor</th>
                                                                    <th>Total Litros</th>
                                                                    <th>Abastecimentos</th>
                                                                    <th>Preço Médio/L</th>
                                                                    <th>% do Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($agrupadoPorCombustivel as $tipo => $dados)
                                                                    @php
                                                                        $totalTipoValor = $dados->sum('total_valor');
                                                                        $totalTipoLitros = $dados->sum('total_litros');
                                                                        $totalTipoAbastecimentos = $dados->sum(
                                                                            'total_abastecimentos',
                                                                        );
                                                                        $percentual =
                                                                            $totalAnoValor > 0
                                                                                ? ($totalTipoValor / $totalAnoValor) *
                                                                                    100
                                                                                : 0;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>
                                                                            <strong>{{ $tiposCombustivel[$tipo] ?? 'Combustível ' . $tipo }}</strong>
                                                                        </td>
                                                                        <td class="text-success">R$
                                                                            {{ number_format($totalTipoValor, 2, ',', '.') }}
                                                                        </td>
                                                                        <td>{{ number_format($totalTipoLitros, 1, ',', '.') }}
                                                                            L</td>
                                                                        <td class="text-center">
                                                                            {{ $totalTipoAbastecimentos }}</td>
                                                                        <td>R$
                                                                            {{ number_format($totalTipoLitros > 0 ? $totalTipoValor / $totalTipoLitros : 0, 3, ',', '.') }}
                                                                        </td>
                                                                        <td>
                                                                            <div class="progress" style="height: 15px;">
                                                                                <div class="progress-bar bg-info"
                                                                                    style="width: {{ $percentual }}%">
                                                                                    {{ number_format($percentual, 1) }}%
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="text-muted text-center">Nenhum dado disponível para
                                                        comparação</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
