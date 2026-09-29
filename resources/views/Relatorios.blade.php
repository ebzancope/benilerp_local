@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius:10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12 "
                            style="border-radius:2%;background-color: #f6faf4; color: rgb(90, 86, 86);">
                            <script type="text/javascript">
                                google.charts.load('current', {
                                                            'packages': ['bar']
                                                        });
                                                        google.charts.setOnLoadCallback(drawChart);
                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([
                                                                ['Perído de 01/03 a 31/03', 'Água', 'Luz', 'Pedagio', 'Imposto', 'DARF', 'Contador'],
                                                                ['Item', 1400.48, 850.00, 550.48, 55.8, 3581.45, 358.00],
                                                            ]);
                                                            var options = {
                                                                chart: {
                                                                    title: 'Relatório de depesas gerais.',
                                                                    subtitle: 'Perído de 01/03 a 31/03',
                                                                }
                                                            };
                                                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                                                            chart.draw(data, google.charts.Bar.convertOptions(options));
                                                        }
                                                        google.charts.setOnLoadCallback(drawChartd);
                                                        function drawChartd() {
                                                            var datas = google.visualization.arrayToDataTable([
                                                                ['2º Trimestre', 'Entradas', 'Saídas'],
                                                                ['Janeiro', 700, 400],
                                                                ['Fevereiro', 870, 460],
                                                                ['Fevereiro', 870, 460],
                                                                ['Fevereiro', 870, 460],
                                                                ['Março', 960, 550]
                                                            ]);
                                                            var optionss = {
                                                                chart: {
                                                                    title: '2º Relatório Trimestral',
                                                                    subtitle: 'Entradas Saídas: 2º Trimestre',
                                                                }
                                                            };
                                                            var chartx = new google.charts.Bar(document.getElementById('columnchart_materials'));
                                                            chartx.draw(datas, google.charts.Bar.convertOptions(optionss));
                                                        }
                            </script>
                            <script type="text/javascript">
                                google.charts.load('current', {
                                                            'packages': ['corechart']
                                                        });
                                                        google.charts.setOnLoadCallback(drawChart);
                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([
                                                                ['Task', 'Hours per Day'],
                                                                ['Work', 11],
                                                                ['Eat', 2],
                                                                ['Commute', 2],
                                                                ['Watch TV', 2],
                                                                ['Sleep', 7]
                                                            ]);
                                                            var options = {
                                                                title: 'My Daily Activities',

                                                            };
                                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                                                            chart.draw(data, options);
                                                        }
                            </script>
                            <div class="slim-mainpanel">
                                <div class="container">
                                    <div class="section-wrapper">
                                        <label class="section-title">RELATÓRIOS Trimestrais
                                            2025</label>
                                        <p class="mg-b-20 mg-sm-b-40">Resultado da Gestão</p>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="bd pd-l-20 pd-y-30 pd-r-30">
                                                    <div id="chartBar1" class="ht-200 ht-sm-300">
                                                        <div id="columnchart_material"
                                                            style="width: 100%; height: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mg-t-20 mg-xl-t-0">
                                                <div class="bd pd-l-20 pd-y-30 pd-r-30">
                                                    <div id="chart_div" class="ht-200 ht-sm-300">
                                                        <div id="columnchart_materials"
                                                            style="width: 100%; height: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- section-wrapper -->
                                </div><!-- container -->
                            </div><!-- slim-mainpanel -->
                            @if (count($relatorios) == 0)
                            <div><label class="section-title fst-italic " style="color: #30a300; "><i
                                        class="fa-solid fa-chart-line"></i> Relatorio </label>
                            </div>
                            <hr class="my-2">
                            <div class="row mt-5">
                                <div class="col text-center">
                                    <p class="display-6 mb-5 text-secondary opacity-50">Sem
                                        Relatorio cadastrados
                                    </p>
                                    <a href="#?place=2" class="btn btn-secondary btn-lg p-3 px-5 rounded-pill">
                                        <i class="fa-solid fa-chart-line"></i> Cadastrar
                                        Relatorio
                                    </a>
                                </div>
                            </div>
                            @else
                            <label class="section-title fst-italic " style="color: #30a300; "><i
                                    class="fa-solid fa-chart-line"></i>Relatorio</label>
                            <hr class="my-2">
                            @include('list_relatorios')
                            @endif
                        </div><!-- timeline- -->
                    </div><!-- group -->
                </div><!-- card -->
            </div><!-- ol lg-->
        </div><!-- timeline-p5 -->
    </div>
</div>
@endsection