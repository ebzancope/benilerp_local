@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="card pd-15" style="border-radius: 10px;background-color: #f6faf4; color: rgb(90, 86, 86);">
                    <div class="timeline-group">
                        <div class="row row-sm row-timeline">
                            <div style="border-radius: 210px;background-color: #f6faf4; color: rgb(90, 86, 86);">
                                <div class="row mb-12">
                                    @include('boletosDashboard')
                                  
                                </div><!-- Card Ultra Simples -->
                            </div><!-- group -->
                        </div><!-- card -->
                    </div><!-- ol lg-->
                </div><!-- timeline- -->
            </div><!-- group -->
        </div><!-- card -->
    </div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>
@endsection
