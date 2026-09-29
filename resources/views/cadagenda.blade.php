@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5 ">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <form action="{{ route('cadAgendaSubmit') }}" method="POST">
                        @csrf
                        <div class="timeline-group">
                            <div class="row row-sm row-timeline">
                                <div class="col-lg-12 "
                                    style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86);">
                                    <label class="section-title fst-italic " style="color: #30a300; ">Cadastrar
                                        Cronograma</label>
                                    <hr class="my-2">

                                    <div class="form-layout ">
                                        <div class="row mg-b-25 ">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Titulo: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="text_titulo" required
                                                        value="{{ old('text_titulo') }}">
                                                    {{-- Show Error --}}
                                                    @error('text_titulo')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div><!-- col-4 -->
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Mensagem: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="text" name="text_mensagem" required
                                                        value="{{ old('text_mensagem') }}">
                                                    {{-- Show Error --}}
                                                    @error('text_mensagem')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div><!-- col-4 -->
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Data da Visita: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="date" name="date_agendata" required
                                                        value="{{ old('date_agendata') }}">
                                                </div>
                                            </div><!-- col-4 -->
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Hora da Visita: <span
                                                            class="tx-danger">*</span></label>
                                                    <input class="form-control btn-sm" style="border-radius: 10px"
                                                        type="time" name="date_agenhora" required
                                                        value="{{ old('date_agenhora') }}">
                                                </div>
                                            </div><!-- col-4 -->
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label btn-sm">Observação: <span
                                                            class="tx-danger">*</span></label>
                                                    <textarea class="form-control btn-sm" style="border-radius: 10px" name="text_observacao" rows="3" required>{{ old('text_observacao') }}</textarea>
                                                </div>
                                            </div><!-- col-4 -->
                                        </div><!-- row  25 -->
                                    </div><!-- class layout -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <a href="{{ route('Agenda') }}" class="btn btn-secondary bd-0 rounded-pill"
                                                    onClick="document.getElementById('mail_form').submit();">
                                                    &nbsp; &nbsp;
                                                    &nbsp;
                                                    &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-box-arrow-in-left"
                                                        viewBox="0 0 16 16">
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
                                </div><!-- form-layout-footer -->
                            </div><!-- form-layout -->
                        </div><!-- section-wrapper -->
                    </form>
                </div><!-- col-9 -->
            </div><!-- row -->
        </div><!-- timeline-group -->
    </div><!-- card -->
    </div><!-- col-9 -->
    </div><!-- row -->
@endsection
