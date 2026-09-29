@extends('layouts.layout')

@section('content')

<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Bootstrap CSS (opcional) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .chart-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 30px;
    }

    .chart-title {
        color: #333;
        margin-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .filtro-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
</style>
</head>

<body>
    <div class="container-fluid py-4">
        <!-- Filtros -->
        <div class="filtro-container">
            <h2>Relatório de Despesas</h2>
            <form method="GET" action="{{ route('relatorio.despesas') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                        value="{{ $dataInicio ?? date('Y-m-01') }}">
                </div>
                <div class="col-md-4">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim"
                        value="{{ $dataFim ?? date('Y-m-t') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>

        <!-- Gráfico 1: Despesas por Tipo -->
        <div class="chart-container">
            <h3 class="chart-title">Top 10 Despesas por Tipo</h3>
            <div id="columnchart_tipos" style="width: 100%; height: 500px;"></div>
        </div>

        <!-- Gráfico 2: Evolução Mensal -->
        <div class="chart-container">
            <h3 class="chart-title">Evolução das Despesas por Mês</h3>
            <div id="columnchart_mensal" style="width: 100%; height: 500px;"></div>
        </div>

        <!-- Gráfico 3: Pizza por Tipo de Documento -->
        <div class="chart-container">
            <h3 class="chart-title">Distribuição por Tipo de Documento</h3>
            <div id="piechart_documentos" style="width: 100%; height: 500px;"></div>
        </div>
    </div>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar', 'corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawChartTipos();
            drawChartMensal();
            drawChartPizza();
        }

        function drawChartTipos() {
            // Dados processados no controller
            var dadosBrutos = {!! json_encode($dadosGraficoPorTipo) !!};

            var dataArray = [['Tipo de Despesa', 'Valor Total']];

            for (var tipo in dadosBrutos) {
                if (dadosBrutos.hasOwnProperty(tipo)) {
                    dataArray.push([tipo, dadosBrutos[tipo]]);
                }
            }

            var data = google.visualization.arrayToDataTable(dataArray);

            var options = {
                chart: {
                    title: 'Top 10 Despesas por Tipo',
                    subtitle: 'Período de {{ $dataInicioFormatada }} a {{ $dataFimFormatada }}'
                },
                colors: ['#4285F4'],
                bars: 'vertical',
                vAxis: {
                    format: 'R$ #,##0.00',
                    title: 'Valor (R$)'
                },
                hAxis: {
                    title: 'Tipo de Despesa'
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_tipos'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function drawChartMensal() {
            // Dados processados no controller
            var dadosBrutos = {!! json_encode($dadosGraficoPorMes['dados']) !!};

            var dataArray = [['Mês', 'Total de Despesas']];

            for (var mes in dadosBrutos) {
                if (dadosBrutos.hasOwnProperty(mes)) {
                    dataArray.push([mes, dadosBrutos[mes]]);
                }
            }

            var data = google.visualization.arrayToDataTable(dataArray);

            var options = {
                chart: {
                    title: 'Evolução Mensal das Despesas',
                    subtitle: 'Período de {{ $dataInicioFormatada }} a {{ $dataFimFormatada }}'
                },
                colors: ['#DB4437'],
                bars: 'vertical',
                vAxis: {
                    format: 'R$ #,##0.00',
                    title: 'Valor (R$)'
                },
                hAxis: {
                    title: 'Mês/Ano'
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_mensal'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function drawChartPizza() {
            // Dados processados no controller
            var dadosBrutos = {!! json_encode($dadosGraficoPizza) !!};

            var dataArray = [['Tipo de Documento', 'Valor Total']];

            for (var documento in dadosBrutos) {
                if (dadosBrutos.hasOwnProperty(documento)) {
                    dataArray.push([documento, dadosBrutos[documento]]);
                }
            }

            var data = google.visualization.arrayToDataTable(dataArray);

            var options = {
                title: 'Distribuição por Tipo de Documento - Período de {{ $dataInicioFormatada }} a {{ $dataFimFormatada }}',
                is3D: true,
                pieSliceText: 'value',
                tooltip: {text: 'value', format: 'R$ #,##0.00'},
                slices: {
                    0: { color: '#4285F4' },
                    1: { color: '#DB4437' },
                    2: { color: '#F4B400' },
                    3: { color: '#0F9D58' },
                    4: { color: '#AB47BC' },
                    5: { color: '#00ACC1' }
                },
                chartArea: {
                    width: '90%',
                    height: '80%'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_documentos'));
            chart.draw(data, options);
        }

        // Redimensionar gráficos quando a janela for redimensionada
        window.addEventListener('resize', function() {
            drawCharts();
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
