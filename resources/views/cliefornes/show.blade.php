@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12"
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300;">
                                    <h2><i class="fas fa-eye"></i> Detalhes do Cliente/Fornecedor</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('cliefornes.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                    <a href="{{ route('cliefornes.edit', ['id' => $clieforne->id]) }}"
                                        class="btn btn-warning rounded-pill">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>

                                </div>
                            </div>
                            <hr class="my-2">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informações Básicas
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Criado por:</strong> {{ optional($clieforne->user)->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-calendar"></i> Datas</h5>
                                        </div>
                                        <div class="card-body">
                                           ss
                                        </div>
                                    </div>
                                </div>




                            </div>



                            @if ($clieforne->observacao)
                            <div class="row">

                                @if($clieforne->orcamento_id)
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Orçamento</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Nº :</strong> {{ $clieforne->orcamento->numero ?? '' }}
                                            </p>
                                            <p><strong>Descrição:</strong> {{ $clieforne->orcamento->titulo ?? ''
                                                }}
                                            </p>
                                            <p><strong>Valor:</strong> R$
                                                {{ $clieforne->orcamento->valor_total ?? ''
                                                }}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Observações</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $clieforne->observacao }}</p>
                                        </div>
                                         <div class="card-body">
                                            <p>{{ $clieforne->obsercobra }}</p>
                                        </div>


                                    </div>
                                </div>




                            </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
