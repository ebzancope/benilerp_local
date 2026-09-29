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
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300;">
                                    <h2><i class="fas fa-chart-bar"></i> Dashboard de Equipamentos</h2>
                                    <p class="mb-0">Visão geral e estatísticas dos equipamentos ativos</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('equipamentos.index') }}" class="btn btn-primary rounded-pill">
                                        <i class="fas fa-list"></i> Lista Completa
                                    </a>
                                    <a href="{{ route('equipamentos.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Novo Equipamento
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards de Resumo -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('equipamentos.index') }}" class="text-decoration-none">
                                <div class="card bg-primary text-white rounded-pill hover-card">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="me-3">
                                                <i class="fas fa-tools fa-2x"></i>
                                            </div>
                                            <div class="text-start">
                                                <h6 class="mb-0">Equipamentos Ativos</h6>
                                                <h4 class="mb-0">{{ $totalEquipamentos }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('equipamentos.index') }}?placa=1" class="text-decoration-none">
                                <div class="card bg-success text-white rounded-pill hover-card">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="me-3">
                                                <i class="fas fa-car fa-2x"></i>
                                            </div>
                                            <div class="text-start">
                                                <h6 class="mb-0">Com Placa</h6>
                                                <h4 class="mb-0">{{ $equipamentosComPlaca }}</h4>
                                                @if($totalEquipamentos > 0)
                                                <small class="opacity-75">
                                                    {{ round(($equipamentosComPlaca / $totalEquipamentos) * 100, 1) }}%
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('equipamentos.index') }}?placa=0" class="text-decoration-none">
                                <div class="card bg-warning text-white rounded-pill hover-card">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="me-3">
                                                <i class="fas fa-car-battery fa-2x"></i>
                                            </div>
                                            <div class="text-start">
                                                <h6 class="mb-0">Sem Placa</h6>
                                                <h4 class="mb-0">{{ $equipamentosSemPlaca }}</h4>
                                                @if($totalEquipamentos > 0)
                                                <small class="opacity-75">
                                                    {{ round(($equipamentosSemPlaca / $totalEquipamentos) * 100, 1) }}%
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('equipamentos.index') }}" class="text-decoration-none">
                                <div class="card bg-info text-white rounded-pill hover-card">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="me-3">
                                                <i class="fas fa-tags fa-2x"></i>
                                            </div>
                                            <div class="text-start">
                                                <h6 class="mb-0">Categorias</h6>
                                                <h4 class="mb-0">{{ $totalPorCategoria->count() }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Distribuição de Dados -->
                    <div class="row mb-4">
                        <!-- Distribuição por Categoria -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #30a300;">
                                        <i class="fas fa-chart-pie me-2"></i>Distribuição por Categoria
                                    </h5>
                                    @if($totalPorCategoria->count() > 0)
                                    <div class="mt-4">
                                        @foreach($totalPorCategoria as $categoria)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="text-muted">
                                                    {{ $categoria->categoria ?? 'Sem Categoria' }}
                                                    <span class="badge bg-primary ms-2">{{ $categoria->total }}</span>
                                                </span>
                                                @if($totalEquipamentos > 0)
                                                <span class="text-muted">
                                                    {{ round(($categoria->total / $totalEquipamentos) * 100, 1) }}%
                                                </span>
                                                @endif
                                            </div>
                                            @if($totalEquipamentos > 0)
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-primary rounded-pill"
                                                    style="width: {{ ($categoria->total / $totalEquipamentos) * 100 }}%">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Nenhuma categoria cadastrada.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Status de Placa -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #30a300;">
                                        <i class="fas fa-car me-2"></i>Status de Placa
                                    </h5>
                                    @if($totalEquipamentos > 0)
                                    <div class="row mt-4">
                                        <div class="col-md-6 text-center">
                                            <div class="p-4 border rounded bg-success bg-opacity-10 mb-3">
                                                <h2 class="text-success">{{ $equipamentosComPlaca }}</h2>
                                                <p class="mb-0">Com Placa</p>
                                                @if($totalEquipamentos > 0)
                                                <small class="text-muted">
                                                    {{ round(($equipamentosComPlaca / $totalEquipamentos) * 100, 1) }}%
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <div class="p-4 border rounded bg-warning bg-opacity-10 mb-3">
                                                <h2 class="text-warning">{{ $equipamentosSemPlaca }}</h2>
                                                <p class="mb-0">Sem Placa</p>
                                                @if($totalEquipamentos > 0)
                                                <small class="text-muted">
                                                    {{ round(($equipamentosSemPlaca / $totalEquipamentos) * 100, 1) }}%
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Com Placa</span>
                                            <span>{{ $equipamentosComPlaca }}</span>
                                        </div>
                                        <div class="progress mb-3" style="height: 10px;">
                                            <div class="progress-bar bg-success rounded-pill"
                                                style="width: {{ ($equipamentosComPlaca / $totalEquipamentos) * 100 }}%">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Sem Placa</span>
                                            <span>{{ $equipamentosSemPlaca }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-warning rounded-pill"
                                                style="width: {{ ($equipamentosSemPlaca / $totalEquipamentos) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-warning mt-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Nenhum equipamento ativo cadastrado.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Últimos Equipamentos Cadastrados -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0" style="color: #30a300;">
                                            <i class="fas fa-history me-2"></i>Últimos Equipamentos Cadastrados
                                        </h5>
                                        <a href="{{ route('equipamentos.index') }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fas fa-list"></i> Ver todos
                                        </a>
                                    </div>

                                    @if($ultimosCadastrados->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="60">#</th>
                                                    <th>Equipamento</th>
                                                    <th>Categoria</th>
                                                    <th>Placa</th>
                                                    <th>Abastecimentos</th>
                                                    <th>Cadastrado em</th>
                                                    <th width="120">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ultimosCadastrados as $equipamento)
                                                <tr>
                                                    <td>
                                                        <strong>#{{ $equipamento->id }}</strong>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $equipamento->nome ?? $equipamento->modelo ?? 'N/A'
                                                            }}</strong>
                                                        @if($equipamento->modelo)
                                                        <br><small class="text-muted">{{ $equipamento->modelo }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $equipamento->categoria ??
                                                            'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        @if($equipamento->placa)
                                                        <span class="badge badge-secondary">{{ $equipamento->placa
                                                            }}</span>
                                                        @else
                                                        <span class="badge badge-light">Sem placa</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            {{ $equipamento->abastecimentos->count() ?? 0 }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $equipamento->created_at->format('d/m/Y') }}
                                                        <br>
                                                        <small class="text-muted">{{
                                                            $equipamento->created_at->format('H:i') }}</small>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('equipamentos.show', $equipamento->id) }}"
                                                            class="btn btn-sm btn-info rounded-pill" title="Visualizar">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('equipamentos.edit', $equipamento->id) }}"
                                                            class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Nenhum equipamento cadastrado ainda.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3" style="color: #30a300;">
                                        <i class="fas fa-bolt me-2"></i>Ações Rápidas
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('equipamentos.create') }}" class="text-decoration-none">
                                                <div class="card border-primary text-primary rounded-pill hover-card">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                                        <h6 class="mb-0">Novo Equipamento</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('equipamentos.index') }}" class="text-decoration-none">
                                                <div class="card border-success text-success rounded-pill hover-card">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-list fa-2x mb-2"></i>
                                                        <h6 class="mb-0">Lista Completa</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <button type="button" class="btn btn-link text-decoration-none w-100 p-0"
                                                onclick="exportarRelatorio()">
                                                <div class="card border-warning text-warning rounded-pill hover-card">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-file-excel fa-2x mb-2"></i>
                                                        <h6 class="mb-0">Exportar Relatório</h6>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('equipamentos.index') }}?placa=0"
                                                class="text-decoration-none">
                                                <div class="card border-danger text-danger rounded-pill hover-card">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-filter fa-2x mb-2"></i>
                                                        <h6 class="mb-0">Equip. sem Placa</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer do Dashboard -->
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Dashboard atualizado em tempo real |
                                        Última atualização: {{ now()->format('d/m/Y H:i') }} |
                                        {{ $totalEquipamentos }} equipamentos ativos
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- timeline-group -->
            </div><!-- card -->
        </div><!-- col-lg-12 -->
    </div><!-- row -->
</div><!-- container-fluid -->

<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .progress-bar {
        border-radius: 20px;
    }

    .card-title {
        border-bottom: 2px solid #30a300;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.8em;
    }
</style>

<script>
    function exportarRelatorio() {
        alert('Funcionalidade de exportação em desenvolvimento.');
        // Implementar exportação para Excel/PDF aqui
    }
</script>
@endsection