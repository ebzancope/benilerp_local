@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="card pd-15" style="border-radius: 10px;background-color: #f6faf4; color: rgb(90, 86, 86);">
            <div class="timeline-group">
                <div class="row row-sm row-timeline">
                    <div style="border-radius: 210px;background-color: #f6faf4; color: rgb(90, 86, 86);">
                        <label class="section-title fst-italic " style="color: #30a300; ">Resumos de dados</label>
                        <div class="row mb-4">
                            @include('boletosDashboard')
                        </div><!-- Card Ultra Simples -->
                        @include('list_agenda_home')
                    </div><!-- timeline- -->
                </div><!-- group -->
            </div><!-- card -->
        </div><!-- ol lg-->
    </div>
    @endsection