@extends('layouts.layout')
@section('content')
    <style>
        .dropbtn {
            background-color: #238a28;
            color: white;
            padding: 10px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #29b930;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>
    <div class="container-fluid">
        <div class="row row-sm row-timeline pd-5 ">
            <div class="col-lg-12">
                <div class="card pd-15" style="border-radius: 10px">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div class="col-lg-12 "
                                style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                                <label class="section-title fst-italic " style="color: #30a300; "> <i
                                        class="fa-solid fa-gas-pump"></i> Abastecimentos </label>
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: right">
                                        <a href="#"
                                            class="btn btn-success  rounded-pill @disabled(true)  ">
                                            <i class="fa-solid fa-magnifying-glass"></i>&nbsp; <i
                                                class="fa-solid fa-file-lines"></i>
                                            &nbsp;
                                        </a> <!-- relatorio -->
                                        <a href="{{ route('cadAbastecimento') }}" class="btn btn-success  rounded-pill">
                                            <i class="fa-solid fa-circle-plus"></i>&nbsp; <i
                                                class="fa-solid fa-gas-pump"></i>
                                            &nbsp;
                                        </a>
                                    </div>
                                    <!-- cadastrar -->
                                </div>
                                <div class="row mg-b-25 align-items-end ">
                                    <!-- linha form -->
                                    <div class="col-lg-2" style="text-align: right">
                                        <form action="{{ route('Abastecimento') }}">
                                            @csrf
                                            <div class="search-box ">
                                                <input type="text" class="form-control" name="text_nome" id="text_nome"
                                                    placeholder="Código ou Fornecedor">
                                                <button class="btn  bd-0 rounded-pill"
                                                    style=" float: right; color: #ffffff; background-color: #30a300;"
                                                    type="submit"> <i class="fa fa-search"></i>
                                                </button>
                                            </div><!-- search-box -->
                                        </form>
                                    </div><!-- col-4 -->
                                </div><!-- row  25 -->
                            </div>
                            aqui
                        </div><!-- timeline- -->
                    </div><!-- group -->
                </div><!-- card -->
            </div><!-- ol lg-->
        </div><!-- timeline-p5 -->
    </div>
    </div>
@endsection
