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
                            <label class="section-title fst-italic " style="color: #30a300; "> <i
                                    class="fa-solid fa-gas-pump"></i> Editar Abastecimento </label>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">

                                    <a href="{{ route('abastecimentos.show', $abastecimento->id) }}"
                                        class="btn btn-info">
                                        <i class="fas fa-eye"></i> Visualizar
                                    </a>

                                    <a href="#" class="btn btn-success  rounded-pill">
                                        <i class="fa-solid fa-magnifying-glass"></i>&nbsp; <i
                                            class="fa-solid fa-eye"></i>
                                        &nbsp;
                                    </a>
                                    <a href="{{ route('cadAbastecimento') }}" class="btn btn-success  rounded-pill">
                                        <i class="fa-solid fa-circle-plus"></i>&nbsp; <i
                                            class="fa-solid fa-gas-pump"></i>
                                        &nbsp;
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h2><i class="fas fa-edit"></i> Editar Abastecimento</h2>
                                <p class="text-muted">ID: {{ $abastecimento->id }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('abastecimentos.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('abastecimentos.update', $abastecimento->id) }}"
                                    id="formAbastecimento">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Data e Veículo -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="datacad">Data e Hora *</label>
                                                <input type="datetime-local"
                                                    class="form-control @error('datacad') is-invalid @enderror"
                                                    id="datacad" name="datacad"
                                                    value="{{ old('datacad', $abastecimento->datacad ? \Carbon\Carbon::parse($abastecimento->datacad)->format('Y-m-d\TH:i') : '') }}"
                                                    required>
                                                @error('datacad')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="veiculo">Veículo *</label>
                                                <select class="form-control @error('veiculo') is-invalid @enderror"
                                                    id="veiculo" name="veiculo" required>
                                                    <option value="">Selecione o veículo</option>
                                                    @foreach ($veiculos as $veiculo)
                                                    <option value="{{ $veiculo->id }}" {{ old('veiculo',
                                                        $abastecimento->veiculo) == $veiculo->id ? 'selected' : '' }}>
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
                                                <input type="number" step="0.1"
                                                    class="form-control @error('km') is-invalid @enderror" id="km"
                                                    name="km" value="{{ old('km', $abastecimento->km) }}"
                                                    placeholder="Km atual">
                                                @error('km')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="horimini">Horímetro</label>
                                                <input type="number" step="0.1"
                                                    class="form-control @error('horimini') is-invalid @enderror"
                                                    id="horimini" name="horimini"
                                                    value="{{ old('horimini', $abastecimento->horimini) }}"
                                                    placeholder="Horas">
                                                @error('horimini')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ... início omitido ... -->

                                    <div class="row">
                                        <!-- Fornecedor e Combustível -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fornecedor">Fornecedor *</label>
                                                <select class="form-control @error('fornecedor') is-invalid @enderror"
                                                    id="fornecedor" name="fornecedor" required>
                                                    <option value="">Selecione o fornecedor</option>
                                                    @foreach ($fornecedores as $fornecedor)
                                                    <option value="{{ $fornecedor->id }}" {{ old('fornecedor',
                                                        $abastecimento->fornecedor) == $fornecedor->id ? 'selected' : ''
                                                        }}>
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
                                                <select class="form-control @error('combustivel') is-invalid @enderror"
                                                    id="combustivel" name="combustivel" required>
                                                    <option value="">Selecione o combustível</option>
                                                    @foreach ($tiposCombustivel as $key => $nome)
                                                    <option value="{{ $key }}" {{ old('combustivel', $abastecimento->
                                                        combustivel) == $key ? 'selected' : '' }}>
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
                                                <select class="form-control @error('colaborador') is-invalid @enderror"
                                                    id="colaborador" name="colaborador">
                                                    <option value="">Selecione o colaborador</option>
                                                    @foreach ($colaboradores as $colab)
                                                    <option value="{{ $colab->id }}" {{ old('colaborador',
                                                        $abastecimento->colaborador) == $colab->id ? 'selected' : '' }}>
                                                        {{ $colab->nome }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('colaborador')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ... restante do formulário e script ... -->

                                    <div class="row">
                                        <!-- Valores do Abastecimento -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="litros">Litros *</label>
                                                <input type="number" step="0.001"
                                                    class="form-control @error('litros') is-invalid @enderror"
                                                    id="litros" name="litros"
                                                    value="{{ old('litros', $abastecimento->litros) }}"
                                                    placeholder="0,000" required>
                                                @error('litros')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="totala">Valor Total *</label>
                                                <input type="number" step="0.01"
                                                    class="form-control @error('totala') is-invalid @enderror"
                                                    id="totala" name="totala"
                                                    value="{{ old('totala', $abastecimento->totala) }}"
                                                    placeholder="0,00" required>
                                                @error('totala')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="qtda">Preço por Litro</label>
                                                <input type="number" step="0.001"
                                                    class="form-control @error('qtda') is-invalid @enderror" id="qtda"
                                                    name="qtda" value="{{ old('qtda', $abastecimento->qtda) }}"
                                                    placeholder="0,000" readonly>
                                                @error('qtda')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="desconto">Desconto (R$)</label>
                                                <input type="number" step="0.01"
                                                    class="form-control @error('desconto') is-invalid @enderror"
                                                    id="desconto" name="desconto"
                                                    value="{{ old('desconto', $abastecimento->desconto) }}"
                                                    placeholder="0,00">
                                                @error('desconto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo">Tipo de Abastecimento</label>
                                                <select class="form-control @error('tipo') is-invalid @enderror"
                                                    id="tipo" name="tipo">
                                                    @foreach ($tiposAbastecimento as $key => $nome)
                                                    <option value="{{ $key }}" {{ old('tipo', $abastecimento->tipo) ==
                                                        $key ? 'selected' : '' }}>
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
                                                <input type="text"
                                                    class="form-control @error('requisicao') is-invalid @enderror"
                                                    id="requisicao" name="requisicao"
                                                    value="{{ old('requisicao', $abastecimento->requisicao) }}"
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
                                                <textarea class="form-control @error('descricao') is-invalid @enderror"
                                                    id="descricao" name="descricao" rows="3"
                                                    placeholder="Observações sobre o abastecimento">{{ old('descricao', $abastecimento->descricao) }}</textarea>
                                                @error('descricao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-save"></i> Atualizar Abastecimento
                                            </button>
                                            <a href="{{ route('abastecimentos.index') }}" class="btn btn-secondary">
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
        </div><!-- col lg-->
    </div><!-- timeline-p5 -->
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const litrosInput = document.getElementById('litros');
        const precoInput = document.getElementById('qtda');       // Preço por litro (readonly)
        const descontoInput = document.getElementById('desconto');
        const totalInput = document.getElementById('totala');     // Valor Total (editável)

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