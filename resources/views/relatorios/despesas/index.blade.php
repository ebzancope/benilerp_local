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
                                <i class="fas fa-chart-pie mr-2"></i>Relatório de Despesas
                            </h5>
                            <small class="text-white-50">Análise detalhada das despesas</small>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm" id="printReport">
                                <i class="fas fa-print mr-1"></i>Imprimir
                            </button>

                            <a href="{{ route('despesas.imprimir', request()->query()) }}"
                                class="btn btn-info rounded-pill" title="Imprimir Relatório">
                                <i class="fas fa-print"></i> Imprimir novo Botao
                            </a>


                            <a href="{{ route('relatorios.despesas.imprimir', request()->query()) }}"
                                class="btn btn-light btn-sm" title="Imprimir">
                                <i class="fas fa-print mr-1"></i>Imprimir novo Botao 2
                            </a>


                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Exportar
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- ✅ VERIFICAÇÃO DE ERRO -->


                    <!-- Filtros Expandíveis -->
                    <div class="card mb-4 border">

                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-pie mr-2"></i>Relatório de Despesas
                                    </h5>
                                    <small class="text-white-50">Análise detalhada das despesas</small>
                                </div>
                                <div class="btn-group">
                                    <!-- ✅ BOTÃO IMPRIMIR -->
                                    <a href="{{ route('relatorios.despesas.imprimir', request()->query()) }}"
                                        class="btn btn-light btn-sm" title="Imprimir Relatório">
                                        <i class="fas fa-print mr-1"></i>Imprimir
                                    </a>

                                    <!-- Botões existentes -->
                                    <button type="button" class="btn btn-light btn-sm" id="printReport">
                                        <i class="fas fa-print mr-1"></i>Imprimir (Página)
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Exportar
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i
                                                class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-header py-2 bg-light" data-toggle="collapse" href="#filtersCollapse"
                            role="button" aria-expanded="true">
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
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="date" name="data_inicio" class="form-control"
                                                        value="{{ $dataInicio ??  date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Data Fim</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="date" name="data_fim" class="form-control"
                                                        value="{{ $dataFim ?? date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Tipo de Conta</label>
                                                <select name="tipo_conta" class="form-control select2">
                                                    <option value="">Todos os Tipos</option>
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
                                                <label class="font-weight-bold">Ordenar por</label>
                                                <select name="ordenar" class="form-control">
                                                    <option value="valor_desc" {{ request('ordenar')=='valor_desc'
                                                        ? 'selected' : '' }}>Maior Valor</option>
                                                    <option value="valor_asc" {{ request('ordenar')=='valor_asc'
                                                        ? 'selected' : '' }}>Menor Valor</option>
                                                    <option value="nome_asc" {{ request('ordenar')=='nome_asc'
                                                        ? 'selected' : '' }}>Nome A-Z</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtros Rápidos -->
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary periodo-rapido"
                                                    data-dias="30">Últimos 30 dias</button>
                                                <button type="button" class="btn btn-outline-secondary periodo-rapido"
                                                    data-dias="90">Últimos 3 meses</button>
                                                <button type="button" class="btn btn-outline-secondary periodo-rapido"
                                                    data-mes="atual">Mês Atual</button>
                                                <button type="button" class="btn btn-outline-secondary periodo-rapido"
                                                    data-ano="atual">Ano Atual</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        id="limparFiltros">
                                                        <i class="fas fa-eraser mr-1"></i>Limpar Filtros
                                                    </button>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-search mr-1"></i>Aplicar Filtros
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Resumo Estatístico -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total de Despesas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                R$ {{ number_format($totalDespesas ?? 0, 2, ',', '. ') }}
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $dataInicioFormatada ?? date('d/m/Y') }} até {{ $dataFimFormatada
                                                    ?? date('d/m/Y') }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tipos de Despesa</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $despesasPorTipo->count() ?? 0 }}
                                            </div>

                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Média Diária</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                R$ {{ number_format($mediaDiaria ?? 0, 2, ',', '.') }}
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-info">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $numeroDias ?? 0 }} dias analisados
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Maior Despesa</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                R$ {{ number_format($maiorDespesa ?? 0, 2, ',', '.') }}
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-warning">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $tipoMaiorDespesa ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verificação se há dados -->
                    @if(isset($despesasPorTipo) && $despesasPorTipo->isEmpty())
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Nenhuma despesa encontrada para o período selecionado.
                    </div>
                    @elseif(isset($despesasPorTipo) && $despesasPorTipo->isNotEmpty())
                    <!-- Gráficos com Tabs -->
                    <div class="card mb-4">
                        <div class="card-header bg-white border-bottom">
                            <ul class="nav nav-tabs card-header-tabs" id="chartTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pie-tab" data-toggle="tab" href="#pie" role="tab">
                                        <i class="fas fa-chart-pie mr-1"></i>Por Tipo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="line-tab" data-toggle="tab" href="#line" role="tab">
                                        <i class="fas fa-chart-line mr-1"></i>Evolução
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bar-tab" data-toggle="tab" href="#bar" role="tab">
                                        <i class="fas fa-chart-bar mr-1"></i>Comparativo
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="chartTabsContent">
                                <!-- TAB 1: PIE CHART -->
                                <div class="tab-pane fade show active" id="pie" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div style="position: relative; height: 400px;">
                                                <canvas id="graficoPorTipo"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="legend-container" id="graficoLegenda"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 2: LINE CHART -->
                                <div class="tab-pane fade" id="line" role="tabpanel">
                                    <div style="position: relative; height: 400px;">
                                        <canvas id="graficoPorMes"></canvas>
                                    </div>
                                </div>

                                <!-- TAB 3: BAR CHART -->
                                <div class="tab-pane fade" id="bar" role="tabpanel">
                                    <div style="position: relative; height: 400px;">
                                        <canvas id="graficoBarras"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela Detalhada com Funcionalidades -->
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-table mr-2"></i>Detalhamento por Tipo
                                </h6>
                                <div>
                                    <input type="text" id="searchTable" class="form-control form-control-sm"
                                        placeholder="Buscar tipo..." style="width: 200px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="detailedTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="40%">
                                                <a href="#" class="sortable" data-sort="tipo">Tipo de Conta</a>
                                            </th>
                                            <th width="20%" class="text-right">
                                                <a href="#" class="sortable" data-sort="valor">Valor Total</a>
                                            </th>
                                            <th width="20%" class="text-right">
                                                <a href="#" class="sortable" data-sort="percentual">Percentual</a>
                                            </th>
                                            <th width="20%" class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($despesasPorTipo as $index => $despesa)
                                        @php
                                        $percentual = 0;
                                        if (isset($totalDespesas) && $totalDespesas > 0) {
                                        $percentual = ($despesa->total / $totalDespesas) * 100;
                                        }
                                        $corBarra = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                                        @endphp
                                        <tr data-tipo="{{ $despesa->tipoconta }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="color-indicator mr-2"
                                                        style="background-color: {{ $corBarra }}; width: 12px; height: 12px; border-radius: 2px;">
                                                    </div>
                                                    <strong>{{ $tiposContas[$despesa->tipoconta] ?? $despesa->tipoconta
                                                        }}</strong>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <span class="font-weight-bold">R$ {{ number_format($despesa->total, 2,
                                                    ',', '.') }}</span>
                                            </td>
                                            <td class="text-right">
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $percentual }}%; background-color: {{ $corBarra }};"
                                                        aria-valuenow="{{ $percentual }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        <span class="progress-text">{{ number_format($percentual, 1)
                                                            }}%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary btn-detalhes"
                                                    data-tipo="{{ $despesa->tipoconta }}" data-toggle="tooltip"
                                                    title="Ver detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                    data-toggle="tooltip" title="Exportar tipo">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td><strong>Total Geral</strong></td>
                                            <td class="text-right">
                                                <strong>R$ {{ number_format($totalDespesas ?? 0, 2, ',', '.')
                                                    }}</strong>
                                            </td>
                                            <td class="text-right"><strong>100%</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Resumo Textual -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-file-alt mr-2"></i>Resumo Analítico
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Principais Insights</h6>
                                        <p class="mb-0">
                                            @php
                                            $primeiroPercentual = 0;
                                            if (isset($totalDespesas) && $totalDespesas > 0 &&
                                            $despesasPorTipo->isNotEmpty()) {
                                            $primeiroPercentual = ($despesasPorTipo->first()->total / $totalDespesas) *
                                            100;
                                            }
                                            @endphp
                                            As despesas do período somam <strong>R$ {{ number_format($totalDespesas ??
                                                0, 2, ',', '.') }}</strong>,
                                            distribuídas em <strong>{{ $despesasPorTipo->count() ?? 0 }}</strong>
                                            categorias
                                            diferentes.
                                            @if(isset($despesasPorTipo) && $despesasPorTipo->isNotEmpty())
                                            A categoria <strong>{{ $tiposContas[$despesasPorTipo->first()->tipoconta] ??
                                                $despesasPorTipo->first()->tipoconta }}</strong>
                                            representa a maior parte das despesas com
                                            <strong>{{ number_format($primeiroPercentual, 1) }}%</strong> do total.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Rodapé com informações -->
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-6">
                            <small>
                                <i class="fas fa-info-circle mr-1"></i>
                                Relatório gerado em {{ now()->format('d/m/Y H:i: s') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-right">
                            <small>
                                <i class="fas fa-user mr-1"></i>
                                Usuário: {{ auth()->user()->name ?? 'Sistema' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalhes -->
<div class="modal fade" id="detalhesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalhes da Despesa</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDetalhesContent">
                <!-- Conteúdo carregado via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .color-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 2px;
        margin-right: 8px;
    }

    .progress-text {
        position: absolute;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #333;
        font-weight: bold;
    }

    .progress {
        position: relative;
        background-color: #f8f9fa;
    }

    .sortable: hover {
        text-decoration: none;
        color: #007bff;
    }

    .legend-container {
        max-height: 300px;
        overflow-y: auto;
    }

    . legend-item {
        padding: 5px;
        margin-bottom: 5px;
        border-radius: 3px;
        background: #f8f9fa;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔵 DOM Carregado - Inicializando gráficos...');

        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // ✅ DADOS DO SERVIDOR
        const labels = @json($graficoPorTipoLabels ??  []);
        const dataGrafico = @json($graficoPorTipoData ?? []);
        const labelsmes = @json($graficoPorMesLabels ?? []);
        const datames = @json($graficoPorMesData ?? []);

        console.log('📊 Labels Tipo:', labels);
        console.log('📊 Data Tipo:', dataGrafico);
        console.log('📊 Labels Mês:', labelsmes);
        console.log('📊 Data Mês:', datames);

        // Cores para gráficos
        const chartColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384',
            '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
        ];

        // ============================================
        // 1️⃣ GRÁFICO DE PIZZA - POR TIPO
        // ============================================
        const ctxTipo = document.getElementById('graficoPorTipo');
        if (ctxTipo && labels.length > 0 && dataGrafico.length > 0) {
            console.log('✅ Criando gráfico de pizza...');

            new Chart(ctxTipo, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataGrafico,
                        backgroundColor: chartColors. slice(0, labels.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio:  false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data. reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: R$ ${value.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // ✅ GERAR LEGENDA PERSONALIZADA
            const legendContainer = document.getElementById('graficoLegenda');
            if (legendContainer) {
                const total = dataGrafico.reduce((a, b) => a + b, 0);
                legendContainer.innerHTML = '';

                labels.forEach((label, index) => {
                    const value = dataGrafico[index] || 0;
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;

                    const legendItem = document.createElement('div');
                    legendItem.className = 'legend-item d-flex align-items-center mb-2';
                    legendItem.innerHTML = `
                        <div class="color-indicator mr-2" style="background-color: ${chartColors[index] || '#ccc'}; width: 16px; height:  16px; border-radius:  3px;"></div>
                        <div class="flex-grow-1">
                            <small class="font-weight-bold">${label}</small><br>
                            <small class="text-muted">R$ ${value.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (${percentage}%)</small>
                        </div>
                    `;
                    legendContainer.appendChild(legendItem);
                });
            }
        } else {
            console.warn('⚠️ Sem dados para gráfico de pizza');
        }

        // ============================================
        // 2️⃣ GRÁFICO DE LINHA - EVOLUÇÃO MENSAL
        // ============================================
        const ctxMes = document.getElementById('graficoPorMes');
        if (ctxMes && labelsmes.length > 0 && datames. length > 0) {
            console.log('✅ Criando gráfico de linha.. .');

            new Chart(ctxMes, {
                type: 'line',
                data: {
                    labels:  labelsmes,
                    datasets: [{
                        label: 'Despesas por Mês',
                        data: datames,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#36A2EB',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero:  true,
                            ticks:  {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 0});
                                }
                            },
                            grid: {
                                drawBorder: true
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'R$ ' + context.raw.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console. warn('⚠️ Sem dados para gráfico de linha');
        }

        // ============================================
        // 3️⃣ GRÁFICO DE BARRAS - COMPARATIVO
        // ============================================
        const ctxBarras = document.getElementById('graficoBarras');
        if (ctxBarras && labels.length > 0 && dataGrafico.length > 0) {
            console.log('✅ Criando gráfico de barras...');

            new Chart(ctxBarras, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Valor por Tipo',
                        data:  dataGrafico,
                        backgroundColor: chartColors. slice(0, labels.length).map(c => c + 'CC'),
                        borderColor: chartColors.slice(0, labels. length),
                        borderWidth:  2,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 0});
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'R$ ' + context.raw.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console.warn('⚠️ Sem dados para gráfico de barras');
        }

        // ============================================
        // FUNCIONALIDADES ADICIONAIS
        // ============================================

        // Buscar na tabela
        const searchInput = document.getElementById('searchTable');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#detailedTable tbody tr');
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
                });
            });
        }

        // Filtros rápidos
        document.querySelectorAll('. periodo-rapido').forEach(button => {
            button.addEventListener('click', function() {
                const dias = this.dataset.dias;
                const mes = this.dataset.mes;
                const ano = this.dataset.ano;

                let dataInicio = new Date();
                let dataFim = new Date();

                if (dias) {
                    dataInicio. setDate(dataInicio.getDate() - parseInt(dias));
                } else if (mes === 'atual') {
                    dataInicio = new Date(dataFim.getFullYear(), dataFim.getMonth(), 1);
                } else if (ano === 'atual') {
                    dataInicio = new Date(dataFim.getFullYear(), 0, 1);
                }

                document.querySelector('input[name="data_inicio"]').value = dataInicio.toISOString().split('T')[0];
                document. querySelector('input[name="data_fim"]').value = dataFim.toISOString().split('T')[0];
                document.getElementById('filterForm').submit();
            });
        });

        // Limpar filtros
        const btnLimpar = document.getElementById('limparFiltros');
        if (btnLimpar) {
            btnLimpar.addEventListener('click', function() {
                document.querySelectorAll('#filterForm input[type="date"], #filterForm select').forEach(input => {
                    if (input.type === 'date') {
                        input.value = '';
                    } else {
                        input.selectedIndex = 0;
                    }
                });
                document.getElementById('filterForm').submit();
            });
        }

        // Imprimir
        const btnPrint = document.getElementById('printReport');
        if (btnPrint) {
            btnPrint. addEventListener('click', function() {
                window.print();
            });
        }

        // Modal de detalhes
        document.querySelectorAll('.btn-detalhes').forEach(button => {
            button.addEventListener('click', function() {
                const tipo = this.dataset.tipo;
                const dataInicio = document.querySelector('input[name="data_inicio"]').value;
                const dataFim = document.querySelector('input[name="data_fim"]').value;

                document.getElementById('modalDetalhesContent').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Carregando... </span>
                        </div>
                        <p class="mt-2">Carregando detalhes... </p>
                    </div>
                `;
                $('#detalhesModal').modal('show');
            });
        });

        console.log('✅ Scripts inicializados com sucesso!');
    });
</script>
@endpush