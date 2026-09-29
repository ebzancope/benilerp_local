@extends('layouts.layout')
@include('top_bar')
@section('content')
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-50">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12">



                            <form action="" method="POST">
                                <div class="form-layout">
                                    <div class="row mg-b-25">

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Pagador: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control" id="pagador" name="pagador" required>
                                                    <option value="0"> Selecione </option>

                                                </select>
                                            </div>
                                        </div><!-- col-4 -->

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Beneficiário: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control" id="beneficiario" name="beneficiario" required>
                                                    <option value="0"> Selecione </option>

                                                </select>
                                            </div>
                                        </div><!-- col-4 -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Numero: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="numdoc" required>
                                            </div>
                                        </div><!-- col-4 -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Vencimento: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="vencimento" required>
                                            </div>
                                        </div><!-- col-4 -->


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Valor: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="valor" required>
                                            </div>
                                        </div><!-- col-4 -->

                                        <div class="col-lg-8">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pago"
                                                    value="1" />
                                                <label class="form-check-label" for="pago">
                                                    pago
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">

                                                <input class="form-check-input" type="radio" name="pago"
                                                    value="0" />
                                                <label class="form-check-label" for="pago">
                                                    Aberto
                                                </label>
                                            </div>

                                        </div><!-- col-4 -->

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Descrição: <span
                                                        class="tx-danger">*</span></label>
                                                <textarea class="form-control" name="descricao" rows="3" required></textarea>
                                            </div>
                                        </div><!-- col-4 -->



                                    </div><!-- row  25 -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <a href="{{ url()->previous() }}"
                                                    class="btn btn-secondary bd-0 rounded-pill"
                                                    onClick="document.getElementById('mail_form').submit();">
                                                    &nbsp; &nbsp;&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg"
                                                        width="16" height="16" fill="currentColor"
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
                                                <input name="datacad" type="hidden" value="ss" />
                                                <input name="visita" type="hidden" value="0" />
                                                <button class="btn btn-success bd-0 rounded-pill" style=" float: right;"
                                                    type="submit"> &nbsp; &nbsp;
                                                    &nbsp;
                                                    &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-save"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z" />
                                                    </svg>
                                                    Salvar &nbsp; &nbsp; &nbsp; &nbsp;
                                                    <?php //   ($id == -1) ? "Editar" : "Salvar"
                                                    ?>
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
