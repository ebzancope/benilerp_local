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
                                    <h2><i class="fas fa-eye"></i> Detalhes do Equipamento</h2>
                                    <p class="text-muted">Código: {{ $equipamento->codigo }} | ID: {{ $equipamento->id
                                        }}</p>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('equipamentos.edit', $equipamento->id) }}"
                                            class="btn btn-warning rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="{{ route('equipamentos.index') }}"
                                            class="btn btn-secondary rounded-pill">
                                            <i class="fas fa-arrow-left"></i> Voltar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                <!-- Imagem e Status -->
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('../storage/app/public/equipamentos/' . $equipamento->image) }}"
                                                alt="{{ $equipamento->modelo }}" class="img-fluid rounded"
                                                style="max-height: 300px; object-fit: cover; border-radius: 10px;">
                                            <h4 class="mt-3">{{ $equipamento->modelo }}</h4>
                                            <p class="text-muted">{{ $equipamento->marca }}</p>
                                            <span
                                                class="badge badge-{{ $equipamento->status == 'ativo' ? 'success' : 'danger' }} badge-lg rounded-pill">
                                                {{ ucfirst($equipamento->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Estatísticas -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0"><i class="fas fa-chart-line"></i> Estatísticas</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td><strong>Abastecimentos:</strong></td>
                                                    <td class="text-right">{{ $totalAbastecimentos }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gasto com Combustível:</strong></td>
                                                    <td class="text-right text-success">R$
                                                        {{ number_format($totalGastoAbastecimento, 2, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Consumo Médio:</strong></td>
                                                    <td class="text-right">
                                                        @if ($consumoMedio)
                                                        <span class="text-info">{{ number_format($consumoMedio, 1, ',',
                                                            '.') }} km/L</span>
                                                        @else
                                                        <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Manutenções:</strong></td>
                                                    <td class="text-right">{{ $totalManutencoes }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gasto com Manutenção:</strong></td>
                                                    <td class="text-right text-warning">R$
                                                        {{ number_format($custoTotalManutencao, 2, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Principais -->
                                <div class="col-md-8">
                                    <div class="card mb-4">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informações do
                                                Equipamento</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%">Código:</th>
                                                            <td><strong>{{ $equipamento->codigo }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Modelo:</th>
                                                            <td>{{ $equipamento->modelo }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Marca:</th>
                                                            <td>{{ $equipamento->marca }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Categoria:</th>
                                                            <td><span class="badge badge-info">{{
                                                                    $equipamento->categoria }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cor:</th>
                                                            <td>
                                                                @if ($equipamento->cor)
                                                                {{ $equipamento->cor }}
                                                                @else
                                                                <span class="text-muted">Não informada</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ano:</th>
                                                            <td>{{ $equipamento->ano_modelo }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%">Placa:</th>
                                                            <td>
                                                                @if ($equipamento->placa)
                                                                <span class="badge badge-secondary">{{
                                                                    $equipamento->placa }}</span>
                                                                @else
                                                                <span class="text-muted">Sem placa</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>RENAVAM:</th>
                                                            <td>{{ $equipamento->renavam ?: 'Não informado' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Chassi:</th>
                                                            <td>{{ $equipamento->chassi ?: 'Não informado' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Motor:</th>
                                                            <td>{{ $equipamento->motor ?: 'Não informado' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Potência:</th>
                                                            <td>{{ $equipamento->potencia ?: 'Não informada' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Proprietário:</th>
                                                            <td>{{ $equipamento->prop ?: 'Não informado' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informações Financeiras e Seguro -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-header bg-success text-white">
                                                    <h6 class="mb-0"><i class="fas fa-dollar-sign"></i> Informações
                                                        Financeiras</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="60%">Valor do Equipamento:</th>
                                                            <td class="text-right">
                                                                @if ($equipamento->valor)
                                                                <strong class="text-success">{{
                                                                    $equipamento->valor_formatado }}</strong>
                                                                @else
                                                                <span class="text-muted">Não informado</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Alienação:</th>
                                                            <td class="text-right">
                                                                {{ $equipamento->alienacao ?: 'Não informada' }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-header bg-warning text-white">
                                                    <h6 class="mb-0"><i class="fas fa-shield-alt"></i> Seguro</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="60%">Apólice:</th>
                                                            <td class="text-right">
                                                                {{ $equipamento->apolice ?: 'Não informada' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Vencimento:</th>
                                                            <td class="text-right">
                                                                @if ($equipamento->venc)
                                                                @php
                                                                $vencimento = \Carbon\Carbon::parse($equipamento->venc);
                                                                $diasRestantes = now()->diffInDays($vencimento, false);
                                                                @endphp
                                                                <span
                                                                    class="{{ $diasRestantes < 30 ? 'text-danger' : 'text-dark' }}">
                                                                    {{ $vencimento->format('d/m/Y') }}
                                                                    @if ($diasRestantes < 30) <br><small
                                                                            class="text-danger">({{ $diasRestantes }}
                                                                            dias)</small>
                                                                        @endif
                                                                </span>
                                                                @else
                                                                <span class="text-muted">Não informado</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Observações -->
                                    @if ($equipamento->observacao)
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="fas fa-sticky-note"></i> Observações</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $equipamento->observacao }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="text-center mt-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('equipamentos.edit', $equipamento->id) }}"
                                        class="btn btn-warning rounded-pill px-4">
                                        <i class="fas fa-edit"></i> Editar Equipamento
                                    </a>
                                    <form action="{{ route('equipamentos.destroy', $equipamento->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4"
                                            onclick="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                            <i class="fas fa-trash"></i> Excluir Equipamento
                                        </button>
                                    </form>
                                    <a href="{{ route('equipamentos.index') }}"
                                        class="btn btn-secondary rounded-pill px-4">
                                        <i class="fas fa-list"></i> Voltar para Lista
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection