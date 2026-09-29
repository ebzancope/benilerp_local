{{-- resources/views/boletos/create.blade.php --}}
@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-plus"></i> Novo Boleto</h2>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('boletos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('boletos.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pagador">Pagador *</label>
                                <select class="form-control @error('pagador') is-invalid @enderror" id="pagador"
                                    name="pagador" required>
                                    <option value="">Selecione o pagador</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ old('pagador') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pagador')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="beneficiario">Beneficiário *</label>
                                <select class="form-control @error('beneficiario') is-invalid @enderror" id="beneficiario"
                                    name="beneficiario" required>
                                    <option value="">Selecione o beneficiário</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ old('beneficiario') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('beneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numdoc">Nº Documento *</label>
                                <input type="text" class="form-control @error('numdoc') is-invalid @enderror"
                                    id="numdoc" name="numdoc" value="{{ old('numdoc') }}"
                                    placeholder="Número do documento" required>
                                @error('numdoc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vencimento">Data Vencimento *</label>
                                <input type="date" class="form-control @error('vencimento') is-invalid @enderror"
                                    id="vencimento" name="vencimento" value="{{ old('vencimento') }}" required>
                                @error('vencimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valor">Valor (R$) *</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor"
                                    value="{{ old('valor') }}" placeholder="0,00" required>
                                @error('valor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3"
                                    placeholder="Descrição do boleto">{{ old('descricao') }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="pago" name="pago" value="1"
                                    {{ old('pago') ? 'checked' : '' }}>
                                <label class="form-check-label" for="pago">Marcar como pago</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Salvar Boleto
                            </button>
                            <a href="{{ route('boletos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
