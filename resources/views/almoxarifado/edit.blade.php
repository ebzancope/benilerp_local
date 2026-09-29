@extends('layouts.layout')

@section('title', 'Editar Item - Almoxarifado')

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
                                    <i class="fa-solid fa-edit"></i> Editar Item: {{ $almoxarifado->nome }}
                                </label>
                                <hr class="my-2">
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    <form action="{{ route('almoxarifado.update', $almoxarifado->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código *</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('codigo') is-invalid @enderror"
                                                        id="codigo" name="codigo"
                                                        value="{{ old('codigo', $almoxarifado->codigo) }}" required>
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
                                                        id="nome" name="nome"
                                                        value="{{ old('nome', $almoxarifado->nome) }}" required>
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
                                                                {{ old('categoria', $almoxarifado->categoria) == $categoria ? 'selected' : '' }}>
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
                                                                {{ old('unidade_medida', $almoxarifado->unidade_medida) == $key ? 'selected' : '' }}>
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
                                                rows="2">{{ old('descricao', $almoxarifado->descricao) }}</textarea>
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
                                                        value="{{ old('quantidade_minima', $almoxarifado->quantidade_minima) }}"
                                                        required>
                                                    @error('quantidade_minima')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Estoque Atual</label>
                                                    <input type="text" class="form-control rounded-pill bg-light"
                                                        value="{{ number_format($almoxarifado->quantidade_atual, 2, ',', '.') }} {{ $almoxarifado->unidade_medida }}"
                                                        readonly>
                                                    <small class="form-text text-muted">Use Entrada/Saída para alterar
                                                        estoque</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Custo Médio</label>
                                                    <input type="text" class="form-control rounded-pill bg-light"
                                                        value="R$ {{ number_format($almoxarifado->custo_medio, 2, ',', '.') }}"
                                                        readonly>
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
                                                                {{ old('fornecedor_id', $almoxarifado->fornecedor_id) == $fornecedor->id ? 'selected' : '' }}>
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
                                                        value="{{ old('localizacao', $almoxarifado->localizacao) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="fabricante" class="form-label">Fabricante</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="fabricante" name="fabricante"
                                                        value="{{ old('fabricante', $almoxarifado->fabricante) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="modelo" class="form-label">Modelo</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="modelo" name="modelo"
                                                        value="{{ old('modelo', $almoxarifado->modelo) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="numero_serie" class="form-label">Número de Série</label>
                                                    <input type="text" class="form-control rounded-pill"
                                                        id="numero_serie" name="numero_serie"
                                                        value="{{ old('numero_serie', $almoxarifado->numero_serie) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="ativo"
                                                    name="ativo" value="1"
                                                    {{ old('ativo', $almoxarifado->ativo) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ativo">Item Ativo</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="observacoes" class="form-label">Observações</label>
                                            <textarea class="form-control rounded" id="observacoes" name="observacoes" rows="2">{{ old('observacoes', $almoxarifado->observacoes) }}</textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('almoxarifado.show', $almoxarifado->id) }}"
                                                class="btn btn-secondary rounded-pill">
                                                <i class="fas fa-arrow-left"></i> Voltar
                                            </a>
                                            <div>
                                                <a href="{{ route('almoxarifado.show', $almoxarifado->id) }}"
                                                    class="btn btn-outline-secondary rounded-pill">
                                                    Cancelar
                                                </a>
                                                <button type="submit" class="btn btn-success rounded-pill">
                                                    <i class="fas fa-save"></i> Atualizar Item
                                                </button>
                                            </div>
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
