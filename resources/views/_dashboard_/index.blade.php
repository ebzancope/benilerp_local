@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Resumo do Mês -->
        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Receitas</span>
                        <span class="info-box-number">R$
                            {{ number_format($resumoMes['total_receitas'], 2, ',', '.') }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $resumoMes['total_receitas'] > 0 ? 100 : 0 }}%">
                            </div>
                        </div>
                        <span class="progress-description">
                            {{ $resumoMes['mes_referencia'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="fas fa-credit-card"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Despesas</span>
                        <span class="info-box-number">R$
                            {{ number_format($resumoMes['total_despesas'], 2, ',', '.') }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            {{ $resumoMes['mes_referencia'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box {{ $resumoMes['saldo'] >= 0 ? 'bg-info' : 'bg-warning' }}">
                    <span class="info-box-icon"><i class="fas fa-balance-scale"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Saldo</span>
                        <span class="info-box-number">R$ {{ number_format($resumoMes['saldo'], 2, ',', '.') }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            {{ $resumoMes['saldo'] >= 0 ? 'Positivo' : 'Negativo' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico e Estatísticas -->
        <div class="row">
            <!-- Gráfico Despesas vs Receitas -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Despesas vs Receitas - Últimos 6 Meses</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="graficoMensal" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Estatísticas Rápidas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Despesas Este Mês
                                    <span class="float-right badge bg-danger">
                                        R$ {{ number_format($estatisticas['despesas_mes_atual'], 2, ',', '.') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Variação vs Mês Anterior
                                    <span
                                        class="float-right badge {{ $estatisticas['variacao_despesas'] <= 0 ? 'bg-success' : 'bg-warning' }}">
                                        {{ number_format($estatisticas['variacao_despesas'], 1) }}%
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Total no Ano
                                    <span class="float-right badge bg-info">
                                        R$ {{ number_format($estatisticas['total_despesas_ano'], 2, ',', '.') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Qtde. Despesas (Mês)
                                    <span class="float-right badge bg-primary">
                                        {{ $estatisticas['quantidade_despesas_mes'] }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Despesas por Categoria -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Top Despesas por Categoria</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            @foreach ($despesasPorCategoria as $despesa)
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        {{ $despesa->categoria_nome }}
                                        <span class="float-right badge bg-danger">
                                            R$ {{ number_format($despesa->total, 2, ',', '.') }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimas Despesas e Alertas -->
        <div class="row mt-4">
            <!-- Últimas Despesas -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Últimas Despesas</h3>
                        <div class="card-tools">
                            <a href="{{ route('despesas.index') }}" class="btn btn-sm btn-primary">
                                Ver Todas
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Descrição</th>
                                        <th>Fornecedor</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ultimasDespesas as $despesa)
                                        <tr>
                                            <td>{{ $despesa->competencia->format('d/m/Y') }}</td>
                                            <td>{{ Str::limit($despesa->descricao ?? 'Sem descrição', 30) }}</td>
                                            <td>{{ $despesa->fornecedor->nome ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($ultimasDespesas->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Nenhuma despesa cadastrada recentemente.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas de Vencimento -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Alertas de Vencimento</h3>
                    </div>
                    <div class="card-body p-0">
                        @if (count($alertasVencimento) > 0)
                            <ul class="nav nav-pills flex-column">
                                @foreach ($alertasVencimento as $alerta)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            {{ $alerta->descricao }}
                                            <span class="float-right badge bg-warning">
                                                {{ $alerta->data_vencimento->format('d/m') }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center p-4">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <p class="text-muted">Nenhum vencimento próximo</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Ações Rápidas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('despesas.create') }}" class="btn btn-danger btn-block mb-2">
                                    <i class="fas fa-plus"></i> Nova Despesa
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('relatorios.despesas.index') }}" class="btn btn-info btn-block mb-2">
                                    <i class="fas fa-chart-bar"></i> Relatórios
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('despesas.index') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-list"></i> Ver Despesas
                                </a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-success btn-block" disabled title="Em breve">
                                    <i class="fas fa-plus"></i> Nova Receita
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico Despesas vs Receitas
        const ctx = document.getElementById('graficoMensal');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($graficoMensal['labels']),
                    datasets: [{
                            label: 'Despesas',
                            data: @json($graficoMensal['despesas']),
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545',
                            borderWidth: 1
                        },
                        {
                            label: 'Receitas',
                            data: @json($graficoMensal['receitas']),
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR', {
                                        minimumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': R$ ' + context.raw
                                        .toLocaleString('pt-BR', {
                                            minimumFractionDigits: 2
                                        });
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
