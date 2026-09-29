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
                                    class="fa-solid fa-gas-pump"></i> Controle de Abastecimentos </label>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <!-- add abastecimento -->
                                    <a href="{{ route('abastecimentos.create') }}"
                                        class="btn btn-success  rounded-pill">
                                        <i class="fa-solid fa-circle-plus"></i>&nbsp; <i
                                            class="fa-solid fa-gas-pump"></i>
                                        &nbsp;
                                    </a>
                                    <!-- relatorio -->
                                    <div class="dropdown">
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-success dropdown-toggle rounded-pill dropbtn">
                                            <i class="fas fa-chart-bar"></i>
                                            Relatórios</button>
                                        <div id="myDropdown" class="dropdown-content ">
                                            <a class="text-decoration-none"
                                                href="{{ route('relatorios.abastecimentos.consumo-veiculos') }}"> Por
                                                Veículo</a>
                                            <a class="text-decoration-none"
                                                href="{{ route('relatorios.abastecimentos.consumo-fornecedores') }}">Por
                                                Fornecedor</a>
                                            <a class="text-decoration-none"
                                                href="{{ route('relatorios.abastecimentos.consumo-combustiveis') }}">Por
                                                Combustível</a>
                                        </div>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <!-- cadastrar -->
                            </div>
                        </div>
                        <!-- Filtros -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <form method="GET" action="{{ route('abastecimentos.index') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Veículo</label>
                                            <select name="veiculo" class="form-control rounded-pill">
                                                <option value="">Todos os Veículos</option>
                                                @foreach ($veiculos as $veiculo)
                                                <option value="{{ $veiculo->id }}" {{ request('veiculo')==$veiculo->id ?
                                                    'selected' : '' }}>
                                                    {{ $veiculo->codigo }} - {{ $veiculo->modelo }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Fornecedor</label>
                                            <select name="fornecedor" class="form-control rounded-pill">
                                                <option value="">Todos</option>
                                                @foreach ($fornecedores as $fornecedor)
                                                <option value="{{ $fornecedor->id }}" {{
                                                    request('fornecedor')==$fornecedor->id ? 'selected' : '' }}>
                                                    {{ $fornecedor->nome }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Combustível</label>
                                            <select name="combustivel" class="form-control rounded-pill">
                                                <option value="">Todos</option>
                                                @foreach ($tiposCombustivel as $key => $nome)
                                                <option value="{{ $key }}" {{ request('combustivel')==$key ? 'selected'
                                                    : '' }}>
                                                    {{ $nome }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Data Início</label>
                                            <input type="date" name="data_inicio" class="form-control rounded-pill"
                                                value="{{ request('data_inicio') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Data Fim</label>
                                            <input type="date" name="data_fim" class="form-control rounded-pill"
                                                value="{{ request('data_fim') }}">
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-success btn-block rounded-pill">
                                                <i class="fas fa-filter"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Cards de Resumo -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card  w-60 bg-primary text-white rounded-pill">
                                    <div class="card-body text-center">
                                        <h5>Total Abastecimentos</h5>
                                        <h3>{{ $abastecimentos->total() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card w-60 bg-success text-white rounded-pill">
                                    <div class="card-body text-center">
                                        <h5>Total Litros</h5>
                                        <h3>{{ number_format($abastecimentos->sum('litros'), 0, ',', '.') }} L</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card w-60 bg-info text-white rounded-pill">
                                    <div class="card-body text-center">
                                        <h5>Valor Total</h5>
                                        <h3>R$ {{ number_format($abastecimentos->sum('totala'), 2, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white rounded-pill">
                                    <div class="card-body text-center">
                                        <h5>Preço Médio/L</h5>
                                        <h3>R$ {{ number_format($abastecimentos->avg('qtda') ?? 0, 3, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tabela de Abastecimentos -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Veículo</th>
                                                <th>Fornecedor</th>
                                                <th>Combustível</th>
                                                <th>Litros</th>
                                                <th>Preço/L</th>
                                                <th>Total</th>
                                                <th>KM</th>
                                                <th width="120">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($abastecimentos as $abastecimento)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($abastecimento->datacad)->format('d/m/Y
                                                    H:i') }}
                                                </td>
                                                <td>
                                                    <strong>{{ $abastecimento->veiculoInfo->codigo ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $abastecimento->veiculoInfo->modelo ??
                                                        '' }}</small>
                                                </td>
                                                <td>{{ $abastecimento->fornecedorInfo->nome ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ $abastecimento->tipo_combustivel }}
                                                    </span>
                                                </td>
                                                <td>{{ number_format($abastecimento->litros, 2, ',', '.') }} L</td>
                                                <td>R$ {{ number_format($abastecimento->qtda, 3, ',', '.') }}</td>
                                                <td>
                                                    <strong class="text-success">R$
                                                        {{ number_format($abastecimento->totala, 2, ',', '.')
                                                        }}</strong>
                                                </td>
                                                <td>
                                                    @if ($abastecimento->km)
                                                    {{ number_format($abastecimento->km, 0, ',', '.') }} km
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('abastecimentos.show', $abastecimento->id) }}"
                                                        class="btn btn-sm btn-info rounded-pill" title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('abastecimentos.edit', $abastecimento->id) }}"
                                                        class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('abastecimentos.destroy', $abastecimento->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                            title="Excluir"
                                                            onclick="return confirm('Tem certeza que deseja excluir este abastecimento?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $abastecimentos->links() }}
                            </div>
                        </div>
                    </div><!-- timeline- -->
                </div><!-- group -->
            </div><!-- card -->
        </div><!-- ol lg-->
    </div><!-- timeline-p5 -->
</div>
</div>
<script>
    /* When the user clicks on the button,
                                                                                                                                                                                                                                                                                                                                                            toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
</script>
@endsection