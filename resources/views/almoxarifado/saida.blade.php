@extends('layouts.layout')

@section('title', 'Registrar Saída - Almoxarifado')

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
                                    <i class="fas fa-arrow-up"></i> Registrar Saída de Estoque
                                </label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-0">Item: <strong>{{ $almoxarifado->nome }}</strong></h5>
                                        <p class="mb-0 text-muted">Código: {{ $almoxarifado->codigo }} | Estoque Atual:
                                            {{ number_format($almoxarifado->quantidade_atual, 2, ',', '.') }}
                                            {{ $almoxarifado->unidade_medida }}</p>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('almoxarifado.show', $almoxarifado->id) }}"
                                            class="btn btn-secondary rounded-pill">
                                            <i class="fas fa-arrow-left"></i> Voltar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    <form action="{{ route('almoxarifado.saida.store', $almoxarifado->id) }}"
                                        method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="quantidade" class="form-label">Quantidade *</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control rounded-pill @error('quantidade') is-invalid @enderror"
                                                        id="quantidade" name="quantidade" value="{{ old('quantidade') }}"
                                                        required min="0.01" max="{{ $almoxarifado->quantidade_atual }}">
                                                    @error('quantidade')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="form-text text-muted">Máximo:
                                                        {{ number_format($almoxarifado->quantidade_atual, 2, ',', '.') }}
                                                        {{ $almoxarifado->unidade_medida }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="data_movimentacao" class="form-label">Data *</label>
                                                    <input type="date"
                                                        class="form-control rounded-pill @error('data_movimentacao') is-invalid @enderror"
                                                        id="data_movimentacao" name="data_movimentacao"
                                                        value="{{ old('data_movimentacao', date('Y-m-d')) }}" required>
                                                    @error('data_movimentacao')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="documento" class="form-label">Documento</label>
                                                    <input type="text" class="form-control rounded-pill" id="documento"
                                                        name="documento" value="{{ old('documento') }}"
                                                        placeholder="Requisição, OS, etc.">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="equipamento_id" class="form-label">Equipamento</label>
                                                    <select class="form-control rounded-pill" id="equipamento_id"
                                                        name="equipamento_id">
                                                        <option value="">Selecione...</option>
                                                        @foreach ($equipamentos as $equipamento)
                                                            <option value="{{ $equipamento->id }}"
                                                                {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                                                                {{ $equipamento->codigo }} - {{ $equipamento->modelo }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="colaborador_id" class="form-label">Colaborador</label>
                                                    <select class="form-control rounded-pill" id="colaborador_id"
                                                        name="colaborador_id">
                                                        <option value="">Selecione...</option>
                                                        @foreach ($colaboradores as $colaborador)
                                                            <option value="{{ $colaborador->id }}"
                                                                {{ old('colaborador_id') == $colaborador->id ? 'selected' : '' }}>
                                                                {{ $colaborador->nome }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="motivo" class="form-label">Motivo *</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('motivo') is-invalid @enderror"
                                                id="motivo" name="motivo" value="{{ old('motivo') }}" required
                                                placeholder="Manutenção, Uso, Venda, etc.">
                                            @error('motivo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="observacoes" class="form-label">Observações</label>
                                            <textarea class="form-control rounded" id="observacoes" name="observacoes" rows="3"
                                                placeholder="Observações adicionais...">{{ old('observacoes') }}</textarea>
                                        </div>

                                        <!-- Resumo da Saída -->
                                        <div class="card bg-light mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">Resumo da Saída</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Estoque Atual:</strong>
                                                            {{ number_format($almoxarifado->quantidade_atual, 2, ',', '.') }}
                                                            {{ $almoxarifado->unidade_medida }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Custo Médio:</strong> R$
                                                            {{ number_format($almoxarifado->custo_medio, 2, ',', '.') }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Valor da Saída:</strong> <span
                                                                id="valorSaida">R$ 0,00</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('almoxarifado.show', $almoxarifado->id) }}"
                                                class="btn btn-secondary rounded-pill">
                                                <i class="fas fa-times"></i> Cancelar
                                            </a>
                                            <button type="submit" class="btn btn-primary rounded-pill">
                                                <i class="fas fa-check"></i> Registrar Saída
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

    <script>
        // Calcular valor da saída
        document.getElementById('quantidade').addEventListener('input', calcularValorSaida);

        function calcularValorSaida() {
            const quantidade = parseFloat(document.getElementById('quantidade').value) || 0;
            const custoMedio = {{ $almoxarifado->custo_medio }};
            const valorSaida = quantidade * custoMedio;

            document.getElementById('valorSaida').textContent = 'R$ ' + valorSaida.toFixed(2).replace('.', ',');
        }

        // Validar quantidade máxima
        document.getElementById('quantidade').addEventListener('change', function() {
            const max = {{ $almoxarifado->quantidade_atual }};
            const valor = parseFloat(this.value);

            if (valor > max) {
                alert('Quantidade não pode ser maior que o estoque disponível: ' + max.toFixed(2));
                this.value = max;
                calcularValorSaida();
            }
        });
    </script>
@endsection
