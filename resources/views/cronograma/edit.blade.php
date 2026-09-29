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
                                    <h2><i class="fas fa-edit"></i> Editar Cronograma</h2>
                                </div>
                            </div>
                            <hr class="my-2">

                            <form action="{{ route('cronograma.update', $cronograma->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="row mg-b-25 ">
                                        <div class="col-lg-2">
                                            <label class="form-label">Cliente *</label>
                                            <select name="cliente" class="form-select btn-sm"
                                                style="border-radius: 10px" required>
                                                <option value="">Selecione</option>
                                                @foreach ($cliefornes as $clieforne)
                                                <option value="{{ $clieforne->id }}" {{ $cronograma->cliente ==
                                                    $clieforne->id ? 'selected' : '' }}>
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
                                                <option value="{{ $equipamento->id }}" {{ $cronograma->descricao ==
                                                    $equipamento->id ? 'selected' : '' }}>
                                                    {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <label class="form-label">Data Início *</label>
                                            <input type="date" name="dataini" class="form-control rounded-pill"
                                                value="{{ $cronograma->dataini->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Data Término *</label>
                                            <input type="date" name="datafim" class="form-control btn-sm"
                                                style="border-radius: 10px"
                                                value="{{ $cronograma->datafim->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Status *</label>
                                            <select name="estatus" class="form-select btn-sm"
                                                style="border-radius: 10px" required>
                                                <option value="1" {{ $cronograma->estatus == '1' ? 'selected' : '' }}>A
                                                    Receber
                                                </option>
                                                <option value="2" {{ $cronograma->estatus == '2' ? 'selected' : ''
                                                    }}>Pago
                                                </option>

                                                <option value="5" {{ $cronograma->estatus == '5' ? 'selected' : '' }}>A
                                                    visitar
                                                </option>
                                                <option value="4" {{ $cronograma->estatus == '4' ? 'selected' : ''
                                                    }}>Agendar
                                                </option>
                                                <option value="7" {{ $cronograma->estatus == '7' ? 'selected' : ''
                                                    }}>Agendado
                                                </option>

                                                <option value="3" {{ $cronograma->estatus == '3' ? 'selected' : '' }}>Em
                                                    execução
                                                </option>
                                                <option value="6" {{ $cronograma->estatus == '6' ? 'selected' : ''
                                                    }}>Finalizado
                                                </option>
                                                <option value="8" {{ $cronograma->estatus == '8' ? 'selected' : '' }}>
                                                    Orçamento
                                                </option>
                                            </select>
                                        </div>

                                <div class="col-lg-2">
                                    <label class="form-label"> Vincular OS: </label>
                <select name="fatura_numos" class="form-select btn-sm">
                    <option value="">Selecione</option>
                    @foreach ($faturas as $fatura)
                        <option value="{{ $fatura->numos }}"
                            {{ old('fatura_numos', $cronograma->fatura_numos ?? '') == $fatura->numos ? 'selected' : '' }}>
                            {{ $fatura->numos }} / {{ $fatura->descricao }}
                        </option>
                    @endforeach
                </select>


                                </div>

                                    </div><!-- row  25 -->
                                    <div class="row mg-b-25 ">
                                        <div class="col-lg-2">
                                            <label class="form-label">Valor *</label>
                                            <input type="text" name="valor" class="form-control btn-sm" style="border-radius: 10px"
                         value="{{ old('valor', number_format((float) $cronograma->valor, 2, ',', '.')) }}" required>


                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Vencimento</label>
                                            <input type="date" name="vencimento" class="form-control btn-sm"
                                                style="border-radius: 10px"
                                                value="{{ $cronograma->vencimento ? $cronograma->vencimento->format('Y-m-d') : '' }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Vincular orçamento:</label>
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
        'guardado' => 'Guardado',

    ])
    <select id="tipo_pagamento" name="tipo_pagamento" class="form-select btn-sm" style="border-radius: 10px" required>
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
                                                placeholder="Observações sobre o cronograma">{{ $cronograma->observacao }}</textarea>
                                        </div>
                                    </div>
                                <div class="mb-3">
                                    <label for="obsercobra" class="form-label">Observação de cobrança</label>
                                    <textarea id="obsercobra" name="obsercobra" class="form-control btn-sm" style="border-radius: 10px" rows="3"  placeholder="Observações sobre o cobrança">{{ old('obsercobra', $cronograma->obsercobra ?? '') }}</textarea>
                                </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">

                                        <button type="submit" class="btn btn-success rounded-pill">
                                            <i class="fas fa-save"></i> Atualizar Cronograma
                                        </button>



                                    </div>
                                </div>

                                 <div class="col-md-6 text-left">
                                   <a href="{{ route('cronograma.index') }}"
                                            class="btn btn-secondary rounded-pill">
                                            <i class="fas fa-undo"></i> Voltar
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
@endsection
