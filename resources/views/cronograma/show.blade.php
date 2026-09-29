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
                                    <h2><i class="fas fa-eye"></i> Detalhes do Cronograma</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('cronograma.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                    <a href="{{ route('cronograma.edit', $cronograma->id) }}"
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
                                            <p><strong>Cliente:</strong> {{ $cronograma->clienteInfo->nome ?? 'N/A' }}
                                            <p><strong>Fone:</strong> {{ $cronograma->clienteInfo->fone ?? '' }} / {{
                                                $cronograma->clienteInfo->telefone ?? '' }}
                                            <p><strong>Cliente:</strong> {{ $cronograma->clienteInfo->email ?? 'N/A'
                                                }}
                                            <p><strong>CNPJ/CPF:</strong> {{ $cronograma->clienteInfo->cpfj ?? 'N/A'
                                                }}
                                            </p>
                                            <p><strong>Equipamento:</strong>
                                                {{ $cronograma->equipamento->codigo ?? 'N/A' }} -
                                                {{ $cronograma->equipamento->modelo ?? '' }}</p>
                                            <p><strong>Status:</strong> <span
                                                    class="badge badge-{{ $cronograma->status_color }}">{{
                                                    $cronograma->status_text }}</span>

                                                @php
                                                $venc = $cronograma->vencimento ?? null;
                                                if ($venc instanceof \DateTimeInterface) {
                                                $vencTs = strtotime($venc->format('Y-m-d H:i:s'));
                                                } elseif (is_string($venc)) {
                                                $vencTs = strtotime($venc);
                                                } else {
                                                $vencTs = null;
                                                }
                                                $nowTs = time();
                                                @endphp

                                                @if ($cronograma->estatus == '1' && $vencTs && $nowTs > ($vencTs + 30 *
                                                24 * 60
                                                * 60))
                                                <span class="badge badge-danger">
                                                    <i class='fa-solid fa-triangle-exclamation'></i> Vencido
                                                </span>
                                                @endif
                                            </p>
                                            <p><strong>Valor:</strong> R$
                                                {{ number_format($cronograma->valor, 2, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-calendar"></i> Datas</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Início:</strong> {{ $cronograma->dataini->format('d/m/Y H:i') }}
                                            </p>
                                            <p><strong>Término:</strong> {{ $cronograma->datafim->format('d/m/Y H:i') }}
                                            </p>
                                            <p><strong>Vencimento:</strong>
                                                {{ $cronograma->vencimento ? $cronograma->vencimento->format('d/m/Y
                                                H:i') : 'N/A' }}
                                            </p>
                                            <p><strong>Criado por:</strong> {{ $cronograma->user->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>




                            </div>



                            @if ($cronograma->observacao)
                            <div class="row">

                                @if($cronograma->orcamento_id)
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Orçamento</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Nº :</strong> {{ $cronograma->orcamento->numero ?? '' }}
                                            </p>
                                            <p><strong>Descrição:</strong> {{ $cronograma->orcamento->titulo ?? ''
                                                }}
                                            </p>
                                            <p><strong>Valor:</strong> R$
                                                {{ $cronograma->orcamento->valor_total ?? ''
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
                                            <p>{{ $cronograma->observacao }}</p>
                                        </div>
                                         <div class="card-body">
                                            <p>{{ $cronograma->obsercobra }}</p>
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
