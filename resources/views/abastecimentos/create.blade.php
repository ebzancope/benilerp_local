@extends('layouts.layout')
@section('content')
<style>
    .dropbtn {
        background-color: #238a28;
        color: white;
        padding: 10px;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }

    .dropbtn:hover,
    .dropbtn:focus {
        background-color: #29b930;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown a:hover {
        background-color: #ddd;
    }

    .show {
        display: block;
    }
</style>
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12 "
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <label class="section-title fst-italic " style="color: #30a300; "> <i
                                    class="fa-solid fa-gas-pump"></i> Novo Abastecimento </label>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <a href="{{ route('abastecimentos.index') }}"
                                        class="btn btn-success  rounded-pill  ">
                                        <i class="fas fa-arrow-left"></i>&nbsp; Voltar
                                        &nbsp;
                                    </a> <!-- relatorio -->

                                </div>
                                <!-- cadastrar -->
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('abastecimentos.store') }}" id="formAbastecimento">
                                    @csrf

                                    <div class="row">
                                        <!-- Data e Veículo -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="datacad">Data e Hora *</label>
                                                <input type="date" style="border-radius: 10px"
                                                    class="form-control @error('datacad') is-invalid @enderror"
                                                    id="datacad" name="datacad"
                                                    value="{{ old('datacad', now()->format('Y-m-d')) }}" required>
                                                @error('datacad')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="veiculo">Veículo *</label>
                                                <select style="border-radius: 10px"
                                                    class="form-control @error('veiculo') is-invalid @enderror"
                                                    id="veiculo" name="veiculo" required>
                                                    <option value="">Selecione o veículo</option>
                                                    @foreach ($veiculos as $veiculo)
                                                    <option value="{{ $veiculo->id }}" {{ old('veiculo')==$veiculo->id ?
                                                        'selected' : '' }}>
                                                        {{ $veiculo->codigo }} - {{ $veiculo->modelo }}
                                                        ({{ $veiculo->placa ?? 'Sem placa' }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('veiculo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="km">Quilometragem (km)</label>
                                                <input type="number" step="0.1" style="border-radius: 10px"
                                                    class="form-control @error('km') is-invalid @enderror" id="km"
                                                    name="km" value="{{ old('km') }}" placeholder="Km atual">
                                                @error('km')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="horimini">Horímetro</label>
                                                <input type="number" step="0.1" style="border-radius: 10px"
                                                    class="form-control @error('horimini') is-invalid @enderror"
                                                    id="horimini" name="horimini" value="{{ old('horimini') }}"
                                                    placeholder="Horas">
                                                @error('horimini')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Fornecedor e Combustível -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fornecedor">Fornecedor *</label>
                                                <select style="border-radius: 10px"
                                                    class="form-control @error('fornecedor') is-invalid @enderror"
                                                    id="fornecedor" name="fornecedor" required>
                                                    <option value="">Selecione o fornecedor</option>
                                                    @foreach ($fornecedores as $fornecedor)
                                                    <option value="{{ $fornecedor->id }}" {{
                                                        old('fornecedor')==$fornecedor->id ? 'selected' : '' }}>
                                                        {{ $fornecedor->nome }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('fornecedor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="combustivel">Combustível *</label>
                                                <select style="border-radius: 10px"
                                                    class="form-control @error('combustivel') is-invalid @enderror"
                                                    id="combustivel" name="combustivel" required>
                                                    <option value="">Selecione o combustível</option>
                                                    @foreach ($tiposCombustivel as $key => $nome)
                                                    <option value="{{ $key }}" {{ old('combustivel')==$key ? 'selected'
                                                        : '' }}>
                                                        {{ $nome }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('combustivel')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="colaborador">Colaborador</label>
                                                <select style="border-radius: 10px"
                                                    class="form-control @error('colaborador') is-invalid @enderror"
                                                    id="colaborador" name="colaborador">
                                                    <option value="">Selecione o colaborador</option>
                                                    @foreach ($colaboradores as $colaborador)
                                                    <option value="{{ $colaborador->id }}" {{
                                                        old('colaborador')==$colaborador->id ? 'selected' : '' }}>
                                                        {{ $colaborador->nome }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('colaborador')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Litros -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="litros">Litros *</label>
                                                <input type="number" step="0.001"
                                                    class="form-control @error('litros') is-invalid @enderror"
                                                    id="litros" name="litros" value="{{ old('litros') }}"
                                                    placeholder="0,000" required>
                                                @error('litros')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Valor Total (agora editável pelo usuário) -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="totala">Valor Total *</label>
                                                <input style="border-radius: 10px" type="number" step="0.01"
                                                    class="form-control @error('totala') is-invalid @enderror"
                                                    id="totala" name="totala" value="{{ old('totala') }}"
                                                    placeholder="0,00" required>
                                                @error('totala')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Preço por Litro (calculado) -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="qtda">Preço por Litro (R$)</label>
                                                <input style="border-radius: 10px" type="number" step="0.001"
                                                    class="form-control @error('qtda') is-invalid @enderror" id="qtda"
                                                    name="qtda" value="{{ old('qtda') }}" placeholder="0,000" readonly>
                                                @error('qtda')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Desconto -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="desconto">Desconto (R$)</label>
                                                <input style="border-radius: 10px" type="number" step="0.01"
                                                    class="form-control @error('desconto') is-invalid @enderror"
                                                    id="desconto" name="desconto" value="{{ old('desconto', 0) }}"
                                                    placeholder="0,00">
                                                @error('desconto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Tipo de Abastecimento -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo">Tipo de Abastecimento</label>
                                                <select style="border-radius: 10px"
                                                    class="form-control @error('tipo') is-invalid @enderror" id="tipo"
                                                    name="tipo">
                                                    @foreach ($tiposAbastecimento as $key => $nome)
                                                    <option value="{{ $key }}" {{ old('tipo', 1)==$key ? 'selected' : ''
                                                        }}>
                                                        {{ $nome }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('tipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Informações Adicionais -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="requisicao">Nº Requisição</label>
                                                <input type="text" style="border-radius: 10px"
                                                    class="form-control @error('requisicao') is-invalid @enderror"
                                                    id="requisicao" name="requisicao" value="{{ old('requisicao') }}"
                                                    placeholder="Número da requisição">
                                                @error('requisicao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="descricao">Observações</label>
                                                <textarea style="border-radius: 10px" style="border-radius: 10px"
                                                    class="form-control   @error('descricao') is-invalid @enderror"
                                                    id="descricao" name="descricao" rows="3"
                                                    placeholder="Observações sobre o abastecimento">{{ old('descricao') }}</textarea>
                                                @error('descricao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" style="border-radius: 10px"
                                                class="btn btn-success btn-lg rounded-pill">
                                                <i class="fas fa-save"></i> Salvar Abastecimento
                                            </button>
                                            <a href="{{ route('abastecimentos.index') }}"
                                                class="btn btn-secondary rounded-pill">
                                                <i class="fas fa-times"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- timeline- -->
                </div><!-- group -->
            </div><!-- card -->
        </div><!-- ol lg-->
    </div><!-- timeline-p5 -->
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const litrosInput = document.getElementById('litros');
    const precoInput = document.getElementById('qtda');
    const descontoInput = document.getElementById('desconto');
    const totalInput = document.getElementById('totala');

    function recalcularPrecoPorLitro() {
        const litros = parseFloat(litrosInput.value) || 0;
        const total = parseFloat(totalInput.value) || 0;
        const desconto = parseFloat(descontoInput.value) || 0;

        if (litros > 0) {
            const preco = (total + desconto) / litros;
            precoInput.value = preco.toFixed(3);
        } else {
            precoInput.value = '';
        }
    }

    // Recalcular sempre que os campos mudarem
    litrosInput.addEventListener('input', recalcularPrecoPorLitro);
    totalInput.addEventListener('input', recalcularPrecoPorLitro);
    descontoInput.addEventListener('input', recalcularPrecoPorLitro);

    // Cálculo inicial
    recalcularPrecoPorLitro();
});
</script>
@endsection