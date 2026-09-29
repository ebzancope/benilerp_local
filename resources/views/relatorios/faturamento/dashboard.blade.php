@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12"
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fa-solid fa-tachometer-alt"></i> Dashboard de Faturamento</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('relatorios.faturamento.index') }}"
                                        class="btn btn-primary rounded-pill">
                                        <i class="fas fa-chart-line"></i> Relatório Detalhado
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards Principais -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Faturamento Mês</h6>
                                            <h3 class="mb-0">R$ {{ number_format($faturamentoMesAtual, 2, ',', '.') }}
                                            </h3>
                                        </div>
                                        <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small>
                                            @if($faturamentoMesAnterior > 0)
                                            @php
                                            $variacao = (($faturamentoMesAtual - $faturamentoMesAnterior) /
                                            $faturamentoMesAnterior) * 100;
                                            @endphp
                                            <span class="{{ $variacao >= 0 ? 'text-success' : 'text-warning' }}">
                                                <i class="fas fa-arrow-{{ $variacao >= 0 ? 'up' : 'down' }}"></i>
                                                {{ number_format(abs($variacao), 1) }}%
                                            </span>
                                            vs mês anterior
                                            @else
                                            Sem comparação
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Horas Trabalhadas</h6>
                                            <h3 class="mb-0">{{ number_format($horasMesAtual, 1, ',', '.') }}h</h3>
                                        </div>
                                        <i class="fas fa-clock fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small>
                                            @if($horasMesAtual > 0)
                                            @php
                                            $mediaHora = $faturamentoMesAtual / $horasMesAtual;
                                            @endphp
                                            Média: R$ {{ number_format($mediaHora, 2, ',', '.') }}/hora
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Clientes Atendidos</h6>
                                            <h3 class="mb-0">{{ $clientesMesAtual }}</h3>
                                        </div>
                                        <i class="fas fa-users fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small>No mês atual</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Ticket Médio</h6>
                                            @if($clientesMesAtual > 0)
                                            <h3 class="mb-0">R$ {{ number_format($faturamentoMesAtual /
                                                $clientesMesAtual, 2, ',', '.') }}</h3>
                                            @else
                                            <h3 class="mb-0">R$ 0,00</h3>
                                            @endif
                                        </div>
                                        <i class="fas fa-chart-pie fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small>Por cliente</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos e Tabelas -->
                    <div class="row">
                        <!-- Gráfico de Faturamento Mensal -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-line"></i> Faturamento Mensal (Últimos 12 meses)
                                    </h5>
                                    <canvas id="faturamentoChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Top Equipamentos -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-hard-hat"></i> Top 5 Equipamentos
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Equipamento</th>
                                                    <th class="text-end">Horas</th>
                                                    <th class="text-end">OS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($equipamentosTop as $equipamento)
                                                <tr>
                                                    <td>
                                                        <small>{{ $equipamento->codigo }}</small><br>
                                                        <span class="fw-bold">{{ Str::limit($equipamento->modelo, 20)
                                                            }}</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge bg-info rounded-pill">
                                                            {{ number_format($equipamento->total_horas, 1, ',', '.') }}h
                                                        </span>
                                                    </td>
                                                    <td class="text-end">{{ $equipamento->total_os }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Top Clientes -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-crown"></i> Top 5 Clientes
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th class="text-end">Faturamento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($clientesTop as $cliente)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $cliente->nome }}</strong>
                                                        @if($cliente->apelido)
                                                        <br><small class="text-muted">{{ $cliente->apelido }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-end text-success fw-bold">
                                                        R$ {{ number_format($cliente->total_faturado, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Métricas de Performance -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-tachometer-alt"></i> Métricas de Performance
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted">Hora Máquina</h6>
                                                    @php
                                                    $mediaHoraMaquina = $horasMesAtual > 0 ? $faturamentoMesAtual /
                                                    $horasMesAtual : 0;
                                                    @endphp
                                                    <h4 class="text-primary">R$ {{ number_format($mediaHoraMaquina, 2,
                                                        ',', '.') }}</h4>
                                                    <small>Valor médio por hora</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted">OS por Cliente</h6>
                                                    @php
                                                    $mediaOsCliente = $clientesMesAtual > 0 ? $horasMesAtual /
                                                    $clientesMesAtual : 0;
                                                    @endphp
                                                    <h4 class="text-success">{{ number_format($mediaOsCliente, 1, ',',
                                                        '.') }}h</h4>
                                                    <small>Média de horas por cliente</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted">Dias Úteis</h6>
                                                    <h4 class="text-info">{{ date('t') - count([0,6]) }}</h4>
                                                    <small>Dias trabalhados no mês</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted">Meta Diária</h6>
                                                    @php
                                                    $diasUteis = date('t') - count([0,6]);
                                                    $metaDiaria = $diasUteis > 0 ? 10000 / $diasUteis : 0;
                                                    @endphp
                                                    <h4 class="text-warning">R$ {{ number_format($metaDiaria, 2, ',',
                                                        '.') }}</h4>
                                                    <small>Para atingir R$ 10.000/mês</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Relatórios Rápidos -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-bolt"></i> Acessos Rápidos
                                    </h5>
                                    <div class="row text-center">
                                        <div class="col-md-2">
                                            <a href="{{ route('relatorios.faturamento.index') }}?status=1&data_inicio={{ date('Y-m-01') }}&data_fim={{ date('Y-m-t') }}"
                                                class="text-decoration-none">
                                                <div class="card hover-card">
                                                    <div class="card-body">
                                                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                                        <h6>Este Mês</h6>
                                                        <small>Aprovadas</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('relatorios.faturamento.index') }}?status=0"
                                                class="text-decoration-none">
                                                <div class="card hover-card">
                                                    <div class="card-body">
                                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                                        <h6>Pendentes</h6>
                                                        <small>Aprovação</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('relatorios.faturamento.index') }}?data_inicio={{ date('Y-m-d', strtotime('-7 days')) }}"
                                                class="text-decoration-none">
                                                <div class="card hover-card">
                                                    <div class="card-body">
                                                        <i class="fas fa-calendar-week fa-2x text-primary mb-2"></i>
                                                        <h6>Últimos 7 dias</h6>
                                                        <small>Atividades</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('relatorios.faturamento.exportar') }}"
                                                class="text-decoration-none">
                                                <div class="card hover-card">
                                                    <div class="card-body">
                                                        <i class="fas fa-file-excel fa-2x text-success mb-2"></i>
                                                        <h6>Exportar</h6>
                                                        <small>Excel</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('relatorios.faturamento.index') }}?agrupar_por=equipamento"
                                                class="text-decoration-none">
                                                <div class="card hover-card">
                                                    <div class="card-body">
                                                        <i class="fas fa-chart-bar fa-2x text-info mb-2"></i>
                                                        <h6>Por Equipamento</h6>
                                                        <small>Agrupado</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('relatorios.faturamento.index') }}?order_by=totmaquina&order_dir=desc"
                                                class="text-decoration-none">
                                                <div class="card hover-card">
                                                    <div class="card-body">
                                                        <i class="fas fa-trophy fa-2x text-warning mb-2"></i>
                                                        <h6>Maiores OS</h6>
                                                        <small>Ranking</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- timeline-group -->
            </div><!-- card -->
        </div><!-- col-lg-12 -->
    </div><!-- row -->
</div><!-- container-fluid -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .card {
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dados para o gráfico
        const meses = {!! json_encode($faturamentoMensal->pluck('mes')) !!};
        const valores = {!! json_encode($faturamentoMensal->pluck('total')) !!};

        // Formatar meses
        const mesesFormatados = meses.map(mes => {
            const [ano, mesNum] = mes.split('-');
            const mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            return `${mesesNomes[parseInt(mesNum) - 1]}/${ano.slice(2)}`;
        });

        // Criar gráfico
        const ctx = document.getElementById('faturamentoChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: mesesFormatados,
                datasets: [{
                    label: 'Faturamento (R$)',
                    data: valores,
                    borderColor: '#30a300',
                    backgroundColor: 'rgba(48, 163, 0, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    y: {
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

        // Atualizar dados periodicamente (opcional)
        setInterval(() => {
            // Aqui você poderia fazer uma requisição AJAX para atualizar os dados
            console.log('Dashboard atualizado');
        }, 300000); // 5 minutos
    });
</script>
@endsection