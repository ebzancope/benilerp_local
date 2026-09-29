@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5 ">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div class="col-lg-12 "
                                style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86);">
                                <label class="section-title fst-italic " style="color: #30a300; "> <i
                                        class="fa-solid fa-gas-pump"></i> Editar
                                    Abastecimento </label>
                                <hr class="my-2">
                                <form action="{{ route('editAbastecimentoSubmit') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ Crypt::encrypt($abastecimento->id) }}">
                                    <div class="form-layout ">
                                        <div class="row mg-b-25 ">
                                            <div class="col-lg-2  ">
                                                <div class="form-group ">
                                                    <label class="form-control-label btn-sm">Veículos: <span
                                                            class="tx-danger">*</span></label>
                                                    <select name="tex_veiculos" class="form-select btn-sm"
                                                        style="border-radius: 10px">
                                                        <option value="0" {{ $equipamentos->id ?? 'Selecione' }}>
                                                        </option>
                                                        @foreach ($equipamentos as $equipamento)
                                                            <option value="{{ $equipamento->id }}"
                                                                @if ($equipamento->id == $abastecimento->veiculo) selected @endif>
                                                                {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                                                            </option>
                                                        @endforeach
                                                    </select required>
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-2  ">
                                                <div class="form-group ">
                                                    <label class="form-control-label btn-sm">Fornecedor: <span
                                                            class="tx-danger">*</span></label>

                                                    <select name="tex_fornecedor" class="form-select btn-sm"
                                                        style="border-radius: 10px">
                                                        <option value="0" {{ $cliefornes->id ?? 'Selecione' }}>
                                                        </option>
                                                        @foreach ($cliefornes as $clieforne)
                                                            <option value="{{ $clieforne->id }}"
                                                                @if ($clieforne->id == $abastecimento->fornecedor) selected @endif>
                                                                {{ $clieforne->nome }}
                                                            </option>
                                                        @endforeach
                                                    </select required>
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Combustível: <span
                                                            class="tx-danger">*</span></label>
                                                    <select name="tex_combustivel" class="form-select  btn-sm"
                                                        style="border-radius: 10px">
                                                        <option value="0">Selecione </option>
                                                        <option value="1"
                                                            @if ($abastecimento->combustivel == '1') selected @endif> Disel S500
                                                        </option>
                                                        <option value="2"
                                                            @if ($abastecimento->combustivel == '2') selected @endif>Diesel S10
                                                        </option>
                                                        <option value="3"
                                                            @if ($abastecimento->combustivel == '3') selected @endif>Gasolina
                                                        </option>
                                                        <option value="4"
                                                            @if ($abastecimento->combustivel == '4') selected @endif>Gasolina
                                                            Aditivada</option>
                                                        <option value="5"
                                                            @if ($abastecimento->combustivel == '5') selected @endif>Etanol
                                                        </option>
                                                    </select required>
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Data: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="tex_data"
                                                        value=" {{ date('d/m/Y', strtotime(old('tex_data', $abastecimento->datacad ?? ''))) }}"
                                                        required>
                                                </div>
                                            </div><!-- col-2 -->
                                        </div><!-- row  25 -->
                                        <div class="row mg-b-25 ">
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Litros: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="litros" id="litros"
                                                        value="{{ old('litros', $abastecimento->litros ?? '') }}" required>
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Valor: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="totala" id="totala" required
                                                        value="{{ old('totala', $abastecimento->totala ?? '') }}">
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Desconto :<span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="desconto" id="desconto" required
                                                        value="{{ old('desconto', $abastecimento->desconto ?? '') }}">
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label class="form-control-label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <input class="form-control  btn btn-secondary btn-sm"
                                                        style="border-radius: 10px" type="button" name="Calcular"
                                                        id="Calcular" value="Calcular" onclick="somacam()">
                                                </div>
                                            </div><!-- col-2 -->
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Total R$ :</label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="qtda" id="qtda" readonly
                                                        value="{{ old('qtda', $abastecimento->qtda ?? '') }}">
                                                </div>
                                            </div><!-- col-2 -->
                                        </div><!-- row  25 -->
                                    </div><!--layout form-->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <a href="{{ url()->previous() }}"
                                                    class="btn btn-secondary bd-0 rounded-pill">
                                                    &nbsp; &nbsp;
                                                    &nbsp;
                                                    &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z" />
                                                        <path fill-rule="evenodd"
                                                            d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                                                    </svg> Voltar &nbsp; &nbsp; &nbsp; &nbsp;</a>
                                                </button>
                                            </div>
                                            <div class="col-sm">
                                                &nbsp;
                                            </div>
                                            <div class="col-sm">
                                                <input type="hidden" id="ativo" name="ativo" value="1" />
                                                <input name="data_cad" type="hidden" value="<?php date('Y-m-d H:i:s'); ?>" />
                                                <button class="btn  bd-0 rounded-pill"
                                                    style=" float: right; color: #ffffff; background-color: #30a300;"
                                                    type="submit"> &nbsp; &nbsp; &nbsp;
                                                    &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-save"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z" />
                                                    </svg>
                                                    Salvar &nbsp; &nbsp; &nbsp; &nbsp;
                                                </button>
                                            </div>
                                        </div>
                                    </div><!-- container -->
                                </form>
                            </div><!-- col-9 -->
                        </div><!-- row -->
                    </div><!-- timeline-group -->
                </div><!-- card -->
            </div><!-- col-9 -->
        </div><!-- row -->
    @endsection
