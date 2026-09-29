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
                                    <h2><i class="fa-solid fa-users"></i> Clientes e Fornecedores</h2>
                                    <p class="mb-0" style="color: #666; font-size: 0.9rem;">Cadastro de clientes e
                                        fornecedores</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('cliefornes.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fa-solid fa-circle-plus"></i> Novo Cadastro
                                    </a>
                                </div>
                            </div>

                            <!-- Cards de Resumo -->
                            <div class="row mb-4">
                                <div class="col">
                                    <a href="{{ route('cliefornes.index') }}?tipo=1" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Clientes</h6>
                                                <h5>{{ $totalClientes }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('cliefornes.index') }}?tipo=2" class="text-decoration-none">
                                        <div class="card bg-info text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Fornecedores</h6>
                                                <h5>{{ $totalFornecedores }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('cliefornes.index') }}" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Total Ativos</h6>
                                                <h5>{{ $totalAtivos }}</h5>
                                            </div>
                                        </div>
                                    </a>
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
                        <form method="GET" action="{{ route('cliefornes.index') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Tipo</label>
                                    <select name="tipo" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('tipo')=='1' ? 'selected' : '' }}>Cliente</option>
                                        <option value="2" {{ request('tipo')=='2' ? 'selected' : '' }}>Fornecedor
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>UF</label>
                                    <select name="uf" class="form-select rounded-pill">
                                        <option value="">Todas</option>
                                        <option value="AC" {{ request('uf')=='AC' ? 'selected' : '' }}>AC</option>
                                        <option value="AL" {{ request('uf')=='AL' ? 'selected' : '' }}>AL</option>
                                        <option value="AP" {{ request('uf')=='AP' ? 'selected' : '' }}>AP</option>
                                        <option value="AM" {{ request('uf')=='AM' ? 'selected' : '' }}>AM</option>
                                        <option value="BA" {{ request('uf')=='BA' ? 'selected' : '' }}>BA</option>
                                        <option value="CE" {{ request('uf')=='CE' ? 'selected' : '' }}>CE</option>
                                        <option value="DF" {{ request('uf')=='DF' ? 'selected' : '' }}>DF</option>
                                        <option value="ES" {{ request('uf')=='ES' ? 'selected' : '' }}>ES</option>
                                        <option value="GO" {{ request('uf')=='GO' ? 'selected' : '' }}>GO</option>
                                        <option value="MA" {{ request('uf')=='MA' ? 'selected' : '' }}>MA</option>
                                        <option value="MT" {{ request('uf')=='MT' ? 'selected' : '' }}>MT</option>
                                        <option value="MS" {{ request('uf')=='MS' ? 'selected' : '' }}>MS</option>
                                        <option value="MG" {{ request('uf')=='MG' ? 'selected' : '' }}>MG</option>
                                        <option value="PA" {{ request('uf')=='PA' ? 'selected' : '' }}>PA</option>
                                        <option value="PB" {{ request('uf')=='PB' ? 'selected' : '' }}>PB</option>
                                        <option value="PR" {{ request('uf')=='PR' ? 'selected' : '' }}>PR</option>
                                        <option value="PE" {{ request('uf')=='PE' ? 'selected' : '' }}>PE</option>
                                        <option value="PI" {{ request('uf')=='PI' ? 'selected' : '' }}>PI</option>
                                        <option value="RJ" {{ request('uf')=='RJ' ? 'selected' : '' }}>RJ</option>
                                        <option value="RN" {{ request('uf')=='RN' ? 'selected' : '' }}>RN</option>
                                        <option value="RS" {{ request('uf')=='RS' ? 'selected' : '' }}>RS</option>
                                        <option value="RO" {{ request('uf')=='RO' ? 'selected' : '' }}>RO</option>
                                        <option value="RR" {{ request('uf')=='RR' ? 'selected' : '' }}>RR</option>
                                        <option value="SC" {{ request('uf')=='SC' ? 'selected' : '' }}>SC</option>
                                        <option value="SP" {{ request('uf')=='SP' ? 'selected' : '' }}>SP</option>
                                        <option value="SE" {{ request('uf')=='SE' ? 'selected' : '' }}>SE</option>
                                        <option value="TO" {{ request('uf')=='TO' ? 'selected' : '' }}>TO</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" class="form-control rounded-pill"
                                        value="{{ request('cidade') }}" placeholder="Cidade">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    <a href="{{ route('cliefornes.index') }}"
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
                        <form action="{{ route('cliefornes.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Busca Rápida</label>
                                    <div class="search-box">
                                        <input type="text" class="form-control rounded-pill" name="text_nome"
                                            id="text_nome" placeholder="Nome, apelido, email ou CPF/CNPJ"
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

                <!-- Tabela de Clientes/Fornecedores -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome / Apelido</th>
                                        <th>Contato</th>
                                        <th>Documento</th>
                                        <th>Observação</th>
                                        <th>Localização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cliefornes as $clieforne)
                                    <tr>
                                        <td>
                                            <strong>{{ $clieforne->nome }}</strong>
                                            @if($clieforne->apelido)
                                            <br><small class="text-muted">{{ $clieforne->apelido }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($clieforne->email)
                                            <div><i class="fa-solid fa-envelope"></i> {{ $clieforne->email }}</div>
                                            @endif
                                            @if($clieforne->fone)
                                            <div><i class="fa-solid fa-phone"></i> {{ $clieforne->fone }}</div>
                                            @endif
                                            @if($clieforne->celular)
                                            <div><i class="fa-solid fa-mobile"></i> {{ $clieforne->celular }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $clieforne->cpfj }}</td>
                                        <td>
                                            {{ $clieforne->obs }}
                                        </td>
                                        <td>
                                            @if($clieforne->cidade)
                                            <div>{{ $clieforne->cidade }}/{{ $clieforne->uf }}</div>
                                            @endif
                                            @if($clieforne->bairro)
                                            <small class="text-muted">{{ $clieforne->bairro }}</small>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ route('cliefornes.edit', ['id' => Crypt::encrypt($clieforne->id)]) }}"
                                                class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('cliefornes.destroy', ['id' => Crypt::encrypt($clieforne->id)]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                    title="Excluir"
                                                    onclick="return confirm('Tem certeza que deseja excluir este cadastro?')">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum cadastro encontrado.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        {{ $cliefornes->appends(request()->query())->links() }}

                        <!-- Resumo -->
                        @if(count($cliefornes) > 0)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="alert alert-light">
                                    <small>
                                        <strong>Total encontrado:</strong> {{ $cliefornes->total() }} cadastro(s) |
                                        <strong>Página:</strong> {{ $cliefornes->currentPage() }} de {{
                                        $cliefornes->lastPage() }}
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
