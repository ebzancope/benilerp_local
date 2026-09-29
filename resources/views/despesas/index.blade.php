@extends('layouts.layout')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
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
                                    <h2><i class="fas fa-money-bill-alt"></i> Gerenciamento de Despesas</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('despesas.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Nova Despesa
                                    </a>
                                    {{-- Botão de impressão com filtros --}}
                                    <button type="button" class="btn btn-info rounded-pill" onclick="imprimirFiltrado()"
                                        title="Imprimir Relatório Filtrado">
                                        <i class="fas fa-print"></i> Imprimir Relatório
                                    </button>
                                </div>
                            </div>
                            @if(request()->query())
                            {{-- mostrar cards filtrados --}}
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="card bg-primary text-white rounded-pill hover-card">
                                        <div class="card-body text-center">
                                            <h6>Total Geral (filtrado)</h6>
                                            <h5>R$ {{ number_format($totalFiltrado, 2, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card bg-info text-white rounded-pill hover-card">
                                        <div class="card-body text-center">
                                            <h6>Este Mês (filtrado)</h6>
                                            <h5>R$ {{ number_format($totalMesFiltrado, 2, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- <div class="card bg-warning text-white rounded-pill hover-card">
                                        <div class="card-body text-center">
                                            <h6>A Pagar </h6>
                                            <h5>R$ {{ number_format($totalPendenteFiltrado, 2, ',', '.') }}</h5>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            @else
                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col">
                                    <a href="{{ route('despesas.index') }}" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Total Geral ano vigente</h6>
                                                <h5>R$ {{ number_format($totalDespesas, 2, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('despesas.index') }}?mes={{ date('m') }}&ano={{ date('Y') }}"
                                        class="text-decoration-none">
                                        <div class="card bg-info text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Este Mês</h6>
                                                <h5>R$ {{ number_format($totalMes, 2, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <!-- <a href="{{ route('despesas.index') }}" class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>A Pagar</h6>
                                                <h5>R$ {{ number_format($totalPendente, 2, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </a>-->
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
                            {{-- mostrar cards gerais --}}
                            @endif
                        </div>
                    </div>
                    <!-- Filtros -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('despesas.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Tipo de Conta</label>
                                        <select name="tipoconta" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach ($tiposContas as $key => $value)
                                            <option value="{{ $key }}" {{ request('tipoconta')==$key ? 'selected' : ''
                                                }}>
                                                {{ $key }} - {{ substr($value, 0, 20) }}...
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Equipamento</label>
                                        <select name="equipamento" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach ($equipamentos as $equipamento)
                                            <option value="{{ $equipamento->id }}" {{
                                                request('equipamento')==$equipamento->id ? 'selected' : '' }}>
                                                {{ $equipamento->codigo }} - {{ $equipamento->modelo }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Fornecedor</label>
                                        <select name="fornecedor" class="form-select rounded-pill">
                                            <option value="">Todos</option>
                                            @foreach ($fornecedores as $fornecedor)
                                            <option value="{{ $fornecedor->id }}" {{
                                                request('fornecedor')==$fornecedor->id ? 'selected' : '' }}>
                                                {{ substr($fornecedor->nome, 0, 20) }}...
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Data Início</label>
                                        <input type="date" name="data_inicio" class="form-control rounded-pill"
                                            value="{{ request('data_inicio') }}">
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
                                        <a href="{{ route('despesas.index') }}"
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
                            <form action="{{ route('despesas.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Busca Rápida</label>
                                        <div class="search-box">
                                            <input type="text" class="form-control rounded-pill" name="busca"
                                                id="busca" placeholder="Numero da Nota, Descrição..."
                                                value="{{ request('busca') }}">
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
                    <!-- Tabela de Despesas -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Competência</th>
                                            <th>Tipo Conta</th>
                                            <th>Fornecedor</th>
                                            <th>Valor</th>
                                            <th>Centro Custo</th>
                                            <th>Documento</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($despesas as $despesa)
                                        <tr>
                                            <td>{{ $despesa->competencia ? $despesa->competencia->format('d/m/Y') :
                                                'N/A' }}</td>
                                            <td>{{ $tiposContas[$despesa->tipoconta] ?? $despesa->tipoconta }}</td>
                                            <td>{{ $despesa->clieforne->nome ?? 'N/A' }}</td>
                                            <td><strong>R$ {{ number_format((float)$despesa->valortotal, 2, ',',
                                                    '.')
                                                    }}</strong></td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    {{ $centrosCustos[$despesa->centrocustos] ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($despesa->tipodocumento)
                                                <span class="badge badge-info">
                                                    {{ $tiposDocumentos[$despesa->tipodocumento] ??
                                                    $despesa->tipodocumento }}
                                                </span>
                                                @endif
                                                @if($despesa->notafiscal)
                                                <br><small>{{ $despesa->notafiscal }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('despesas.show', $despesa->id) }}"
                                                    class="btn btn-sm btn-info rounded-pill" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('despesas.edit', $despesa->id) }}"
                                                    class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('despesas.destroy', $despesa->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                        title="Excluir"
                                                        onclick="return confirm('Tem certeza que deseja excluir esta despesa?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $despesas->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div><!-- timeline- -->
            </div><!-- group -->
        </div><!-- card -->
    </div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>
<script>
    function imprimirFiltrado() {
    // Captura os parâmetros de filtro atuais da URL
    const urlParams = new URLSearchParams(window.location.search);

    // Monta a URL de impressão com os mesmos filtros
    const printUrl = "{{ route('despesas.imprimir-filtrado') }}?" + urlParams.toString();

    // Abre em nova janela
    window.open(printUrl, '_blank');
}
</script>
@endsection
