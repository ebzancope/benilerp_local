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
                                    <h2><i class="fas fa-user"></i> Detalhes do Colaborador</h2>
                                    <p class="text-muted">{{ $colaborador->nome }}</p>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('colaboradores.edit', $colaborador->id) }}"
                                            class="btn btn-warning rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="{{ route('colaboradores.index') }}"
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
                                <!-- Informações Pessoais -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-id-card"></i> Informações Pessoais</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th width="40%">Nome:</th>
                                                    <td><strong>{{ $colaborador->nome }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Apelido:</th>
                                                    <td>{{ $colaborador->apelido ?: 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>CPF:</th>
                                                    <td>{{ $colaborador->cpf_formatado ?: 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Data Nascimento:</th>
                                                    <td>{{ $colaborador->nascimento_formatado }}
                                                        @if ($colaborador->idade)
                                                        <span class="text-muted">({{ $colaborador->idade }} anos)</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>E-mail:</th>
                                                    <td>{{ $colaborador->email ?: 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Telefone:</th>
                                                    <td>{{ $colaborador->telefone_formatado ?: 'Não informado' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Profissionais -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-briefcase"></i> Informações Profissionais
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th width="40%">Empresa:</th>
                                                    <td>{{ $colaborador->empresaInfo->nome ?? 'Não informada' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Cargo:</th>
                                                    <td><span class="badge badge-info">{{ $colaborador->cargo }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Função:</th>
                                                    <td>{{ $colaborador->funcao ?: 'Não informada' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Setor:</th>
                                                    <td>{{ $colaborador->setor ?: 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Categoria:</th>
                                                    <td><span class="badge badge-secondary">{{ $colaborador->categoria
                                                            ?: 'Não informada' }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Nível:</th>
                                                    <td>
                                                        @php
                                                        $niveis = [1 => 'Operacional', 2 => 'Supervisão', 3 =>
                                                        'Gerência', 4 => 'Diretoria', 5 => 'Administrativo'];
                                                        @endphp
                                                        {{ $niveis[$colaborador->nivel] ?? 'Não informado' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Datas e Documentos -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Datas Importantes</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th width="50%">Admissão:</th>
                                                    <td>{{ $colaborador->admissao_formatada }}
                                                        @if ($colaborador->tempo_empresa_formatado)
                                                        <br><small class="text-muted">{{
                                                            $colaborador->tempo_empresa_formatado }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>CNH:</th>
                                                    <td>{{ $colaborador->cnh ?: 'Não informada' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Validade CNH:</th>
                                                    <td>
                                                        @if ($colaborador->validade)
                                                        @php
                                                        $validade = \Carbon\Carbon::parse($colaborador->validade);
                                                        $diasRestantes = now()->diffInDays($validade, false);
                                                        @endphp
                                                        <span
                                                            class="{{ $diasRestantes < 30 ? 'text-danger' : 'text-dark' }}">
                                                            {{ $validade->format('d/m/Y') }}
                                                            @if ($diasRestantes < 30) <br><small class="text-danger">({{
                                                                    $diasRestantes }} dias para vencer)</small>
                                                                @endif
                                                        </span>
                                                        @else
                                                        <span class="text-muted">Não informada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Remuneração</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th width="50%">Salário:</th>
                                                    <td>
                                                        @if ($colaborador->salario)
                                                        <strong class="text-success">R$ {{
                                                            number_format($colaborador->salario, 2, ',', '.')
                                                            }}</strong>
                                                        @else
                                                        <span class="text-muted">Não informado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td>
                                                        <span class="badge badge-{{ $colaborador->status_color }}">
                                                            {{ $colaborador->status_text }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Cadastrado por:</th>
                                                    <td>{{ $colaborador->usuario->name ?? 'Sistema' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Última atualização:</th>
                                                    <td>{{ $colaborador->updated_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Endereço e Contatos Emergenciais -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-secondary text-white">
                                            <h5 class="mb-0"><i class="fas fa-home"></i> Endereço</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-1">
                                                @if ($colaborador->endereco)
                                                {{ $colaborador->endereco }}, {{ $colaborador->numero }}
                                                @if ($colaborador->bairro)
                                                <br>{{ $colaborador->bairro }}
                                                @endif
                                                @if ($colaborador->cidade)
                                                <br>{{ $colaborador->cidade }}/{{ $colaborador->uf }}
                                                @endif
                                                @if ($colaborador->cep)
                                                <br>CEP: {{ $colaborador->cep_formatado }}
                                                @endif
                                                @else
                                                <span class="text-muted">Endereço não informado</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-danger text-white">
                                            <h5 class="mb-0"><i class="fas fa-phone-alt"></i> Contatos Emergenciais</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th width="40%">Contato:</th>
                                                    <td>{{ $colaborador->contato ?: 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Telefone:</th>
                                                    <td>{{ $colaborador->fone_formatado ?: 'Não informado' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Observações -->
                            @if ($colaborador->obs)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Observações</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $colaborador->obs }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Ações -->
                            <div class="text-center mt-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('colaboradores.edit', $colaborador->id) }}"
                                        class="btn btn-warning rounded-pill px-4">
                                        <i class="fas fa-edit"></i> Editar Colaborador
                                    </a>
                                    <form action="{{ route('colaboradores.destroy', $colaborador->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4"
                                            onclick="return confirm('Tem certeza que deseja excluir este colaborador?')">
                                            <i class="fas fa-trash"></i> Excluir Colaborador
                                        </button>
                                    </form>
                                    <a href="{{ route('colaboradores.index') }}"
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