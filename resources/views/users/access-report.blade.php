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
                                    <h2><i class="fas fa-chart-line"></i> Relatório de Acessos</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('users.index') }}" class="btn btn-primary rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar para Usuários
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros do Relatório -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('users.access-report') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Data Início</label>
                                        <input type="date" class="form-control rounded-pill" name="date_from"
                                            value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Data Fim</label>
                                        <input type="date" class="form-control rounded-pill" name="date_to"
                                            value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Nível de Acesso</label>
                                        <select name="access_level" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            <option value="1" {{ request('access_level')=='1' ? 'selected' : '' }}>
                                                Usuário</option>
                                            <option value="2" {{ request('access_level')=='2' ? 'selected' : '' }}>
                                                Administrador</option>
                                            <option value="3" {{ request('access_level')=='3' ? 'selected' : '' }}>Super
                                                Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('users.access-report') }}"
                                            class="btn btn-secondary btn-block rounded-pill mt-1">
                                            <i class="fas fa-times"></i> Limpar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6>Total de Acessos</h6>
                                    <h3>{{ $totalAcessos }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6>Usuários Ativos</h6>
                                    <h3>{{ $usuariosAtivos }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h6>Média de Acessos/Usuário</h6>
                                    <h3>{{ round($mediaAcessos, 1) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6>Último Acesso</h6>
                                    <h6>{{ $ultimoAcesso ? \Carbon\Carbon::parse($ultimoAcesso)->format('d/m/Y H:i') :
                                        'N/A' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Acessos -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Usuário</th>
                                            <th>Email</th>
                                            <th>Nível de Acesso</th>
                                            <th>Último Login</th>
                                            <th>Total de Acessos</th>
                                            <th>Status</th>
                                            <th>Primeiro Acesso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($user->photo)
                                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                                        alt="{{ $user->name }}" class="rounded-circle mr-2"
                                                        style="width: 35px; height: 35px; object-fit: cover;">
                                                    @else
                                                    <div class="avatar-placeholder rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                                        style="width: 35px; height: 35px; background-color: #007bff; color: white; font-size: 14px;">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    @endif
                                                    <strong>{{ $user->name }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->access_level == 3)
                                                <span class="badge badge-danger">Super Admin</span>
                                                @elseif($user->access_level == 2)
                                                <span class="badge badge-warning">Administrador</span>
                                                @else
                                                <span class="badge badge-info">Usuário</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->last_login)
                                                {{ \Carbon\Carbon::parse($user->last_login)->format('d/m/Y H:i') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }}
                                                </small>
                                                @else
                                                <span class="text-muted">Nunca acessou</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-pill badge-secondary" style="font-size: 14px;">
                                                    {{ $user->login_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($user->last_login && $user->last_login->diffInDays(now()) <= 7)
                                                    <span class="badge badge-success">Ativo</span>
                                                    @elseif($user->last_login)
                                                    <span class="badge badge-warning">Inativo</span>
                                                    @else
                                                    <span class="badge badge-danger">Nunca Acessou</span>
                                                    @endif
                                            </td>
                                            <td>
                                                @if($user->created_at)
                                                {{ $user->created_at->format('d/m/Y') }}
                                                @else
                                                <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($users->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhum dado de acesso encontrado</h5>
                                <p class="text-muted">Tente ajustar seus filtros</p>
                            </div>
                            @endif

                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div><!-- timeline-group -->
            </div><!-- card -->
        </div><!-- col-lg-12 -->
    </div><!-- row -->
</div><!-- container-fluid -->

<style>
    .avatar-placeholder {
        font-weight: bold;
    }

    .table td {
        vertical-align: middle;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Exportar relatório para Excel
        const exportBtn = document.getElementById('exportExcel');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                // Implementar exportação para Excel
                alert('Funcionalidade de exportação em desenvolvimento');
            });
        }
    });
</script>
@endsection