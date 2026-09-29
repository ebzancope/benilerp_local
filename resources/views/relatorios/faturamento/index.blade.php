@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <!-- Cabeçalho -->
                <div class="card-header bg-light" style="border-radius: 10px 10px 0 0;">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="mb-0" style="color: #30a300;">
                                <i class="fa-solid fa-chart-line"></i> Relatório de Faturamento
                            </h2>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('relatorios.faturamento.dashboard') }}"
                                class="btn btn-info rounded-pill mr-2">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="{{ route('relatorios.faturamento.exportar') }}"
                                class="btn btn-success rounded-pill">
                                <i class="fas fa-file-excel"></i> Exportar Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Cards de Resumo -->
                    <div class="row mb-4">
                        @php
                        $cards = [
                        [
                        'route' => route('relatorios.faturamento.index'),
                        'color' => 'primary',
                        'title' => 'Total Faturado',
                        'value' => 'R$ ' . number_format($totais['total_faturamento'] , 2, ',', '.'),
                        'icon' => 'fas fa-money-bill-wave'
                        ],
                        [
                        'route' => route('relatorios.faturamento.index') . '?order_by=tothmaquina&order_dir=desc',
                        'color' => 'success',
                        'title' => 'Horas Trabalhadas',
                        'value' => number_format($totais['total_horas'], 1, ',', '.') . 'h',
                        'icon' => 'fas fa-clock'
                        ],
                        [
                        'route' => route('relatorios.faturamento.index'),
                        'color' => 'info',
                        'title' => 'Média por Hora',
                        'value' => 'R$ ' . number_format($totais['media_hora'] , 2, ',', '.'),
                        'icon' => 'fas fa-chart-bar'
                        ],
                        [
                        'route' => route('relatorios.faturamento.index') . '?order_by=totmaquina&order_dir=desc',
                        'color' => 'warning',
                        'title' => 'Máquinas',
                        'value' => 'R$ ' . number_format($totais['total_maquina'] , 2, ',', '.'),
                        'icon' => 'fas fa-tractor'
                        ],
                        [
                        'route' => route('relatorios.faturamento.index') . '?order_by=totala&order_dir=desc',
                        'color' => 'secondary',
                        'title' => 'Acessórios',
                        'value' => 'R$ ' . number_format($totais['total_acessorios'], 2, ',', '.'),
                        'icon' => 'fas fa-tools'
                        ],
                        [
                        'route' => route('relatorios.faturamento.index'),
                        'color' => 'dark',
                        'title' => 'Qtd. OS',
                        'value' => $totais['quantidade_os'],
                        'icon' => 'fas fa-file-invoice'
                        ]
                        ];
                        @endphp

                        @foreach($cards as $card)
                        <div class="col-md-4 col-lg-2 mb-3">
                            <a href="{{ $card['route'] }}" class="text-decoration-none">
                                <div class="card bg-{{ $card['color'] }} text-white rounded-pill hover-card h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="{{ $card['icon'] }} mb-2 fs-4"></i>
                                        <h6 class="mb-2">{{ $card['title'] }}</h6>
                                        <h5 class="mb-0">{{ $card['value'] }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <!-- Filtros -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <form method="GET" action="{{ route('relatorios.faturamento.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Cliente</label>
                                        <select name="cliente" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ request('cliente')==$cliente->id ?
                                                'selected' : '' }}>
                                                {{ $cliente->nome }} {{ $cliente->apelido ? '('.$cliente->apelido.')' :
                                                '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Equipamento</label>
                                        <select name="equipamento" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach($equipamentos as $equipamento)
                                            <option value="{{ $equipamento->id }}" {{
                                                request('equipamento')==$equipamento->id ? 'selected' : '' }}>
                                                {{ $equipamento->codigo }} - {{ $equipamento->modelo }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Operador</label>
                                        <select name="operador" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach($operadores as $operador)
                                            <option value="{{ $operador->id }}" {{ request('operador')==$operador->id ?
                                                'selected' : '' }}>
                                                {{ $operador->nome }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Aprovadas
                                            </option>
                                            <option value="0" {{ request('status')=='0' ? 'selected' : '' }}>Pendentes
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Data Início</label>
                                        <input type="date" class="form-control rounded-pill" name="data_inicio"
                                            value="{{ request('data_inicio') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Data Fim</label>
                                        <input type="date" class="form-control rounded-pill" name="data_fim"
                                            value="{{ request('data_fim') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Agrupar por</label>
                                        <select name="agrupar_por" class="form-select rounded-pill">
                                            <option value="cliente" {{ request('agrupar_por')=='cliente' ? 'selected'
                                                : '' }}>Cliente</option>
                                            <option value="equipamento" {{ request('agrupar_por')=='equipamento'
                                                ? 'selected' : '' }}>Equipamento</option>
                                            <option value="operador" {{ request('agrupar_por')=='operador' ? 'selected'
                                                : '' }}>Operador</option>
                                            <option value="mes" {{ request('agrupar_por')=='mes' ? 'selected' : '' }}>
                                                Mês</option>
                                            <option value="dia" {{ request('agrupar_por')=='dia' ? 'selected' : '' }}>
                                                Dia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Ordenar por</label>
                                        <select name="order_by" class="form-select rounded-pill">
                                            <option value="datacadfat" {{ request('order_by')=='datacadfat' ? 'selected'
                                                : '' }}>Data</option>
                                            <option value="nome" {{ request('order_by')=='nome' ? 'selected' : '' }}>
                                                Cliente</option>
                                            <option value="codigo" {{ request('order_by')=='codigo' ? 'selected' : ''
                                                }}>Equipamento</option>
                                            <option value="totmaquina" {{ request('order_by')=='totmaquina' ? 'selected'
                                                : '' }}>Valor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Ordem</label>
                                        <select name="order_dir" class="form-select rounded-pill">
                                            <option value="desc" {{ request('order_dir')=='desc' ? 'selected' : '' }}>
                                                Descendente</option>
                                            <option value="asc" {{ request('order_dir')=='asc' ? 'selected' : '' }}>
                                                Ascendente</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                <i class="fas fa-filter"></i> Filtrar
                                            </button>
                                            <a href="{{ route('relatorios.faturamento.index') }}"
                                                class="btn btn-secondary rounded-pill px-4">
                                                <i class="fas fa-times"></i> Limpar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Busca Rápida -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <form method="GET" action="{{ route('relatorios.faturamento.index') }}">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label">Busca Rápida</label>
                                        <div class="input-group">
                                            <span class="input-group-text rounded-start-pill">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control rounded-end-pill" name="search"
                                                placeholder="Nome do cliente ou equipamento"
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nº OS</label>
                                        <input type="text" class="form-control rounded-pill" name="numos"
                                            placeholder="Número da OS" value="{{ request('numos') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nº Nota</label>
                                        <input type="text" class="form-control rounded-pill" name="numnota"
                                            placeholder="Número da Nota" value="{{ request('numnota') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success rounded-pill w-100" type="submit">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Agrupamento -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-bar"></i>
                                Agrupado por {{ ucfirst(request('agrupar_por', 'cliente')) }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ ucfirst(request('agrupar_por', 'cliente')) }}</th>
                                            <th class="text-end">Qtd. OS</th>
                                            <th class="text-end">Horas</th>
                                            <th class="text-end">Faturamento</th>
                                            <th class="text-end">Média/Hora</th>
                                            <th class="text-end">% do Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalFaturamento = $totais['total_faturamento'] ;
                                        @endphp
                                        @foreach($agrupamentos as $chave => $dados)
                                        @php
                                        $dados['total_faturamento'] = $dados['total_faturamento'] ;
                                        $dados['media_hora'] = $dados['media_hora'] ;
                                        $percentual = $totalFaturamento > 0 ? ($dados['total_faturamento'] /
                                        $totalFaturamento) * 100 : 0;
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $chave }}</strong></td>
                                            <td class="text-end">{{ $dados['quantidade_os'] }}</td>
                                            <td class="text-end">{{ number_format($dados['total_horas'], 1, ',', '.')
                                                }}h</td>
                                            <td class="text-end text-success fw-bold">
                                                R$ {{ number_format($dados['total_faturamento'], 2, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                R$ {{ number_format($dados['media_hora'], 2, ',', '.') }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $percentual }}%"
                                                                aria-valuenow="{{ $percentual }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="width: 60px; text-align: right;">
                                                        {{ number_format($percentual, 1) }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela Detalhada -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list"></i> Detalhamento das OS
                            </h5>
                            <span class="badge bg-primary rounded-pill">{{ $faturas->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">OS</th>
                                            <th>Data</th>
                                            <th>Cliente</th>
                                            <th>Equipamento</th>
                                            <th>Operador</th>
                                            <th class="text-end">Horas</th>
                                            <th class="text-end">Valor/Hora</th>
                                            <th class="text-end">Máquina</th>
                                            <th class="text-end">Acessórios</th>
                                            <th class="text-end">Total</th>
                                            <th>Status</th>
                                            <th class="pe-3 text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($faturas as $fatura)
                                        @php
                                        $totalFatura = ($fatura->totmaquina + $fatura->totala);
                                        @endphp
                                        <tr>
                                            <td class="ps-3">
                                                <strong>#{{ $fatura->numos }}</strong>
                                                @if($fatura->numnota)
                                                <br><small class="text-muted">NF: {{ $fatura->numnota }}</small>
                                                @endif
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($fatura->datacadfat)) }}</td>
                                            <td>
                                                <div>{{ $fatura->nome }}</div>
                                                @if($fatura->apelido)
                                                <small class="text-muted">{{ $fatura->apelido }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $fatura->codigo }}</span>
                                                <div class="small text-muted">{{ $fatura->modelo }}</div>
                                            </td>
                                            <td>{{ $fatura->nomeclie }}</td>
                                            <td class="text-end">
                                                <span class="badge bg-secondary">
                                                    {{ number_format($fatura->tothmaquina, 1, ',', '.') }}h
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                R$ {{ number_format($fatura->valhora, 2, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                R$ {{ number_format($fatura->totmaquina , 2, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                R$ {{ number_format($fatura->totala , 2, ',', '.') }}
                                            </td>
                                            <td class="text-end fw-bold text-success">
                                                R$ {{ number_format($totalFatura, 2, ',', '.') }}
                                            </td>
                                            <td>
                                                @if($fatura->aprovada)
                                                <span class="badge bg-success rounded-pill">Aprovada</span>
                                                @else
                                                <span class="badge bg-warning rounded-pill">Pendente</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-info rounded-start-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detalhesModal{{ $fatura->idfat }}"
                                                        title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="#" class="btn btn-warning rounded-end-pill" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="5" class="text-end ps-3">TOTAIS:</th>
                                            <th class="text-end">{{ number_format($totais['total_horas'], 1, ',', '.')
                                                }}h</th>
                                            <th class="text-end">-</th>
                                            <th class="text-end">R$ {{ number_format($totais['total_maquina'] , 2,
                                                ',', '.') }}</th>
                                            <th class="text-end">R$ {{ number_format($totais['total_acessorios'] ,
                                                2, ',', '.') }}</th>
                                            <th class="text-end">R$ {{ number_format($totais['total_faturamento'] ,
                                                2, ',', '.') }}</th>
                                            <th colspan="2" class="pe-3"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($faturas->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhum registro encontrado</h5>
                        <p class="text-muted">Tente ajustar seus filtros de busca</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modais de Detalhes -->
@foreach($faturas as $fatura)
@php
$totalFatura = ($fatura->totmaquina + $fatura->totala) ;
@endphp
<div class="modal fade" id="detalhesModal{{ $fatura->idfat }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice"></i> Detalhes da OS #{{ $fatura->numos }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-user"></i> Cliente</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>{{ $fatura->nome }}</strong></p>
                                @if($fatura->apelido)
                                <p class="mb-1 text-muted">Apelido: {{ $fatura->apelido }}</p>
                                @endif
                                @if($fatura->contato)
                                <p class="mb-1">Contato: {{ $fatura->contato }}</p>
                                @endif
                                @if($fatura->celular)
                                <p class="mb-0">Celular: {{ $fatura->celular }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-cogs"></i> Equipamento</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">
                                    <span class="badge bg-info">{{ $fatura->codigo }}</span>
                                    <strong>{{ $fatura->modelo }}</strong>
                                </p>
                                <p class="mb-0">Operador: {{ $fatura->nomeclie }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($fatura->descri)
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-file-alt"></i> Descrição</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $fatura->descri }}</p>
                    </div>
                </div>
                @endif

                <div class="row mt-3 g-3">
                    @if($fatura->horimini && $fatura->horimfim)
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Período</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">Início: {{ date('d/m/Y H:i', strtotime($fatura->horimini)) }}</p>
                                <p class="mb-0">Fim: {{ date('d/m/Y H:i', strtotime($fatura->horimfim)) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($fatura->servicos)
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-tasks"></i> Serviços</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $fatura->servicos }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-calculator"></i> Valores</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <tr>
                                <th>Horas Trabalhadas</th>
                                <td class="text-end">{{ number_format($fatura->tothmaquina, 1, ',', '.') }}h</td>
                            </tr>
                            <tr>
                                <th>Valor por Hora</th>
                                <td class="text-end">R$ {{ number_format($fatura->valhora, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Total Máquina</th>
                                <td class="text-end">R$ {{ number_format($fatura->totmaquina , 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Total Acessórios</th>
                                <td class="text-end">R$ {{ number_format($fatura->totala , 2, ',', '.') }}</td>
                            </tr>
                            <tr class="table-success">
                                <th><strong>TOTAL</strong></th>
                                <td class="text-end fw-bold fs-5">
                                    R$ {{ number_format($totalFatura, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.8em;
        padding: 0.35em 0.65em;
    }

    .progress {
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-radius: 15px 15px 0 0;
        padding: 1rem 1.5rem;
    }

    .btn-group-sm>.btn {
        padding: 0.25rem 0.5rem;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .card-header h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {

        .col-md-4,
        .col-md-3,
        .col-md-2 {
            margin-bottom: 1rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Filtro rápido na tabela
    const filterInput = document.createElement('input');
    filterInput.type = 'text';
    filterInput.className = 'form-control rounded-pill mb-3';
    filterInput.placeholder = 'Filtro rápido na tabela...';
    filterInput.style.maxWidth = '300px';

    const table = document.querySelector('.table-responsive table');
    if (table) {
        const tableWrapper = table.closest('.table-responsive');
        tableWrapper.parentNode.insertBefore(filterInput, tableWrapper);

        filterInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }

    // Auto-submit para agrupamento por
    const agruparPorSelect = document.querySelector('select[name="agrupar_por"]');
    if (agruparPorSelect) {
        agruparPorSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endpush