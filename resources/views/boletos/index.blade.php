{{-- resources/views/boletos/index.blade.php --}}
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
                                    <h2><i class="fas fa-barcode"></i> Gerenciamento de Boletos</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('boletos.create') }}" class="btn btn-success  rounded-pill">
                                        <i class="fas fa-plus"></i> Novo Boleto
                                    </a>
                                </div>
                            </div>
                            <hr class="my-2">
                            @if (session('message'))
                            <div class="alert alert-warning mt-3 fw-bold"
                                style="border-radius: 15px;text-align: center; ">
                                {{ session('message') }}
                            </div>
                            @endif
                            @if (session('success'))
                            <div class="alert alert-warning mt-3 fw-bold"
                                style="border-radius: 15px;text-align: center; ">
                                {{ session('success') }}
                            </div>
                            @endif
                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <a href="{{ route('boletos.index') }}?status=" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill ">
                                            <div class="card-body text-center ">
                                                <h5>Total em Aberto</h5>
                                                <h3>R$ {{ number_format($totalGeralAberto, 2, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('boletos.index') }}?status=pagos" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h5>Total Pago este Mês</h5>
                                                <h3>R$ {{ number_format($totalGeralPago, 2, ',', '.') }}

                                                </h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('boletos.index') }}?status=vencidos" class="text-decoration-none">
                                        <div class="card bg-danger text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h5>Vencidos</h5>
                                                <h3>{{ $totalVencidos }}
                                                </h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('boletos.index') }}?status=a_vencer" class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h5>A Vencer (7 dias)</h5>
                                                <h3>{{ $totalAVencer }}
                                                </h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- Filtros -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('boletos.index') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Status</label>
                                                <select name="status" class="form-control rounded-pill">
                                                    <option value="">Todos</option>
                                                    <option value="pagos" {{ request('status')=='pagos' ? 'selected'
                                                        : '' }}>Pagos
                                                    </option>
                                                    <option value="pendentes" {{ request('status')=='pendentes'
                                                        ? 'selected' : '' }}>
                                                        Pendentes
                                                    </option>
                                                    <option value="vencidos" {{ request('status')=='vencidos'
                                                        ? 'selected' : '' }}>
                                                        Vencidos
                                                    </option>
                                                    <option value="a_vencer" {{ request('status')=='a_vencer'
                                                        ? 'selected' : '' }}>A
                                                        Vencer
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Beneficiário</label>
                                                <select name="beneficiario" class="form-control rounded-pill">
                                                    <option value="">Todos</option>
                                                    @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}" {{
                                                        request('beneficiario')==$cliente->
                                                        id ? 'selected' : '' }}>
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
                                                    value="{{ old('data_fim', now()->endOfMonth()->format('Y-m-d')) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                                    <i class="fas fa-filter"></i> Filtrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Tabela de Boletos -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Documento</th>
                                                <th>Pagador</th>
                                                <th>Beneficiário</th>
                                                <th>Vencimento</th>
                                                <th>Valor</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($boletos as $boleto)
                                            <tr>
                                                <td>
                                                    <strong>{{ $boleto->numdoc }}</strong>
                                                    @if ($boleto->descricao)
                                                    <br><small class="text-muted">{{ Str::limit($boleto->descricao, 30)
                                                        }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $boleto->pagadorInfo->nome ?? 'N/A' }}</td>
                                                <td>{{ $boleto->beneficiarioInfo->nome ?? 'N/A' }}</td>
                                                <td>
                                                    {{ $boleto->vencimento->format('d/m/Y') }}

                                                </td>
                                                <td>R$ {{ number_format($boleto->valor, 2, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $boleto->status_color }}">
                                                        {{ $boleto->pago ? 'Pago' : ($boleto->status == 'vencido' ?
                                                        'Vencido' : ($boleto->status == 'a_vencer' ? 'A Vencer' : 'Em
                                                        Aberto')) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('boletos.show', $boleto->id) }}"
                                                        class="btn btn-sm btn-info rounded-pill" title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('boletos.edit', $boleto->id) }}"
                                                        class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @if ($boleto->pago)
                                                    <form action="{{ route('boletos.marcar-pendente', $boleto->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-secondary rounded-pill"
                                                            title="Marcar como Pendente">
                                                            <i class="fas fa-clock"></i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('boletos.marcar-pago', $boleto->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success rounded-pill"
                                                            title="Marcar como Pago">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $boletos->appends(['status' => request('status')])->links() }}

                            </div>
                        </div>
                    </div><!-- timeline- -->
                </div><!-- group -->
            </div><!-- card -->
        </div><!-- ol lg-->
    </div><!-- timeline-p5 -->
</div>
</div>
@endsection