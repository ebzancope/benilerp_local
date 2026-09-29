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
                                    class="fa-solid fa-money-check-dollar"></i> Gerar relatório de Faturamento :
                            </label>
                            <hr class="my-2">
                            <form action="{{ route('fatprint') }}" method="post" target="_blank">
                                @csrf
                                <div class="form-layout">
                                    <div class="row mg-b-25 ">
                                        <div class="col-lg-2  ">
                                            <div class="form-group ">
                                                <label class="form-control-label btn-sm">Equipamento: <span
                                                        class="tx-danger">*</span></label>
                                                <select name="tex_equipamento" id="tex_equipamento"
                                                    class="form-select btn-sm" style="border-radius: 10px">
                                                    <option value="{{ Crypt::encrypt('0') }}"> Selecione </option>
                                                    @foreach ($equipamentos as $equipamento)
                                                    <option value="{{ Crypt::encrypt($equipamento->id) }}">
                                                        {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                                                        {{ $equipamento->id }}
                                                    </option required>
                                                    @endforeach
                                                </select required>
                                            </div>
                                        </div><!-- col-2 -->
                                        <div class="col-lg-2  ">
                                            <div class="form-group ">
                                                <label class="form-control-label btn-sm">Colaborador: </label>
                                                <select name="tex_colaborador" id="tex_colaborador"
                                                    class="form-select btn-sm" style="border-radius: 10px">
                                                    <option value="{{ Crypt::encrypt('0') }}"> Selecione </option>
                                                    @foreach ($colaboradores as $colaboradore)
                                                    <option value="{{ Crypt::encrypt($colaboradore->id) }}">
                                                        {{ $colaboradore->nome }}
                                                    </option>
                                                    @endforeach
                                                </select required>
                                            </div>
                                        </div><!-- col-2 -->
                                        <div class="col-lg-2">
                                            <div class="form-group ">
                                                <label class="form-control-label btn-sm">Data Inicial: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control btn-sm" style="border-radius: 10px"
                                                    type="date" name="tex_dataini" required
                                                    value="{{ old('tex_dataini') }}">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label btn-sm">Data Final:</label>
                                                <input class="form-control btn-sm" style="border-radius: 10px"
                                                    type="date" name="tex_datafim" value="{{ old('tex_datafim') }}"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label btn-sm"> &nbsp;&nbsp; &nbsp;
                                                    &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;</br></label>
                                                <button class="btn btn-secondary  b d-0 rounded-pill"
                                                    style=" float: right;" type="submit"> &nbsp; &nbsp;
                                                    &nbsp;
                                                    &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                                        <path
                                                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                                        <path
                                                            d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                                    </svg>
                                                    Gerar
                                                    &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                                                </button>
                                            </div>
                                        </div><!-- col-2 -->
                                    </div><!-- row  25 -->
                                </div><!-- row  layout-->
                            </form>
                        </div>
                        <!-- import- -->
                    </div><!-- timeline- -->
                </div><!-- group -->
            </div><!-- card -->
        </div><!-- ol lg-->
    </div><!-- timeline-p5 -->
</div>
</div>
@endsection