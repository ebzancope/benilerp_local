@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12 "
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fas fa-users"></i> Gerenciamento de Colaboradores</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('colaboradores.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Novo Colaborador
                                    </a>
                                </div>
                            </div>

                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col">
                                    <a href="{{ route('colaboradores.index') }}" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Total Colaboradores</h6>
                                                <h5>{{ $totalColaboradores }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('colaboradores.index') }}?status=ativo"
                                        class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Ativos</h6>
                                                <h5>{{ $totalAtivos }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('colaboradores.index') }}?status=inativo"
                                        class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Inativos</h6>
                                                <h5>{{ $totalInativos }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('colaboradores.index') }}?mes_admissao={{ date('m') }}"
                                        class="text-decoration-none">
                                        <div class="card bg-info text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Admitidos Este Mês</h6>
                                                <h5>{{ $totalAdmitidosMes }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <style>
                                    .hover-card:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('colaboradores.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Status</label>
                                        <select name="status" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            <option value="ativo" {{ request('status')=='ativo' ? 'selected' : '' }}>
                                                Ativos</option>
                                            <option value="inativo" {{ request('status')=='inativo' ? 'selected' : ''
                                                }}>Inativos</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cargo</label>
                                        <select name="cargo" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach ($cargos as $cargo)
                                            @if ($cargo)
                                            <option value="{{ $cargo }}" {{ request('cargo')==$cargo ? 'selected' : ''
                                                }}>
                                                {{ $cargo }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Setor</label>
                                        <select name="setor" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach ($setores as $setor)
                                            @if ($setor)
                                            <option value="{{ $setor }}" {{ request('setor')==$setor ? 'selected' : ''
                                                }}>
                                                {{ $setor }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Empresa</label>
                                        <select name="empresa" class="form-select rounded-pill">
                                            <option value="">Todas</option>
                                            @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id }}" {{ request('empresa')==$empresa->id ?
                                                'selected' : '' }}>
                                                {{ $empresa->nome }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Categoria</label>
                                        <select name="categoria" class="form-select rounded-pill">
                                            <option value="">Todas</option>
                                            @foreach ($categorias as $categoria)
                                            @if ($categoria)
                                            <option value="{{ $categoria }}" {{ request('categoria')==$categoria
                                                ? 'selected' : '' }}>
                                                {{ $categoria }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('colaboradores.index') }}"
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
                            <form action="{{ route('colaboradores.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Nome</label>
                                        <div class="search-box">
                                            <input type="text" class="form-control rounded-pill" name="nome"
                                                placeholder="Nome do colaborador" value="{{ request('nome') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>CPF</label>
                                        <input type="text" class="form-control rounded-pill" name="cpf"
                                            placeholder="CPF" value="{{ request('cpf') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Admissão Início</label>
                                        <input type="date" class="form-control rounded-pill" name="admissao_inicio"
                                            value="{{ request('admissao_inicio') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Admissão Fim</label>
                                        <input type="date" class="form-control rounded-pill" name="admissao_fim"
                                            value="{{ request('admissao_fim') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-success rounded-pill btn-block" type="submit">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabela de Colaboradores -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cargo</th>
                                            <th>Empresa</th>
                                            <th>Admissão</th>
                                            <th>Telefone</th>
                                            <th>Salário</th>
                                            <th>Status</th>
                                            <th width="150">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($colaboradores as $colaborador)
                                        <tr>
                                            <td>
                                                <strong>{{ $colaborador->nome }}</strong>
                                                @if ($colaborador->apelido)
                                                <br><small class="text-muted">{{ $colaborador->apelido }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $colaborador->cargo }}</span>
                                                @if ($colaborador->setor)
                                                <br><small>{{ $colaborador->setor }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $colaborador->empresaInfo->nome ?? 'N/A' }}</td>
                                            <td>{{ $colaborador->admissao_formatada }}</td>
                                            <td>
                                                @if ($colaborador->telefone)
                                                {{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3',
                                                $colaborador->telefone) }}
                                                @else
                                                <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($colaborador->salario)
                                                <strong>R$ {{ number_format($colaborador->salario, 2, ',', '.')
                                                    }}</strong>
                                                @else
                                                <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $colaborador->status_color }}">
                                                    {{ $colaborador->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('colaboradores.show', $colaborador->id) }}"
                                                    class="btn btn-sm btn-info rounded-pill" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('colaboradores.edit', $colaborador->id) }}"
                                                    class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('colaboradores.destroy', $colaborador->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                        title="Excluir"
                                                        onclick="return confirm('Tem certeza que deseja excluir este colaborador?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $colaboradores->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div><!-- timeline- -->
            </div><!-- group -->
        </div><!-- card -->
    </div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Máscara para CPF
        const cpfInput = document.querySelector('input[name="cpf"]');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 3 && value.length <= 6) {
                    value = value.replace(/(\d{3})(\d+)/, '$1.$2');
                } else if (value.length > 6 && value.length <= 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
                } else if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, '$1.$2.$3-$4');
                }
                e.target.value = value;
            });
        }

        // Máscara para telefone
        const telefoneInputs = document.querySelectorAll('input[name="telefone"], input[name="fone"]');
        telefoneInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
                } else if (value.length > 10) {
                    value = value.replace(/(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
                }
                e.target.value = value;
            });
        });

        // Máscara para CEP
        const cepInput = document.querySelector('input[name="cep"]');
        if (cepInput) {
            cepInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 5) {
                    value = value.replace(/(\d{5})(\d+)/, '$1-$2');
                }
                e.target.value = value;
            });
        }
    });
</script>
@endsection