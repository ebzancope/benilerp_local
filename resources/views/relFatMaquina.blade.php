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
                                <label class="section-title fst-italic " style="color: #30a300; ">
                                    <i class="fa-solid fa-money-check-dollar"></i> Relatório de Faturamento :
                                    {{ $faturasrgeraltop->codigo ?? '' }} / {{ $faturasrgeraltop->modelo ?? '' }} -
                                    {{ strftime('%B', strtotime($faturasrgeraltop->datacadfat ?? '')) }} de
                                    {{ date('Y', strtotime($faturasrgeraltop->datacadfat ?? '')) }}
                                </label>
                                <hr class="my-2">
                                <div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
                                    <div class="col-lg-12" style="text-align: right">


                                        <form action="{{ route('fatprint') }}" method="post" name="print_relatorio">
                                            @csrf
                                            <input type="hidden" name="tex_equipamento"
                                                value="{{ $faturasrgeraltop->codigo ?? '' }}">
                                            <input type="hidden" name="tex_dataini" value="{{ $datainis ?? '' }}">
                                            <input type="hidden" name="tex_datafim" value="{{ $datafims ?? '' }}">




                                            <button class="btn btn-secondary  b d-0 rounded-pill" style=" float: right;"
                                                type="submit"> <i class="fa-solid fa-eye"></i> &nbsp;<i
                                                    class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp; <i
                                                    class="fa-solid fa-print"></i>
                                                &nbsp;
                                                Gerar
                                                &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                                            </button>

                                        </form>




                                    </div>
                                    <table class="table table-hover  ">
                                        <thead>
                                            @if ($faturasrgeraltop->codigo ?? '' >= '300')
                                                <tr>
                                                    <th scope="col order-6"
                                                        style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                                                        Item - Data
                                                    </th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Cliente / Descrição</th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Horímetro Inicial</th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Horímetro Final</th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Total de Horas </th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Valor da hora </th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Operador</th>
                                                    <th
                                                        style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end">
                                                        Subtotal</th>
                                                </tr>
                                            @else
                                                <tr>
                                                    <th scope="col order-6"
                                                        style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                                                        Item - Data
                                                    </th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Cliente / Descrição</th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Valor </th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Quantidade </th>
                                                    <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                                                        Operador</th>
                                                    <th
                                                        style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end">
                                                        Subtotal</th>
                                                </tr>
                                            @endif
                                        </thead>
                                        @if ($faturasrgeraltop->codigo ?? '' >= '300')
                                            @forelse ($faturasrgeral as $faturasrgerals)
                                                <tr> <!-- maquinas -->
                                                    <td> {{ ++$i . ' - ' . date('d/m', strtotime($faturasrgerals->datacadfat)) }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->nome }} / {{ $faturasrgerals->descri }}
                                                    </td>
                                                    <td>{{ $faturasrgerals->horimini }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->horimfim }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->tothmaquina }} h
                                                    </td>
                                                    <td> R$ {{ number_format($faturasrgerals->valhora, 2, ',', '.') }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->nomeclie }}
                                                    </td>
                                                    <td style="text-align: end">
                                                        R$ {{ number_format($faturasrgerals->totmaquina, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">Sem dados.</td>
                                                </tr>
                                            @endforelse
                                            <tr>
                                                <td colspan="8" style="text-align: end">
                                                    <p style="font-size: 22px;">
                                                        Total: R$ {{ number_format($totala + $totalMaquina, 2, ',', '.') }}
                                                    </P>
                                                </td>
                                            </tr>
                                        @else
                                            @forelse ($faturasrgeral as $faturasrgerals)
                                                <tr><!-- caminhões -->
                                                    <td> {{ ++$i . ' - ' . date('d/m', strtotime($faturasrgerals->datacadfat)) }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->nome }} / {{ $faturasrgerals->descri }}
                                                    </td>
                                                    <td> R$ {{ number_format($faturasrgerals->valora, 2, ',', '.') }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->qtda }}
                                                    </td>
                                                    <td> {{ $faturasrgerals->nomeclie }}
                                                    </td>
                                                    <td style="text-align: end">
                                                        R$ {{ number_format($faturasrgerals->totala, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">Sem dados.</td>
                                                </tr>
                                            @endforelse
                                            <tr>
                                                <td colspan="6" style="text-align: end">
                                                    <p style="font-size: 22px;">
                                                        Total: R$ {{ number_format($totala + $totalMaquina, 2, ',', '.') }}
                                                    </P>
                                                </td>
                                                </td>
                                            </tr>
                                        @endif
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- import- -->
                        </div><!-- timeline- -->
                    </div><!-- group -->
                </div><!-- card -->
            </div><!-- ol lg-->
        </div><!-- timeline-p5 -->
    </div>
    </div>
@endsection
