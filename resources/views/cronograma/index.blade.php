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
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fas fa-calendar-alt"></i> Gerenciamento de Cronogramas</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('cronograma.create') }}" class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Novo Cronograma
                                    </a>
                                </div>
                            </div>
                            {{-- No arquivo index.blade.php, na seção de Cards de Resumo --}}
                            <!-- Cards de Resumo -  -->
                            <div class="row mb-4">
                                @if( session('user.access_level') == 3 || session('user.access_level') == 2 )
                                <div class="col">
                                    <a href="{{ route('cronograma.index') }}?status=1" class="text-decoration-none">
                                        <div class="card bg-primary text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>A Receber</h6>
                                                <h5>R$ {{ number_format($totalAReceber ?? 0, 2, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('cronograma.index') }}?status=2" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Total Pago</h6>
                                                <h5>R$ {{ number_format($totalPago ?? 0, 2, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <style>
                                    .hover-card:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                    }
                                </style>
                                @endif
                                <!-- Cards -->
                                <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">

                                    <div class="col">
                                        <a href="{{ route('cronograma.index') }}?status=5"
                                            class="text-decoration-none d-block">
                                            <div class="card bg-secondary text-white rounded-pill hover-card h-100">
                                                <div class="card-body text-center">
                                                    <h6 class="mb-1">A Visitar</h6>
                                                    <h5 class="mb-0">{{ $totalAvisitar }}</h5>

                                                    <strong>R$ {{ number_format($totalValorAvisitar, 2, ',', '.')
                                                        }}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col">
                                        <a href="{{ route('cronograma.index') }}?status=4"
                                            class="text-decoration-none d-block">
                                            <div class="card bg-info text-white rounded-pill hover-card h-100">
                                                <div class="card-body text-center">
                                                    <h6 class="mb-1">Agendar</h6>
                                                    <h5 class="mb-0">{{ $totalAgendar }}</h5>

                                                    <strong>R$ {{ number_format($totalValorAgendar, 2, ',', '.')
                                                        }}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col">
                                        <a href="{{ route('cronograma.index') }}?status=7"
                                            class="text-decoration-none d-block">
                                            <div class="card bg-danger text-white rounded-pill hover-card h-100">
                                                <div class="card-body text-center">
                                                    <h6 class="mb-1">Agendado</h6>
                                                    <h5 class="mb-0">{{ $totalAgendado }}</h5>

                                                    <strong>R$ {{ number_format($totalValorAgendado, 2, ',', '.')
                                                        }}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col">
                                        <a href="{{ route('cronograma.index') }}?status=3"
                                            class="text-decoration-none d-block">
                                            <div class="card bg-warning text-white rounded-pill hover-card h-100">
                                                <div class="card-body text-center">
                                                    <h6 class="mb-1">Em Execução</h6>
                                                    <h5 class="mb-0">{{ $totalExecucao }}</h5>

                                                    <strong>R$ {{ number_format($totalValorExecucao, 2, ',', '.')
                                                        }}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col">
                                        <a href="{{ route('cronograma.index') }}?status=6"
                                            class="text-decoration-none d-block">
                                            <div class="card bg-dark text-white rounded-pill hover-card h-100">
                                                <div class="card-body text-center">
                                                    <h6 class="mb-1">Finalizado</h6>
                                                    <h5 class="mb-0">{{ $totalFinalizado }}</h5>

                                                    <strong>R$ {{ number_format($totalValorFinalizado, 2, ',', '.')
                                                        }}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col">
                                        <a href="{{ route('cronograma.index') }}?status=8"
                                            class="text-decoration-none d-block">
                                            <div class="card bg-dark text-white rounded-pill hover-card h-100">
                                                <div class="card-body text-center">
                                                    <h6 class="mb-1">Orçamento</h6>
                                                    <h5 class="mb-0">{{ $totalOrcamento }}</h5>

                                                    <strong>R$ {{ number_format($totalValorOrcamento, 2, ',', '.')
                                                        }}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-4">
                                &nbsp;
                            </div>






                        </div>
                    </div>
                </div>
                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('cronograma.index') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select name="status" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>
                                            A Receber
                                        </option>
                                        <option value="2" {{ request('status')=='2' ? 'selected' : '' }}>
                                            Pago</option>

                                        <option value="5" {{ request('status')=='5' ? 'selected' : '' }}>A
                                            visitar
                                        </option>

                                        <option value="4" {{ request('status')=='4' ? 'selected' : '' }}>A
                                            Agendar
                                        </option>

                                        <option value="7" {{ request('status')=='7' ? 'selected' : '' }}>
                                            Agendado
                                        </option>

                                        <option value="3" {{ request('status')=='3' ? 'selected' : '' }}>
                                            Em execução
                                        </option>

                                        <option value="6" {{ request('status')=='6' ? 'selected' : '' }}>
                                            Finalizado
                                        </option>
                                        <option value="8" {{ request('status')=='8' ? 'selected' : '' }}>
                                            Orçamento
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Cliente</label>
                                    <select name="cliente" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        @foreach ($cliefornes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ request('cliente')==$cliente->id ?
                                            'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label>Tipo Pagamento</label>
                                    <select name="tipo_pagamento" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        <option value="pix" {{ request('tipo_pagamento')=='pix' ? 'selected' : '' }}>Pix
                                        </option>
                                        <option value="boleto" {{ request('tipo_pagamento')=='boleto' ? 'selected' : ''
                                            }}>Boleto</option>
                                        <option value="cartao" {{ request('tipo_pagamento')=='cartao' ? 'selected' : ''
                                            }}>Cartão</option>
                                        <option value="cheque" {{ request('tipo_pagamento')=='cheque' ? 'selected' : ''
                                            }}>Cheque</option>
                                        <option value="dinheiro" {{ request('tipo_pagamento')=='dinheiro' ? 'selected'
                                            : '' }}>Dinheiro</option>
                                        <option value="outros" {{ request('tipo_pagamento')=='outros' ? 'selected' : ''
                                            }}>Outros</option>
                                    </select>
                                </div>


                                <div class="col-md-2">
                                    <label>Data Início</label>
                                    <input type="date" name="data_inicio" class="form-control rounded-pill">
                                </div>
                                <div class="col-md-2">
                                    <label>Data Fim</label>
                                    <input type="date" name="data_fim" class="form-control rounded-pill">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    <a href="{{ route('cronograma.index') }}"
                                        class="btn btn-secondary btn-block rounded-pill mt-1">
                                        <i class="fas fa-times"></i> Limpar
                                    </a>

                                    <a href="{{ route('cronograma.print', request()->all()) }}"
                                        class="btn btn-outline-secondary btn-block rounded-pill mt-1" target="_blank">
                                        <i class="fas fa-print"></i> Imprimir
                                    </a>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Busca Rápida -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('cronograma.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Busca Rápida</label>
                                <div class="search-box">
                                    <input type="text" class="form-control rounded-pill" name="text_nome" id="text_nome"
                                        placeholder="Cliente " value="{{ request('text_nome') }}">
                                    <button class="btn btn-success rounded-pill-right" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <!-- Tabela de Cronogramas -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Início</th>
                                    <th>Equipamento</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Financeiro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cronogramas as $cronograma)
                                <tr>

                                    <td>{{ $cronograma->clienteInfo->nome ?? 'N/A' }}</td>
                                    <td>{{ $cronograma->dataini->format('d/m/Y') }}</td>


                                    <td>
    {{ optional($cronograma->equipamento)->codigo ?? 'N/A' }}
    /
    {{ optional($cronograma->equipamento)->modelo ?? '---' }}
</td>

                                    <td>R$ {{ number_format($cronograma->valor, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $cronograma->status_color }}">
                                            {{ $cronograma->status_text }}
                                        </span>

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

                                        @if ($cronograma->estatus == '1' && $vencTs && $nowTs > ($vencTs + 30 * 24 * 60
                                        * 60))
                                        <span class="badge badge-danger">
                                            <i class='fa-solid fa-triangle-exclamation'></i> Vencido
                                        </span>
                                        @endif

                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $cronograma->financeiro_color }}">
                                            {{ $cronograma->financeiro_text }}
                                        </span>

                                        @if(($cronograma->tipo_pagamento ?? null) && $cronograma->tipo_pagamento !==
                                        'outros')
                                        <span class="badge badge-secondary">
                                            {{ $cronograma->tipo_pagamento }}
                                        </span>
                                        @endif

                                    </td>
                                    {{-- No arquivo index.blade.php, na coluna Ações --}}
                                    <td>
                                        <a href="{{ route('cronograma.show', $cronograma->id) }}"
                                            class="btn btn-sm btn-info rounded-pill" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('cronograma.edit', $cronograma->id) }}"
                                            class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Ações rápidas de status --}}
                                        @if ($cronograma->estatus != '2')
                                        <form action="{{ route('cronograma.marcar-pago', $cronograma->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill"
                                                title="Marcar como Pago">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if ($cronograma->estatus != '3')
                                        <form action="{{ route('cronograma.marcar-execucao', $cronograma->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning rounded-pill"
                                                title="Marcar como Em Execução">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if ($cronograma->estatus != '4')
                                        <form action="{{ route('cronograma.marcar-agendar', $cronograma->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info rounded-pill"
                                                title="Marcar como Agendar">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if ($cronograma->estatus != '6')
                                        <form action="{{ route('cronograma.marcar-Finalizado', $cronograma->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-dark rounded-pill"
                                                title="Marcar como Finalizado">
                                                <i class="fas fa-calendar-minus"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('cronograma.destroy', $cronograma->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                title="Excluir"
                                                onclick="return confirm('Tem certeza que deseja excluir este cronograma?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $cronogramas->appends([
                    'status' => request('status'),
                    'cliente' => request('cliente'),
                    'data_inicio' => request('data_inicio'),
                    'data_fim' => request('data_fim'),
                    'tipo_pagamento' => request('tipo_pagamento'),
                    ])->links() }}
                </div>
            </div>
        </div><!-- timeline- -->
    </div><!-- group -->
</div><!-- card -->
</div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>
@endsection
