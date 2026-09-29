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
                                    <h2><i class="fas fa-edit"></i> Editar Despesa #{{ $despesa->id }}</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('despesas.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('despesas.update', $despesa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Coluna 1 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="competencia" class="form-label">Competência *</label>
                                            <input type="date"
                                                class="form-control rounded-pill @error('competencia') is-invalid @enderror"
                                                id="competencia" name="competencia"
                                                value="{{ old('competencia', $despesa->competencia ? $despesa->competencia->format('Y-m-d') : date('Y-m-d')) }}"
                                                required>
                                            @error('competencia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipoconta" class="form-label">Tipo de Conta *</label>
                                            <select
                                                class="form-control rounded-pill @error('tipoconta') is-invalid @enderror"
                                                id="tipoconta" name="tipoconta" required>
                                                <option value="">Selecione o tipo de conta</option>
                                                @foreach ($tiposContas as $key => $value)
                                                <option value="{{ $key }}" {{ old('tipoconta', $despesa->tipoconta) ==
                                                    $key ? 'selected' : '' }}>
                                                    {{ $key }} - {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('tipoconta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="centrocustos" class="form-label">Centro de Custos</label>
                                            <select
                                                class="form-control rounded-pill @error('centrocustos') is-invalid @enderror"
                                                id="centrocustos" name="centrocustos">
                                                <option value="">Selecione o centro de custo</option>
                                                @foreach ($centrosCustos as $key => $value)
                                                <option value="{{ $key }}" {{ old('centrocustos', $despesa->
                                                    centrocustos) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('centrocustos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipodocumento" class="form-label">Tipo Documento</label>
                                            <select
                                                class="form-control rounded-pill @error('tipodocumento') is-invalid @enderror"
                                                id="tipodocumento" name="tipodocumento">
                                                <option value="">Selecione o tipo de documento</option>
                                                @foreach ($tiposDocumentos as $key => $value)
                                                <option value="{{ $key }}" {{ old('tipodocumento', $despesa->
                                                    tipodocumento) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('tipodocumento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Coluna 2 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fornecedor" class="form-label">Fornecedor</label>
                                            <select
                                                class="form-control rounded-pill @error('fornecedor') is-invalid @enderror"
                                                id="fornecedor" name="fornecedor">
                                                <option value="">Selecione o fornecedor</option>
                                                @foreach ($fornecedores as $fornecedor)
                                                <option value="{{ $fornecedor->id }}" {{ old('fornecedor', $despesa->
                                                    fornecedor) == $fornecedor->id ? 'selected' : '' }}>
                                                    {{ $fornecedor->nome }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('fornecedor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="equipamento" class="form-label">Equipamento</label>
                                            <select
                                                class="form-control rounded-pill @error('equipamento') is-invalid @enderror"
                                                id="equipamento" name="equipamento">
                                                <option value="">Selecione o equipamento</option>
                                                @foreach ($equipamentos as $equip)
                                                <option value="{{ $equip->id }}" {{ old('equipamento', $despesa->
                                                    equipamento) == $equip->id ? 'selected' : '' }}>
                                                    {{ $equip->codigo }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('equipamento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="colaborador" class="form-label">Colaborador</label>
                                            <select
                                                class="form-control rounded-pill @error('colaborador') is-invalid @enderror"
                                                id="colaborador" name="colaborador">
                                                <option value="">Selecione o colaborador</option>
                                                @foreach ($colaboradores as $colab)
                                                <option value="{{ $colab->id }}" {{ old('colaborador', $despesa->
                                                    colaborador) == $colab->id ? 'selected' : '' }}>
                                                    {{ $colab->nome }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('colaborador')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="notafiscal" class="form-label">Documento</label>
                                        <input type="text"
                                            class="form-control rounded-pill @error('notafiscal') is-invalid @enderror"
                                            id="notafiscal" name="notafiscal"
                                            value="{{ old('notafiscal', $despesa->notafiscal) }}">
                                        @error('notafiscal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Valores -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="quantidade" class="form-label">Quantidade</label>
                                                <input type="number" step="0.01"
                                                    class="form-control rounded-pill @error('quantidade') is-invalid @enderror"
                                                    id="quantidade" name="quantidade"
                                                    value="{{ old('quantidade', $despesa->quantidade) }}">
                                                @error('quantidade')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="valorunit" class="form-label">Valor Unitário</label>
                                                <input type="number" step="0.01"
                                                    class="form-control rounded-pill @error('valorunit') is-invalid @enderror"
                                                    id="valorunit" name="valorunit"
                                                    value="{{ old('valorunit', $despesa->valorunit) }}">
                                                @error('valorunit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="valortotal" class="form-label">Valor Total *</label>
                                                <input type="number" step="0.01"
                                                    class="form-control rounded-pill @error('valortotal') is-invalid @enderror"
                                                    id="valortotal" name="valortotal"
                                                    value="{{ old('valortotal', $despesa->valortotal) }}">
                                                @error('valortotal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Descrição -->
                                    <div class="form-group mb-4">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea
                                            class="form-control rounded-pill @error('descricao') is-invalid @enderror"
                                            id="descricao" name="descricao"
                                            rows="3">{{ old('descricao', $despesa->descricao) }}</textarea>
                                        @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Botões -->
                                    <div class="form-group mt-4 text-center">
                                        <button type="submit" class="btn btn-success rounded-pill px-5">
                                            <i class="fas fa-save"></i> Atualizar Despesa
                                        </button>
                                        <a href="{{ route('despesas.index') }}"
                                            class="btn btn-secondary rounded-pill px-5">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantidade = document.getElementById('quantidade');
        const valorUnit = document.getElementById('valorunit');
        const valorTotal = document.getElementById('valortotal');
        function calcularTotal() {
            const qtd = parseFloat(quantidade.value) || 0;
            const vUnit = parseFloat(valorUnit.value) || 0;
            const total = qtd * vUnit;

            if (!isNaN(total) && total > 0) {
                valorTotal.value = total.toFixed(2);
            }
        }

        quantidade.addEventListener('input', calcularTotal);
        valorUnit.addEventListener('input', calcularTotal);

        // Calcular ao carregar a página se houver valores
        calcularTotal();
    });
</script>
@endsection
