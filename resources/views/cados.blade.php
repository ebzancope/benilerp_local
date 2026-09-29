@extends('layouts.layout')
@section('content')
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-50">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12">
                            <label class="section-title">Ordem de Serviço</label>
                            <form action="" method="POST" id="os">
                                <div class="form-layout">
                                    <div class="row mg-b-25">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="form-control-label">Cliente: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control" id="cliente" name="cliente">
                                                    <option value=""> Selecione </option>
                                                </select>
                                            </div>
                                        </div><!-- col-8 -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label btn-sm">Descrição: </label>
                                                <input class="form-control btn-sm" style="border-radius: 10px"
                                                    type="text" name="tex_desc" value="{{ old('tex_desc') }}">
                                            </div>
                                        </div><!-- col-4 -->



                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Data: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="dataos" value="ss"
                                                    maxlength="10" required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    &nbsp;
                                                </div>
                                                <div class="col-sm">
                                                    <input type="hidden" id="numos" name="numos" value="ss" />
                                                    <input type="hidden" id="ativo" name="ativo" value="1" />
                                                    <input name="data_cad" type="hidden" value="ss" />
                                                    <button class="btn btn-warning  b d-0 rounded-pill"
                                                        style=" float: right;" type="submit"> &nbsp; &nbsp;
                                                        &nbsp;
                                                        &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-save"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z" />
                                                        </svg>
                                                        Abrir OS &nbsp;&nbsp;&nbsp;&nbsp;
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
