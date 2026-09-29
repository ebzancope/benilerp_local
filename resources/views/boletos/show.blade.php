{{-- resources/views/boletos/create.blade.php --}}
@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="section-title fst-italic " style="color: #30a300; "> <i class="fa-solid fa-barcode"></i>
                    Detalhes do Boleto ID: {{ $boleto->id }}</label>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('boletos.edit', $boleto->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('boletos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar para Lista
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <!-- Card Principal do Boleto -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-barcode"></i> Informações do Boleto</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Nº Documento:</th>
                                        <td>
                                            <strong class="h5">{{ $boleto->numdoc }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pagador:</th>
                                        <td>
                                            <strong>{{ $boleto->pagadorInfo->nome ?? 'N/A' }}</strong>
                                            @if ($boleto->pagadorInfo)
                                                <br>
                                                <small class="text-muted">
                                                    CNPJ/CPF: {{ $boleto->pagadorInfo->cnpj_cpf ?? 'Não informado' }}
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Beneficiário:</th>
                                        <td>
                                            <strong>{{ $boleto->beneficiarioInfo->nome ?? 'N/A' }}</strong>
                                            @if ($boleto->beneficiarioInfo)
                                                <br>
                                                <small class="text-muted">
                                                    CNPJ/CPF: {{ $boleto->beneficiarioInfo->cnpj_cpf ?? 'Não informado' }}
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Vencimento:</th>
                                        <td>
                                            <span
                                                class="h5 {{ $boleto->status == 'vencido' ? 'text-danger' : 'text-dark' }}">
                                                {{ $boleto->vencimento->format('d/m/Y') }}
                                            </span>
                                            @if ($boleto->dias_vencimento < 0 && !$boleto->pago)
                                                <br>
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Vencido há {{ number_format($boleto->dias_vencimento, 0) }} dias
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Valor:</th>
                                        <td>
                                            <span class="h4 text-success font-weight-bold">
                                                R$ {{ number_format($boleto->valor, 2, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge badge-{{ $boleto->status_color }} badge-lg p-2">
                                                @if ($boleto->pago)
                                                    <i class="fas fa-check-circle"></i> PAGO
                                                @elseif($boleto->status == 'vencido')
                                                    <i class="fas fa-exclamation-circle"></i> VENCIDO
                                                @elseif($boleto->status == 'a_vencer')
                                                    <i class="fas fa-clock"></i> A VENCER
                                                @else
                                                    <i class="fas fa-hourglass-half"></i> EM ABERTO
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($boleto->descricao)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6><i class="fas fa-file-alt"></i> Descrição</h6>
                                    <div class="border rounded p-3 bg-light">
                                        {{ $boleto->descricao }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-bolt"></i> Ações Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($boleto->pago)
                                <div class="col-md-4">
                                    <form action="{{ route('boletos.marcar-pendente', $boleto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-block">
                                            <i class="fas fa-clock"></i> Marcar como Pendente
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <form action="{{ route('boletos.marcar-pago', $boleto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-check-circle"></i> Marcar como Pago
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <a href="{{ route('boletos.edit', $boleto->id) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> Editar Boleto
                                </a>
                            </div>

                            <div class="col-md-4">
                                <form action="{{ route('boletos.destroy', $boleto->id) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este boleto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i> Excluir Boleto
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Informações do Sistema -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informações do Sistema</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="50%">Registrado por:</th>
                                <td>{{ $boleto->usuario->name ?? 'Sistema' }}</td>
                            </tr>
                            <tr>
                                <th>Criado em:</th>
                                <td>{{ $boleto->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Atualizado em:</th>
                                <td>{{ $boleto->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if ($boleto->deleted_at)
                                <tr>
                                    <th>Status:</th>
                                    <td><span class="badge badge-danger">Excluído</span></td>
                                </tr>
                                <tr>
                                    <th>Excluído em:</th>
                                    <td>{{ $boleto->deleted_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <th>Status:</th>
                                    <td><span class="badge badge-success">Ativo</span></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Resumo Financeiro -->
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Resumo Financeiro</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @if ($boleto->pago)
                                <div class="text-success mb-2">
                                    <i class="fas fa-check-circle fa-3x"></i>
                                </div>
                                <h5 class="text-success">Boleto Quitado</h5>
                                <p class="text-muted">Valor pago: <strong>R$
                                        {{ number_format($boleto->valor, 2, ',', '.') }}</strong></p>
                            @elseif($boleto->status == 'vencido')
                                <div class="text-danger mb-2">
                                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                                </div>
                                <h5 class="text-danger">Boleto Vencido</h5>
                                <p class="text-muted">Valor em atraso: <strong>R$
                                        {{ number_format($boleto->valor, 2, ',', '.') }}</strong></p>
                            @else
                                <div class="text-warning mb-2">
                                    <i class="fas fa-clock fa-3x"></i>
                                </div>
                                <h5 class="text-warning">Boleto em Aberto</h5>
                                <p class="text-muted">Vencimento: {{ $boleto->vencimento->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Histórico (Pode ser expandido depois) -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-history"></i> Histórico</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <small>Criação</small>
                                <small class="text-muted">{{ $boleto->created_at->format('d/m H:i') }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <small>Última atualização</small>
                                <small class="text-muted">{{ $boleto->updated_at->format('d/m H:i') }}</small>
                            </li>
                            @if ($boleto->pago)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <small class="text-success">Pagamento confirmado</small>
                                    <small class="text-muted">{{ $boleto->updated_at->format('d/m H:i') }}</small>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    </style>
@endsection
