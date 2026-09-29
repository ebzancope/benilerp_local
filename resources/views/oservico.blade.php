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
                                    <h2><i class="fa-solid fa-file-invoice"></i> Gerenciamento de OS</h2>
                                    <p class="mb-0" style="color: #666; font-size: 0.9rem;">Próxima OS: {{ $totalnumos
                                        }}</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('cadoservico') }}" class="btn btn-success rounded-pill">
                                        <i class="fa-solid fa-circle-plus"></i> Nova OS
                                    </a>
                                </div>
                            </div>
                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col">
                                    <a href="{{ route('oservico') }}?status=aberta" class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>OS Abertas</h6>
                                                <h5>{{ $totalAbertas }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('oservico') }}?status=fechada" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>OS Fechadas</h6>
                                                <h5>{{ $totalFechadas }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">

                                    @if($totalFatPendentes > 0)
                                    <a href="{{ route('oservico') }}?status=pendente" class="text-decoration-none">
                                        <div class="card bg-danger text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Faturas Pendentes</h6>
                                                <h5>{{ $totalFatPendentes }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                                <div class="col">
                                    &nbsp;
                                </div>
                                <div class="col">
                                    &nbsp;
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
                </div>
                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('oservico') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Status</label>
                                    <select name="status" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        <option value="aberta" {{ request('status')=='aberta' ? 'selected' : '' }}>
                                            Aberta
                                        </option>
                                        <option value="fechada" {{ request('status')=='fechada' ? 'selected' : '' }}>
                                            Fechada
                                        </option>
                                        <option value="execucao" {{ request('status')=='execucao' ? 'selected' : '' }}>
                                            Em Execução
                                        </option>
                                        <option value="pendente" {{ request('status')=='pendente' ? 'selected' : '' }}>
                                            Pendente
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Cliente</label>
                                    <select name="cliente" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        @foreach ($cliefornes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ request('cliente')==$cliente->id ?
                                            'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Data Início</label>
                                    <input type="date" name="data_inicio" class="form-control rounded-pill"
                                        value="{{ old('data_inicio', now()->firstOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Data Fim</label>
                                    <input type="date" name="data_fim" class="form-control rounded-pill"
                                        value="{{ request('data_fim') }}">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    <a href="{{ route('oservico') }}"
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
                        <form action="{{ route('oservico') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Busca Rápida</label>
                                    <div class="search-box">
                                        <input type="text" class="form-control rounded-pill" name="text_nome"
                                            id="text_nome" placeholder="Cliente ou nº OS"
                                            value="{{ request('text_nome') }}">
                                    </div>
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
                @if (session('mensagem'))
                <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
                    {{ session('mensagem') }}
                </div>
                @endif
                <!-- Tabela de OS -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nº OS / Cliente</th>
                                        <th>Data</th>
                                        <th>Descrição</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($oservico as $oservicos)
                                    <tr>
                                        <td>
                                            <strong>OS Nº {{ $oservicos->idnumos }}</strong>
                                            {{ $oservicos->nomeclie }}
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($oservicos->dataoscli)) }}</td>
                                        <td>{{ $oservicos->numos_descricao }}</td>
                                        <td>
                                            @if ($oservicos->estatusos != '1')
                                            <span class="badge badge-warning">Aberta</span>
                                            @else
                                            <span class="badge badge-success">Fechada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('fatura', ['id' => Crypt::encrypt($oservicos->idnumos)]) }}"
                                                class="btn btn-sm btn-info rounded-pill" title="Visualizar Faturas">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </a>

                                            <a href="{{ route('editoservico', ['id' => Crypt::encrypt($oservicos->idnumos)]) }}"
                                                class="btn btn-sm btn-warning rounded-pill" title="Editar OS">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            @if ($oservicos->estatusos != '0')
                                            <form
                                                action="{{ route('deleteoservico', ['id' => Crypt::encrypt($oservicos->idnumos)]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                    title="Excluir OS"
                                                    onclick="return confirm('Tem certeza que deseja excluir esta OS?')">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhuma ordem de serviço encontrada.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        {{ $oservico->appends(request()->query())->links() }}

                        <!-- Resumo -->
                        @if(count($oservico) > 0)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="alert alert-light">
                                    <small>
                                        <strong>Total encontrado:</strong> {{ $oservico->total() }} OS(s) |
                                        <strong>Página:</strong> {{ $oservico->currentPage() }} de {{
                                        $oservico->lastPage() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div><!-- timeline- -->
        </div><!-- group -->
    </div><!-- card -->
</div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>
@endsection