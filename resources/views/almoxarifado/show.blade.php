@extends('layouts.layout')

@section('title', 'Detalhes do Item - Almoxarifado')

@section('content')
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div class="col-lg-12"
                                style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="section-title fst-italic" style="color: #30a300;">
                                        <i class="fa-solid fa-box"></i> Detalhes do Item: {{ $almoxarifado->nome }}
                                    </label>
                                    <div>
                                        <a href="{{ route('almoxarifado.entrada', $almoxarifado->id) }}"
                                            class="btn btn-success rounded-pill">
                                            <i class="fas fa-arrow-down"></i> Entrada
                                        </a>
                                        <a href="{{ route('almoxarifado.saida', $almoxarifado->id) }}"
                                            class="btn btn-primary rounded-pill">
                                            <i class="fas fa-arrow-up"></i> Saída
                                        </a>
                                        <a href="{{ route('almoxarifado.edit', $almoxarifado->id) }}"
                                            class="btn btn-warning rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="{{ route('almoxarifado.index') }}" class="btn btn-secondary rounded-pill">
                                            <i class="fas fa-arrow-left"></i> Voltar
                                        </a>
                                    </div>
                                </div>
                                <hr class="my-2">
                            </div>

                            <!-- Informações do Item -->
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-info-circle"></i> Informações do Item
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Código:</strong> {{ $almoxarifado->codigo }}</p>
                                                    <p><strong>Nome:</strong> {{ $almoxarifado->nome }}</p>
                                                    <p><strong>Categoria:</strong> {{ $almoxarifado->categoria }}</p>
                                                    <p><strong>Unidade:</strong> {{ $almoxarifado->unidade_medida }}</p>
                                                    <p><strong>Localização:</strong>
                                                        {{ $almoxarifado->localizacao ?? 'Não informada' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Fabricante:</strong>
                                                        {{ $almoxarifado->fabricante ?? 'Não informado' }}</p>
                                                    <p><strong>Modelo:</strong>
                                                        {{ $almoxarifado->modelo ?? 'Não informado' }}</p>
                                                    <p><strong>Nº Série:</strong>
                                                        {{ $almoxarifado->numero_serie ?? 'Não informado' }}</p>
                                                    <p><strong>Fornecedor:</strong>
                                                        {{ $almoxarifado->fornecedor->nome ?? 'Não informado' }}</p>
                                                    <p><strong>Status:</strong>
                                                        @if ($almoxarifado->ativo)
                                                            <span class="badge badge-success">Ativo</span>
                                                        @else
                                                            <span class="badge badge-danger">Inativo</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            @if ($almoxarifado->descricao)
                                                <p><strong>Descrição:</strong> {{ $almoxarifado->descricao }}</p>
                                            @endif
                                            @if ($almoxarifado->observacoes)
                                                <p><strong>Observações:</strong> {{ $almoxarifado->observacoes }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Card de Estoque -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-info text-white text-center">
                                            <h5 class="card-title mb-0">Situação do Estoque</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h1
                                                class="display-4
                                            @if ($almoxarifado->situacao_estoque == 'esgotado') text-danger
                                            @elseif($almoxarifado->situacao_estoque == 'baixo') text-warning
                                            @else text-success @endif">
                                                {{ number_format($almoxarifado->quantidade_atual, 2, ',', '.') }}
                                            </h1>
                                            <p class="mb-1">{{ $almoxarifado->unidade_medida }}</p>
                                            <p class="mb-0">
                                                @if ($almoxarifado->situacao_estoque == 'esgotado')
                                                    <span class="badge badge-danger">ESGOTADO</span>
                                                @elseif($almoxarifado->situacao_estoque == 'baixo')
                                                    <span class="badge badge-warning">ESTOQUE BAIXO</span>
                                                @else
                                                    <span class="badge badge-success">NORMAL</span>
                                                @endif
                                            </p>
                                            <small>Mínimo:
                                                {{ number_format($almoxarifado->quantidade_minima, 2, ',', '.') }}</small>
                                        </div>
                                    </div>

                                    <!-- Card de Valores -->
                                    <div class="card">
                                        <div class="card-header bg-success text-white text-center">
                                            <h5 class="card-title mb-0">Valores</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Custo Médio:</strong> R$
                                                {{ number_format($almoxarifado->custo_medio, 2, ',', '.') }}</p>
                                            <p><strong>Último Preço:</strong> R$
                                                {{ number_format($almoxarifado->ultimo_preco, 2, ',', '.') }}</p>
                                            <hr>
                                            <p class="mb-0"><strong>Valor Total em Estoque:</strong><br>
                                                <span class="h5 text-success">R$
                                                    {{ number_format($almoxarifado->valor_total_estoque, 2, ',', '.') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Histórico de Movimentações -->
                            <div class="card mt-4">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-history"></i> Histórico de Movimentações
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if ($movimentacoes->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Tipo</th>
                                                        <th>Quantidade</th>
                                                        <th>Valor Unit.</th>
                                                        <th>Valor Total</th>
                                                        <th>Motivo</th>
                                                        <th>Usuário</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($movimentacoes as $movimentacao)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($movimentacao->data_movimentacao)->format('d/m/Y') }}
                                                            </td>
                                                            <td>
                                                                @if ($movimentacao->tipo == 'entrada')
                                                                    <span class="badge badge-success">Entrada</span>
                                                                @else
                                                                    <span class="badge badge-primary">Saída</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ number_format($movimentacao->quantidade, 2, ',', '.') }}
                                                            </td>
                                                            <td>R$
                                                                {{ number_format($movimentacao->valor_unitario, 2, ',', '.') }}
                                                            </td>
                                                            <td>R$
                                                                {{ number_format($movimentacao->valor_total, 2, ',', '.') }}
                                                            </td>
                                                            <td>{{ $movimentacao->motivo }}</td>
                                                            <td>{{ $movimentacao->usuario->name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Paginação do Histórico -->
                                        @if ($movimentacoes->hasPages())
                                            <div class="d-flex justify-content-center mt-3">
                                                {{ $movimentacoes->links() }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Nenhuma movimentação registrada para este item.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
