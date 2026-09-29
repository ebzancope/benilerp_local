@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12"
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300;">
                                    <h2><i class="fas fa-calendar-plus"></i> Novo Cronograma</h2>
                                </div>
                            </div>
                            <hr class="my-2">

                            <form action="{{ route('cronograma.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="row mg-b-25 ">
                                        <div class="col-lg-2">
                                            <label class="form-label">Cliente *</label>
                                            <select name="cliente" class="form-select btn-sm"
                                                style="border-radius: 10px" required>
                                                <option value="">Selecione</option>
                                                @foreach ($cliefornes as $clieforne)
                                                <option value="{{ $clieforne->id }}" {{ old('cliente')==$clieforne->id ?
                                                    'selected' : '' }}>
                                                    {{ $clieforne->nome }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Equipamento *</label>
                                            <select name="descricao" class="form-select btn-sm"
                                                style="border-radius: 10px" required>
                                                <option value="">Selecione</option>
                                                @foreach ($equipamentos as $equipamento)
                                                <option value="{{ $equipamento->id }}" {{
                                                    old('descricao')==$equipamento->id ? 'selected' : '' }}>
                                                    {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Data Início *</label>
                                            <input type="date" name="dataini" class="form-select btn-sm"
                                                style="border-radius: 10px" value="{{ old('dataini') }}" required>
                                        </div>

                                        <div class="col-lg-2">
                                            <label class="form-label">Data Término *</label>
                                            <input type="date" name="datafim" class="form-select btn-sm"
                                                style="border-radius: 10px" value="{{ old('datafim') }}" required>
                                        </div>

                                        <div class="col-lg-2">
                                            <label class="form-label">Status *</label>
                                            <select name="estatus" class="form-select btn-sm"
                                                style="border-radius: 10px" required>
                                                <option value="1" {{ old('estatus')=='1' ? 'selected' : '' }}>A
                                                    Receber</option>
                                                <option value="2" {{ old('estatus')=='2' ? 'selected' : '' }}>
                                                    Pago</option>
                                                <option value="5" {{ old('estatus')=='5' ? 'selected' : '' }}>A
                                                    visitar</option>
                                                <option value="4" {{ old('estatus')=='4' ? 'selected' : '' }}>
                                                    Agendar</option>
                                                <option value="7" {{ old('estatus')=='7' ? 'selected' : '' }}>
                                                    Agendado </option>
                                                <option value="3" {{ old('estatus')=='3' ? 'selected' : '' }}>Em
                                                    execução</option>
                                                <option value="6" {{ old('estatus')=='6' ? 'selected' : '' }}>
                                                    Finalizado </option>
                                                    <option value="8" {{ old('estatus')=='8' ? 'selected' : '' }}>
                                                    Orçamento </option>
                                            </select>
                                        </div>

                                    </div><!-- row  25 -->
                                    <div class="row mg-b-25 ">
                                        <div class="col-lg-2">
                                            <label class="form-label">Valor *</label>
                                            <input type="number" step="0.01" name="valor" class="form-control btn-sm"
                                                style="border-radius: 10px" value="0.00" min="0" placeholder=" 0.00"
                                                required>
                                        </div>

                                        <div class="col-lg-2">
                                            <label class="form-label">Vencimento</label>
                                            <input type="date" name="vencimento" class="form-select btn-sm"
                                                style="border-radius: 10px" value="{{ old('vencimento') }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Orçamento</label>
                                            <select name="orcamento_id" class="form-select btn-sm"
                                                style="border-radius: 10px">
                                                <option value="">Selecione</option>
                                                @foreach ($orcamentos as $orc)
                                                <option value="{{ $orc->id }}" {{ old('orcamento_id', $cronograma->
                                                    orcamento_id ?? '') == $orc->id ? 'selected' : '' }}>
                                                    {{ $orc->numero }} / {{ $orc->titulo }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                  <div class="col-lg-2">
    <label for="statuscobra" class="form-label">Status da cobrança</label>
    <select id="statuscobra" name="statuscobra" class="form-select btn-sm" style="border-radius: 10px" >
        @php($opcoes = ['boleto'=>'Boleto','pago'=>'Pago','cobrado'=>'Cobrado','a_cobrar'=>'A Cobrar','pendente'=>'Pendente'])
        @foreach($opcoes as $valor => $rotulo)
            <option value="{{ $valor }}" @selected(old('statuscobra', $cronograma->statuscobra ?? 'a_cobrar') === $valor)>{{ $rotulo }}</option>
        @endforeach
    </select>
 </div>
    <div class="col-lg-2">
 <label for="tipo_pagamento" class="form-label">Tipo de pagamento</label>
    @php($pagOpts = [
        'pix' => 'Pix',
        'boleto' => 'Boleto',
        'cartao' => 'Cartão',
        'cheque' => 'Cheque',
        'dinheiro' => 'Dinheiro',
        'outros' => 'Outros',
    ])
    <select id="tipo_pagamento" name="tipo_pagamento" class="form-select" required>
        @foreach($pagOpts as $val => $lbl)
            <option value="{{ $val }}"
                @selected(old('tipo_pagamento', $cronograma->tipo_pagamento ?? 'outros') === $val)>
                {{ $lbl }}
            </option>
        @endforeach
    </select>

</div>
                                    </div><!-- row  25 -->

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Observação</label>
                                            <textarea name="observacao" class="form-control btn-sm"
                                                style="border-radius: 10px" rows="3"
                                                placeholder="Observações sobre o cronograma">{{ old('observacao') }}</textarea>
                                        </div>
                                    </div>

                                <div class="mb-3">
                                    <label for="obsercobra" class="form-label">Observação de cobrança</label>
                                    <textarea id="obsercobra" name="obsercobra" class="form-control btn-sm" style="border-radius: 10px" rows="3"  placeholder="Observações sobre o cobrança">{{ old('obsercobra', $cronograma->obsercobra ?? '') }}</textarea>
                                </div>





                                </div><!-- row -->





                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('cronograma.index') }}"
                                            class="btn btn-secondary rounded-pill">
                                            <i class="fas fa-arrow-left"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-success rounded-pill">
                                            <i class="fas fa-save"></i> Salvar Cronograma
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
@endsection
