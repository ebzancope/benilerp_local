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
                                @if (count($almoxarifado) == 0)
                                    <div><label class="section-title fst-italic " style="color: #30a300; "><i
                                                class="fa-solid fa-warehouse"></i> Almoxarifado </label>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row mt-5">
                                        <div class="col text-center">
                                            <p class="display-6 mb-5 text-secondary opacity-50">Sem Almoxarifado cadastrados
                                            </p>
                                            <a href="#?place=2" class="btn btn-secondary btn-lg p-3 px-5 rounded-pill">
                                                <i class="fa-solid fa-warehouse"></i> Cadastrar Almoxarifado
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <label class="section-title fst-italic " style="color: #30a300; "><i
                                            class="fa-solid fa-warehouse"></i> Almoxarifado</label>
                                    <hr class="my-2">
                                    @include('list_almoxarifado')
                                @endif
                            </div><!-- timeline- -->
                        </div><!-- group -->
                    </div><!-- card -->
                </div><!-- ol lg-->
            </div><!-- timeline-p5 -->
        </div>
    @endsection
