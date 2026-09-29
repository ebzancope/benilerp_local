@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-line mr-2"></i>Relatório Consolidado de Despesas
                            </h5>
                            <small class="text-white-50">Análise completa do período</small>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm" id="printReport">
                                <i class="fas fa-print mr-1"></i>Imprimir
                            </button>
                            <a href="{{ route('relatorios. despesas.pdf') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-file-pdf mr-1"></i>PDF
                            </a>
                            <a href="{{ route('relatorios.despesas.excel') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-file-excel mr-1"></i>Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- ✅ VERIFICAÇÃO DE ERRO -->
                    @if(isset($erro) && $erro)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle mr-2"></i>Erro: </strong> {{ $erro }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Filtros -->
                    <div class="card mb-4 border">
                        <div class="card-header py-2 bg-light" data-toggle="collapse" href="#filtersCollapse"
                            role="button">
                            <h6 class="mb-0">
                                <i class="fas fa-filter mr-2"></i>Filtros
                                <i class="fas fa-chevron-down float-right"></i>
                            </h6>
                        </div>

                        <div class="collapse show" id="filtersCollapse">
                            <div class="card-body">
                                <form method="GET" id="filterForm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Data Início</label>
                                                <input type="date" name="data_inicio" class="form-control"
                                                    value="{{ $dataInicio ??   date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Data Fim</label>
                                                <input type="date" name="data_fim" class="form-control"
                                                    value="{{ $dataFim ??  date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Tipo de Conta</label>
                                                <select name="tipo_conta" class="form-control">
                                                    <option value="">Todos</option>
                                                    @foreach($tiposContas as $key => $tipo)
                                                    <option value="{{ $key }}" {{ request('tipo_conta')==$key
                                                        ? 'selected' : '' }}>
                                                        {{ $tipo }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fas fa-search mr-1"></i>Aplicar Filtros
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Resumo Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                        Despesas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        R$ {{ number_format($totalDespesas ?? 0, 2, ',', '. ') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total
                                        Registros</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalRegistros ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Média Diária
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        R$ {{ number_format($mediaDiaria ?? 0, 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Maior Despesa
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        R$ {{ number_format($maiorDespesa ?? 0, 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($despesasPorTipo) && $despesasPorTipo->isNotEmpty())
                    <!-- Gráficos -->
                    <div class="row mb-4">
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Por Tipo</h6>
                                </div>
                                <div class="card-body" style="height: 400px;">
                                    <canvas id="graficoPorTipo"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Evolução Mensal</h6>
                                </div>
                                <div class="card-body" style="height: 400px;">
                                    <canvas id="graficoPorMes"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-file-invoice mr-2"></i>Por Documento</h6>
                                </div>
                                <div class="card-body" style="height: 400px;">
                                    <canvas id="graficoPorDocumento"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela Consolidada -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-table mr-2"></i>Despesas por Tipo
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tipo</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-right">Quantidade</th>
                                            <th class="text-right">Percentual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($despesasPorTipo as $item)
                                        @php
                                        $percentual = 0;
                                        if (isset($totalDespesas) && $totalDespesas > 0) {
                                        $percentual = ($item->total / $totalDespesas) * 100;
                                        }
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $tiposContas[$item->tipoconta] ?? $item->tipoconta
                                                    }}</strong>
                                            </td>
                                            <td class="text-right">
                                                R$ {{ number_format($item->total, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ $item->count }}
                                            </td>
                                            <td class="text-right">
                                                <span class="badge badge-primary">{{ number_format($percentual, 1)
                                                    }}%</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td><strong>TOTAL</strong></td>
                                            <td class="text-right"><strong>R$ {{ number_format($totalDespesas ?? 0, 2,
                                                    ',', '.') }}</strong></td>
                                            <td class="text-right"><strong>{{ $totalRegistros ?? 0 }}</strong></td>
                                            <td class="text-right"><strong>100%</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Nenhuma despesa encontrada para o período selecionado.
                    </div>
                    @endif
                </div>

                <div class="card-footer text-muted">
                    <small>
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $dataInicioFormatada ?? date('d/m/Y') }} até {{ $dataFimFormatada ?? date('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
        ];

        // Dados do servidor
        const labelsTipo = @json($graficoPorTipoLabels ??  []);
        const dataTipo = @json($graficoPorTipoData ?? []);
        const labelsMes = @json($graficoPorMesLabels ?? []);
        const dataMes = @json($graficoPorMesData ?? []);
        const labelsDoc = @json($graficoPorDocumentoLabels ??  []);
        const dataDoc = @json($graficoPorDocumentoData ?? []);

        // Gráfico Por Tipo
        if (document.getElementById('graficoPorTipo') && labelsTipo.length > 0) {
            new Chart(document.getElementById('graficoPorTipo'), {
                type: 'doughnut',
                data: {
                    labels: labelsTipo,
                    datasets: [{
                        data: dataTipo,
                        backgroundColor: chartColors. slice(0, labelsTipo.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Gráfico Por Mês
        if (document.getElementById('graficoPorMes') && labelsMes.length > 0) {
            new Chart(document.getElementById('graficoPorMes'), {
                type: 'line',
                data: {
                    labels: labelsMes,
                    datasets: [{
                        label: 'Despesas',
                        data: dataMes,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true }
                    },
                    scales: {
                        y: {
                            beginAtZero:  true,
                            ticks:  {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        }

        // Gráfico Por Documento
        if (document.getElementById('graficoPorDocumento') && labelsDoc.length > 0) {
            new Chart(document.getElementById('graficoPorDocumento'), {
                type: 'bar',
                data: {
                    labels:  labelsDoc,
                    datasets: [{
                        label: 'Valor',
                        data: dataDoc,
                        backgroundColor: chartColors.slice(0, labelsDoc.length),
                        borderColor: chartColors.slice(0, labelsDoc.length),
                        borderWidth: 1
                    }]
                },
                options:  {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend:  { display: false }
                    },
                    scales: {
                        y:  {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        }

        // Imprimir
        document.getElementById('printReport')?.addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endpush
