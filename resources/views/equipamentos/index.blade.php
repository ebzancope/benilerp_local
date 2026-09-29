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
                                    <h2><i class="fas fa-truck"></i> Gerenciamento de Equipamentos</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('equipamentos.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Novo Equipamento
                                    </a>
                                    <a href="{{ route('equipamentos.dashboard') }}" class="btn btn-info rounded-pill">
                                        <i class="fas fa-chart-bar"></i> Dashboard
                                    </a>
                                </div>
                            </div>

                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col">
                                    <a href="{{ route('equipamentos.index') }}" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Total Equipamentos</h6>
                                                <h5>{{ $totalEquipamentos }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('equipamentos.index') }}?placa=1" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Com Placa</h6>
                                                <h5>{{ $totalComPlaca }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('equipamentos.index') }}?placa=0" class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Sem Placa</h6>
                                                <h5>{{ $totalSemPlaca }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('equipamentos.index') }}" class="text-decoration-none">
                                        <div class="card bg-info text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Categorias</h6>
                                                <h5>{{ $categoriasCount }}</h5>
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
                            <form method="GET" action="{{ route('equipamentos.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Categoria</label>
                                        <select name="categoria" class="form-select rounded-pill">
                                            <option value="">Todas</option>
                                            @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria }}" {{ request('categoria')==$categoria
                                                ? 'selected' : '' }}>
                                                {{ $categoria }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Marca</label>
                                        <select name="marca" class="form-select rounded-pill">
                                            <option value="">Todas</option>
                                            @foreach ($marcas as $marca)
                                            <option value="{{ $marca }}" {{ request('marca')==$marca ? 'selected' : ''
                                                }}>
                                                {{ $marca }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Placa</label>
                                        <input type="text" name="placa" class="form-control rounded-pill"
                                            value="{{ request('placa') }}" placeholder="Placa">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Modelo</label>
                                        <input type="text" name="modelo" class="form-control rounded-pill"
                                            value="{{ request('modelo') }}" placeholder="Modelo">
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('equipamentos.index') }}"
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
                            <form action="{{ route('equipamentos.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Busca Rápida</label>
                                        <div class="search-box">
                                            <input type="text" class="form-control rounded-pill" name="codigo"
                                                placeholder="Código, Modelo..." value="{{ request('codigo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Status</label>
                                        <select name="status" class="form-control rounded-pill">
                                            <option value="">Todos</option>
                                            <option value="ativo" {{ request('status')=='ativo' ? 'selected' : '' }}>
                                                Ativo</option>
                                            <option value="inativo" {{ request('status')=='inativo' ? 'selected' : ''
                                                }}>Inativo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ano Mínimo</label>
                                        <input type="number" class="form-control rounded-pill" name="ano_min"
                                            placeholder="2000" value="{{ request('ano_min') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ano Máximo</label>
                                        <input type="number" class="form-control rounded-pill" name="ano_max"
                                            placeholder="2024" value="{{ request('ano_max') }}">
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

                    <!-- Tabela de Equipamentos -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="60">Foto</th>
                                            <th>Código</th>
                                            <th>Modelo/Marca</th>
                                            <th>Categoria</th>
                                            <th>Placa</th>
                                            <th>Ano</th>
                                            <th>Status</th>
                                            <th width="150">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipamentos as $equipamento)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('../storage/app/public/equipamentos/' . $equipamento->image) }}"
                                                    alt="{{ $equipamento->modelo }}" class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                            </td>
                                            <td>
                                                <strong>{{ $equipamento->codigo }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $equipamento->modelo }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $equipamento->marca }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $equipamento->categoria }}</span>
                                            </td>
                                            <td>
                                                @if ($equipamento->placa)
                                                <span class="badge badge-secondary">{{ $equipamento->placa }}</span>
                                                @else
                                                <span class="badge badge-light">Sem placa</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($equipamento->ano)
                                                <span class="badge badge-dark">{{ $equipamento->ano }}</span>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $equipamento->status == 'ativo' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($equipamento->status) }}
                                                </span>
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
                                                <form action="{{ route('equipamentos.destroy', $equipamento->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                        title="Excluir"
                                                        onclick="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $equipamentos->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div><!-- timeline- -->
            </div><!-- group -->
        </div><!-- card -->
    </div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>
@endsection