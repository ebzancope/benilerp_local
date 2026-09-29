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
                                    <h2><i class="fas fa-eye"></i> Visualizar Despesa #{{ $despesa->id }}</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('despesas.edit', $despesa->id) }}"
                                            class="btn btn-warning rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="{{ route('despesas.index') }}" class="btn btn-secondary rounded-pill">
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
                                <!-- Informações Gerais -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Informações
                                                Gerais</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Competência:</strong><br>
                                                        <span class="badge badge-primary rounded-pill">{{
                                                            $despesa->competencia ?
                                                            $despesa->competencia->format('d/m/Y') : 'N/A' }}</span>
                                                    </p>

                                                    <p><strong>Tipo de Conta:</strong><br>
                                                        <span class="badge badge-success rounded-pill">
                                                            {{ $despesa->tipoconta }} - {{
                                                            $tiposContas[$despesa->tipoconta] ?? 'N/A' }}
                                                        </span>
                                                    </p>

                                                    <p><strong>Centro de Custos:</strong><br>
                                                        <span class="badge badge-secondary rounded-pill">
                                                            {{ $centrosCustos[$despesa->centrocustos] ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Tipo Documento:</strong><br>
                                                        <span class="badge badge-info rounded-pill">
                                                            {{ $tiposDocumentos[$despesa->tipodocumento] ?? 'N/A' }}
                                                        </span>
                                                    </p>

                                                    <p><strong>Nota Fiscal:</strong><br>
                                                        {{ $despesa->notafiscal ?? 'N/A' }}</p>

                                                    <p><strong>Cadastrado por:</strong><br>
                                                        {{ $despesa->user->name ?? 'Sistema' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Financeiras -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave"></i>
                                                Informações Financeiras</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Quantidade:</strong><br>
                                                        {{ $despesa->quantidade ?? '1' }}</p>

                                                    <p><strong>Valor Unitário:</strong><br>
                                                        R$ {{ $despesa->valorunit ?
                                                        number_format((float)$despesa->valorunit, 2, ',', '.') : 'N/A'
                                                        }}</p>

                                                    <p><strong>Valor:</strong><br>
                                                        <span class="h4 text-success">
                                                            R$ {{ number_format((float)$despesa->valortotal, 2, ',',
                                                            '.') }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">


                                                    <p><strong>Data Criação:</strong><br>
                                                        {{ $despesa->created_at->format('d/m/Y H:i') }}</p>

                                                    <p><strong>Última Atualização:</strong><br>
                                                        {{ $despesa->updated_at->format('d/m/Y H:i') }}</p>

                                                         <p><strong>Criado por:</strong> {{ $despesa->user->name ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Relacionamentos -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-truck"></i> Fornecedor</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            @if($despesa->clieforne)
                                            <p class="h5">{{ $despesa->clieforne->nome }}</p>
                                            <p class="text-muted">{{ $despesa->clieforne->documento ?? '' }}</p>
                                            @else
                                            <p class="text-muted">Nenhum fornecedor vinculado</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-user"></i> Colaborador</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            @if($despesa->colaborador_rel)
                                            <p class="h5">{{ $despesa->colaborador_rel->nome }}</p>
                                            <p class="text-muted">{{ $despesa->colaborador_rel->cargo ?? '' }}</p>
                                            @else
                                            <p class="text-muted">Nenhum colaborador vinculado</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-cogs"></i> Equipamento</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            @if($despesa->equipamento_rel)
                                            <p class="h5">{{ $despesa->equipamento_rel->codigo }}</p>
                                            <p class="text-muted">
                                                {{ $despesa->equipamento_rel->marca }} / {{
                                                $despesa->equipamento_rel->modelo }}
                                            </p>
                                            @else
                                            <p class="text-muted">Nenhum equipamento vinculado</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0"><i class="fas fa-align-left"></i> Descrição</h5>
                                </div>
                                <div class="card-body">
                                    <p class="form-control-plaintext border rounded p-3 bg-light">
                                        {{ $despesa->descricao ?? 'Nenhuma descrição informada' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="text-center mt-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('despesas.edit', $despesa->id) }}"
                                        class="btn btn-warning rounded-pill px-4">
                                        <i class="fas fa-edit"></i> Editar Despesa
                                    </a>
                                    <form action="{{ route('despesas.destroy', $despesa->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4"
                                            onclick="return confirm('Tem certeza que deseja excluir esta despesa?')">
                                            <i class="fas fa-trash"></i> Excluir Despesa
                                        </button>
                                    </form>
                                    <a href="{{ route('despesas.index') }}" class="btn btn-secondary rounded-pill px-4">
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
