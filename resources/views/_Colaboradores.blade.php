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
                                        class="icon ion-person"></i> Colaboradores</label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: right">
                                        <a href="{{ route('cadColaborador') }}" class="btn btn-success  rounded-pill">
                                            <i class="fa-solid fa-circle-plus"></i>&nbsp; <i class="icon ion-person"></i>
                                            &nbsp;
                                        </a>
                                    </div>
                                    <!-- busca por data -->
                                </div>
                                <div class="row mg-b-25 align-items-end ">
                                    <!-- linha form -->
                                    <div class="col-lg-2" style="text-align: right">
                                        <form action="{{ route('Colaboradores') }}">
                                            @csrf
                                            <div class="search-box ">
                                                <input type="text" class="form-control" name="text_nome" id="text_nome"
                                                    placeholder="Nome  ss:">
                                                <button class="btn  bd-0 rounded-pill"
                                                    style=" float: right; color: #ffffff; background-color: #30a300;"
                                                    type="submit"> <i class="fa fa-search"></i>
                                                </button>
                                            </div><!-- search-box -->
                                        </form>
                                    </div><!-- col-4 -->
                                </div><!-- row  25 -->
                            </div>
                            @include('list_colaboradores')

                        </div><!-- timeline- -->
                    </div><!-- group -->
                </div><!-- card -->
            </div><!-- ol lg-->
        </div><!-- timeline-p5 -->
    </div>
    </div>
@endsection
