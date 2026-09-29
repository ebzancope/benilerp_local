{{-- resources/views/abastecimentos/show.blade.php --}}
@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-eye"></i> Detalhes do Abastecimento</h2>
                <p class="text-muted">ID: {{ $abastecimento->id }}</p>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('abastecimentos.edit', $abastecimento->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('abastecimentos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- Informações Principais -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informações do Abastecimento</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Data/Hora:</th>
                                        <td><strong>{{ \Carbon\Carbon::parse($abastecimento->datacad)->format('d/m/Y H:i') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Veículo:</th>
                                        <td>
                                            <strong>{{ $abastecimento->veiculoInfo->codigo ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $abastecimento->veiculoInfo->modelo ?? '' }} -
                                                {{ $abastecimento->veiculoInfo->placa ?? 'Sem placa' }}
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Fornecedor:</th>
                                        <td>{{ $abastecimento->fornecedorInfo->nome ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Combustível:</th>
                                        <td>
                                            <span class="badge badge-info">{{ $abastecimento->tipo_combustivel }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tipo:</th>
                                        <td>{{ $abastecimento->tipo_abastecimento }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Litros:</th>
                                        <td><strong>{{ number_format($abastecimento->litros, 2, ',', '.') }} L</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Preço/L:</th>
                                        <td>R$ {{ number_format($abastecimento->qtda, 3, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Desconto:</th>
                                        <td>R$ {{ number_format($abastecimento->desconto, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Valor Total:</th>
                                        <td>
                                            <strong class="text-success h5">
                                                R$ {{ number_format($abastecimento->totala, 2, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Valor por Litro:</th>
                                        <td>R$ {{ number_format($abastecimento->valor_por_litro, 3, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Quilometragem:</th>
                                        <td>
                                            @if ($abastecimento->km)
                                                {{ number_format($abastecimento->km, 0, ',', '.') }} km
                                            @else
                                                <span class="text-muted">Não informado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Horímetro:</th>
                                        <td>
                                            @if ($abastecimento->horimini)
                                                {{ number_format($abastecimento->horimini, 1, ',', '.') }} h
                                            @else
                                                <span class="text-muted">Não informado</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Colaborador:</th>
                                        <td>{{ $abastecimento->colaboradorInfo->nome ?? 'Não informado' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Requisição:</th>
                                        <td>{{ $abastecimento->requisicao ?? 'Não informado' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($abastecimento->descricao)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6><i class="fas fa-file-alt"></i> Observações</h6>
                                    <div class="border rounded p-3 bg-light">
                                        {{ $abastecimento->descricao }}
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                <td>{{ $abastecimento->usuario->name ?? 'Sistema' }}</td>
                            </tr>
                            <tr>
                                <th>Criado em:</th>
                                <td>{{ $abastecimento->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Atualizado em:</th>
                                <td>{{ $abastecimento->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if ($abastecimento->deleted_at)
                                <tr>
                                    <th>Status:</th>
                                    <td><span class="badge badge-danger">Excluído</span></td>
                                </tr>
                                <tr>
                                    <th>Excluído em:</th>
                                    <td>{{ $abastecimento->deleted_at->format('d/m/Y H:i') }}</td>
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

                <!-- Ações Rápidas -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-bolt"></i> Ações Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('abastecimentos.edit', $abastecimento->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar Abastecimento
                            </a>
                            <a href="{{ route('abastecimentos.create') }}?veiculo={{ $abastecimento->veiculo }}"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Novo para este Veículo
                            </a>
                            <form action="{{ route('abastecimentos.destroy', $abastecimento->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este abastecimento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Excluir Abastecimento
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
