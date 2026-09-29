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
                                    <h2><i class="fas fa-user-cog"></i> Gerenciamento de Usuários</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('users.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Novo Usuário
                                    </a>
                                    <a href="{{ route('users.access-report') }}" class="btn btn-info rounded-pill ml-2">
                                        <i class="fas fa-chart-line"></i> Relatório de Acessos
                                    </a>
                                </div>
                            </div>

                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col">
                                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Total Usuários</h6>
                                                <h5>{{ $totalUsuarios }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('users.index') }}?approved=1" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Aprovados</h6>
                                                <h5>{{ $totalAprovados }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('users.index') }}?approved=0" class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Não Aprovados</h6>
                                                <h5>{{ $totalNaoAprovados }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('users.index') }}?access_level=2" class="text-decoration-none">
                                        <div class="card bg-info text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Administradores</h6>
                                                <h5>{{ $totalAdministradores }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('users.index') }}?access_level=3" class="text-decoration-none">
                                        <div class="card bg-danger text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Super Admin</h6>
                                                <h5>{{ $totalSuperAdmin }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('users.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Nível de Acesso</label>
                                        <select name="access_level" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach ($accessLevels as $key => $level)
                                            <option value="{{ $key }}" {{ request('access_level')==$key ? 'selected'
                                                : '' }}>
                                                {{ $level }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Status Aprovação</label>
                                        <select name="approved" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            <option value="1" {{ request('approved')=='1' ? 'selected' : '' }}>Aprovados
                                            </option>
                                            <option value="0" {{ request('approved')=='0' ? 'selected' : '' }}>Não
                                                Aprovados</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Ordenar por</label>
                                        <select name="sort" class="form-select rounded-pill">
                                            <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>
                                                Mais Recentes</option>
                                            <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>
                                                Mais Antigos</option>
                                            <option value="name" {{ request('sort')=='name' ? 'selected' : '' }}>Nome
                                                (A-Z)</option>
                                            <option value="last_login" {{ request('sort')=='last_login' ? 'selected'
                                                : '' }}>Último Acesso</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('users.index') }}"
                                            class="btn btn-secondary btn-block rounded-pill mt-1">
                                            <i class="fas fa-times"></i> Limpar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Busca Rápida -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('users.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Nome ou Email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded-pill-left" name="search"
                                                placeholder="Buscar por nome ou email" value="{{ request('search') }}">
                                            <button class="btn btn-success rounded-pill-right" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Data Cadastro Início</label>
                                        <input type="date" class="form-control rounded-pill" name="date_from"
                                            value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Data Cadastro Fim</label>
                                        <input type="date" class="form-control rounded-pill" name="date_to"
                                            value="{{ request('date_to') }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabela de Usuários -->
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Nível de Acesso</th>
                                            <th>Status</th>
                                            <th>Último Login</th>
                                            <th>Acessos</th>
                                            <th width="200">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                @if($user->photo)
                                                <img src="{{ asset('../storage/app/public/' . $user->photo) }}"
                                                    alt="{{ $user->name }}" class="rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px; background-color: #007bff; color: white;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                                <br>
                                                <small class="text-muted">Cadastrado: {{
                                                    $user->created_at->format('d/m/Y') }}</small>
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
                                                @if($user->approved)
                                                <span class="badge badge-success">Aprovado</span>
                                                @else
                                                <span class="badge badge-warning">Aguardando Aprovação</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->last_login)
                                                {{ \Carbon\Carbon::parse($user->last_login)->format('d/m/Y H:i') }}
                                                @else
                                                <span class="text-muted">Nunca acessou</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">{{ $user->login_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-warning rounded-pill mr-1" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @if(!$user->approved)
                                                    <form action="{{ route('users.toggle-approval', $user->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success rounded-pill mr-1"
                                                            title="Aprovar Usuário"
                                                            onclick="return confirm('Deseja aprovar este usuário?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                            title="Excluir"
                                                            onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($users->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhum usuário encontrado</h5>
                                <p class="text-muted">Tente ajustar seus filtros de busca</p>
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
    .hover-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .rounded-pill-left {
        border-radius: 50rem 0 0 50rem !important;
    }

    .rounded-pill-right {
        border-radius: 0 50rem 50rem 0 !important;
    }

    .avatar-placeholder {
        font-weight: bold;
        font-size: 16px;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmação para exclusão
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Tem certeza que deseja excluir este usuário?')) {
                    e.preventDefault();
                }
            });
        });

        // Filtro automático ao mudar selects
        const filterSelects = document.querySelectorAll('select[name="access_level"], select[name="approved"], select[name="sort"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
</script>
@endsection