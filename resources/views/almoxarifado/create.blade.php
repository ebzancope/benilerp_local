@extends('layouts.layout')

@section('title', 'Novo Item - Almoxarifado')

@section('content')
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div class="col-lg-12"
                                style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                                <label class="section-title fst-italic" style="color: #30a300;">
                                    <i class="fa-solid fa-circle-plus"></i> Cadastrar Novo Item
                                </label>
                                <hr class="my-2">
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    <!-- Debug: Exibir todos os erros -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <h5><i class="fas fa-exclamation-triangle"></i> Erros de Validação:</h5>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            <h5><i class="fas fa-exclamation-triangle"></i> Erro:</h5>
                                            <p class="mb-0">{{ session('error') }}</p>
                                        </div>
                                    @endif
                                    <form action="{{ route('almoxarifado.store') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código *</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('codigo') is-invalid @enderror"
                                                        id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                                                    @error('codigo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nome" class="form-label">Nome do Item *</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('nome') is-invalid @enderror"
                                                        id="nome" name="nome" value="{{ old('nome') }}" required>
                                                    @error('nome')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="categoria" class="form-label">Categoria *</label>
                                                    <select
                                                        class="form-control rounded-pill @error('categoria') is-invalid @enderror"
                                                        id="categoria" name="categoria" required>
                                                        <option value="">Selecione...</option>
                                                        @foreach ($categorias as $categoria)
                                                            <option value="{{ $categoria }}"
                                                                {{ old('categoria') == $categoria ? 'selected' : '' }}>
                                                                {{ $categoria }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('categoria')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="unidade_medida" class="form-label">Unidade de Medida
                                                        *</label>
                                                    <select
                                                        class="form-control rounded-pill @error('unidade_medida') is-invalid @enderror"
                                                        id="unidade_medida" name="unidade_medida" required>
                                                        <option value="">Selecione...</option>
                                                        @foreach ($unidades as $key => $label)
                                                            <option value="{{ $key }}"
                                                                {{ old('unidade_medida') == $key ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('unidade_medida')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <textarea class="form-control rounded @error('descricao') is-invalid @enderror" id="descricao" name="descricao"
                                                rows="2">{{ old('descricao') }}</textarea>
                                            @error('descricao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="quantidade_minima" class="form-label">Estoque Mínimo
                                                        *</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control rounded-pill @error('quantidade_minima') is-invalid @enderror"
                                                        id="quantidade_minima" name="quantidade_minima"
                                                        value="{{ old('quantidade_minima', 0) }}" required>
                                                    @error('quantidade_minima')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="quantidade_atual" class="form-label">Estoque Inicial
                                                        *</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control rounded-pill @error('quantidade_atual') is-invalid @enderror"
                                                        id="quantidade_atual" name="quantidade_atual"
                                                        value="{{ old('quantidade_atual', 0) }}" required>
                                                    @error('quantidade_atual')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="ultimo_preco" class="form-label">Último Preço *</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control rounded-pill @error('ultimo_preco') is-invalid @enderror"
                                                        id="ultimo_preco" name="ultimo_preco"
                                                        value="{{ old('ultimo_preco', 0) }}" required>
                                                    @error('ultimo_preco')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="fornecedor_id" class="form-label">Fornecedor</label>
                                                    <select class="form-control rounded-pill" id="fornecedor_id"
                                                        name="fornecedor_id">
                                                        <option value="">Selecione...</option>
                                                        @foreach ($fornecedores as $fornecedor)
                                                            <option value="{{ $fornecedor->id }}"
                                                                {{ old('fornecedor_id') == $fornecedor->id ? 'selected' : '' }}>
                                                                {{ $fornecedor->nome }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="localizacao" class="form-label">Localização</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="localizacao" name="localizacao"
                                                        value="{{ old('localizacao') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="fabricante" class="form-label">Fabricante</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="fabricante" name="fabricante"
                                                        value="{{ old('fabricante') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="modelo" class="form-label">Modelo</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="modelo" name="modelo" value="{{ old('modelo') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="numero_serie" class="form-label">Número de Série</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="numero_serie" name="numero_serie"
                                                        value="{{ old('numero_serie') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="observacoes" class="form-label">Observações</label>
                                            <textarea class="form-control rounded" id="observacoes" name="observacoes" rows="2">{{ old('observacoes') }}</textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('almoxarifado.index') }}"
                                                class="btn btn-secondary rounded-pill">
                                                <i class="fas fa-arrow-left"></i> Voltar
                                            </a>
                                            <button type="submit" class="btn btn-success rounded-pill">
                                                <i class="fas fa-save"></i> Cadastrar Item
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
