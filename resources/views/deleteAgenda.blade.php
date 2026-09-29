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
                                <label class="section-title fst-italic " style="color: #30a300; ">Deletar cadastro</label>


                                <div class="col card p-5 text-center">
                                    <span class="display-3 mb-5"><i
                                            class="fa-solid fa-triangle-exclamation text-danger opacity-50"></i></span>
                                    <h4 class="text-info mb-3">{{ $agenda->titulo }}</h4>
                                    <p class="text-secondary">Tem certeza?</p>
                                    <div class="mt-3">
                                        <a href="{{ route('Agenda') }}" class="btn btn-warning px-5 m-2 rounded-pill"><i
                                                class="fa-solid fa-xmark me-2"></i>Cancela</a>
                                        <a href="{{ route('deleteAgendaConfirm', ['id' => Crypt::encrypt($agenda->id)]) }}"
                                            class="btn btn-success px-5 m-2 rounded-pill"><i
                                                class="fa-solid fa-trash me-2"></i>Confirma</a>
                                    </div>
                                </div>




                            </div><!-- timeline- -->
                        </div><!-- group -->
                    </div><!-- card -->
                </div><!-- ol lg-->
            </div><!-- timeline-p5 -->
        </div>
    </div>
@endsection
