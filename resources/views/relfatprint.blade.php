<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta name="author" content="Ebzancope">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('scripts')
    <style>
        /* Reset completo para impressão */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos gerais para a página */
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-family: Arial, sans-serif;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
        }

        /* Configuração para impressão */
        @media print {
            @page {
                size: A4;
                margin: 40px !important;
                padding: 0 !important;
            }

            body,
            html {
                margin: 10 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
            }

            /* Remove qualquer margem/padding dos containers */
            .container {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }

            /* Garante que as tabelas ocupem 100% */
            .table-responsive-md {
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print {
                display: none !important;
            }
        }

        table.c {
            table-layout: auto;
            width: 100%;
        }

        /* Remove margens padrão do Bootstrap */
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .col {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>
</head>
@php
$registros = $registros ?? collect();
$primeiro = $registros->first();
$numcolab = $numcolab ?? 0;
$numequi = $numequi ?? 0;
@endphp


@php
$datainis = $datainis ?? null;
$datafims = $datafims ?? null;

$refTexto = '—';
if ($datainis && $datafims) {
$mesIni = strftime('%B', strtotime($datainis));
$mesFim = strftime('%B', strtotime($datafims));
$anoIni = date('Y', strtotime($datainis));
$anoFim = date('Y', strtotime($datafims));

if ($mesIni === $mesFim && $anoIni === $anoFim) {
// Mesmo mês/ano
$refTexto = "{$mesIni} de {$anoIni}";
} else {
// Intervalo cruzando mês/ano
$refTexto = 'Período: ' . date('d/m/Y', strtotime($datainis)) . ' a ' . date('d/m/Y', strtotime($datafims));
}
}
@endphp


<body>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                &nbsp;
            </div>
            <div class="col">
                &nbsp;
            </div>
            <div class="col">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="container ">
        <div class="row">
            <div class="col"
                style="border-radius: 10px 0px 0px 10px;background-color: #dcecd3; color: #30a300; padding: 10px 0px 10px 30px;">
                <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Gestão Benil" width="190px"
                    style="padding-right: 10px; border-radius: 10px;" class="rounded float-start">
            </div>

            <div class="col"
                style="border-radius: 0px 10px 10px 0px;background-color: #dcecd3; color: #141513FF;  padding: 10px 0px 10px 0px;  ">
                <p style="font-size: 11px; "><br>
                    <b> Benil - Terraplanagem e Pavimentação </b><br>
                    22.418.881/0001-06 - (37) 3426-2181 <br>
                    Av. Newton Ferreira de Paiva, 514 <br> www.benilterraplanagem.com.br
                </p>

            </div>
            <div class="col" style="border-radius: 10px 10px 10px 10px;background-color: #dcecd3; color: #30a300;  ">
                <p>&nbsp;</p>
                <p style="color: #475147FF;font-size: 22px;text-align: center;">Relatório de faturamento</p>
            </div>
            <div class="col" style="border-radius: 10px 10px 10px 10px;background-color: #dcecd3; color: #30a300; ">
                &nbsp;
                <p style="color: #931414;font-size: 22px;text-align: center;">
                    @if($numcolab > 0)
                    Operador<br>
                    {{ $primeiro->nomeclie ?? '—' }}
                    @elseif($numequi > 0)
                    Equipamento<br>
                    {{ $primeiro->modelo ?? '—' }}{{ isset($primeiro->codigo) ? ' - ' . $primeiro->codigo : '' }}
                    @else
            Todos os <br> equipamentos.
                    @endif
                </p>
            </div>
        </div>
        <hr>
    </div>
    <div class="container ">
        <table class="c  table-striped">
            <thead>
                <tr>
                    <th scope="col order-6"
                        style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                        &nbsp; Referência: {{ $refTexto }}</th>
                    <th class="wd-20p" style="background-color: #dcecd3; color: #30a300;"> &nbsp;</th>
                    <th class="wd-20p" style="background-color: #dcecd3; color: #30a300;"> &nbsp;</th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                </tr>
            </thead>
        </table>
        <hr>
    </div>
    <div class="container ">
        <div class="table-responsive-md">
            <div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
                {{-- Bloco MÁQUINAS (código >= 300) --}}
                @if($maquinas->isNotEmpty())
                <p style="color:#475147"> &nbsp; Máquinas</p>
                <table class="c table-striped">
                    <thead>
                        <tr>
                            <th class="wd-09p" class="wd-9p" scope="col order-6"
                                style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;font-size: 12px;!important">
                                &nbsp;&nbsp; Item - Data
                            </th>
                            <th class="wd-09p" scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                Fatura - Equip
                            </th>
                            <th class="wd-30p" scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                Cliente / Descrição</th>
                            <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                H. inicial</th>
                            <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                H. final</th>
                            <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                Horas </th>
                            <th class="wd-10p" scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                Valor</th>
                            <th class="wd-15p" scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                Operador</th>
                            <th class="wd-10p" scope="col"
                                style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end;font-size: 12px;">
                                Subtotal &nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maquinas as $linha)
                        <tr>
                            <td class="tx-left " style="font-size: 10px;">&nbsp;&nbsp;{{
                                sprintf('%02d',$loop->iteration) }} - {{
                                date('d/m', strtotime($linha->datacadfat)) }}</td>
                            <td class="tx-left " style="font-size: 10px;">{{ $linha->numnota }} - {{ $linha->codigo
                                }}
                                @if($maquinas->where('numnota',$linha->numnota)->count()>1)<span
                                    style="color:#c00;font-weight:bold;">*</span>@endif</td>
                            <td class="tx-left " style="font-size: 10px;">{{ $linha->nome }} / {{ $linha->descri }}</td>
                            <td class="tx-left " style="font-size: 10px;">{{ $linha->horimini }}</td>
                            <td class="tx-left " style="font-size: 10px;">{{ $linha->horimfim }}</td>
                            <td class="tx-left " style="font-size: 10px;">{{ $linha->tothmaquina }} h</td>
                            <td class="tx-left " style="font-size: 10px;">R$ {{ number_format($linha->valhora,2,',','.')
                                }}</td>
                            <td class="tx-left " style="font-size: 10px;">{{ $linha->nomeclie }}
                            </td>
                            <td class="tx-left " style="font-size: 10px; text-align:end;">R$ {{
                                number_format($linha->totmaquina,2,',','.') }} &nbsp;&nbsp;</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" style="text-align:end;">T. Horas: {{ $totais['maquinas']['horas'] }} h</td>
                            <td colspan="3" style="text-align:end; ">Subtotal: R$ {{
                                number_format($totais['maquinas']['valor'],2,',','.') }}&nbsp;&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                {{-- Bloco CAMINHÕES (código <= 299) --}} @if($caminhoes->isNotEmpty())
                    <p style="color:#475147;margin-top:24px;"> &nbsp; Caminhões</p>
                    <table class="c table-striped">
                        <thead>
                            <tr>
                                <th scope="col"
                                    style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300; font-size: 12px;!important">
                                    &nbsp;&nbsp; Item - Data
                                </th>
                                <th class="wd-09p" scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                    Fatura - Equip
                                </th>
                                <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                    Cliente / Descrição</th>
                                <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                    Valor </th>
                                <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                    Quantidade </th>
                                <th scope="col" style="background-color: #dcecd3; color: #30a300;font-size: 12px;">
                                    Operador</th>
                                <th cope="col"
                                    style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end;font-size: 12px;">
                                    Subtotal &nbsp;&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($caminhoes as $linha)
                            <tr>
                                <td class="tx-left " style="font-size: 10px;"> &nbsp;&nbsp; {{
                                    sprintf('%02d',$loop->iteration) }} -
                                    {{ date('d/m',
                                    strtotime($linha->datacadfat)) }}</td>
                                <td class="tx-left " style="font-size: 10px;">{{ $linha->numnota }} - {{ $linha->codigo
                                    }}
                                    @if($caminhoes->where('numnota',$linha->numnota)->count()>1)<span
                                        style="color:#c00;font-weight:bold;">*</span>@endif</td>
                                <td class="tx-left " style="font-size: 10px;">{{ $linha->nome }} / {{ $linha->descri }}
                                </td>
                                <td class="tx-left " style="font-size: 10px;">R$ {{
                                    number_format($linha->valora,2,',','.') }}</td>
                                <td class="tx-left " style="font-size: 10px;">{{ $linha->qtda }}</td>
                                <td class="tx-left " style="font-size: 10px;">{{ $linha->nomeclie }} </td>
                                <td class="tx-left " style="font-size: 10px;text-align:end;">R$ {{
                                    number_format($linha->totala,2,',','.') }}&nbsp;&nbsp;</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align:end;"> &nbsp;&nbsp; </td>
                                <td colspan="3" style="text-align:end;">Subtotal: R$ {{
                                    number_format($totais['caminhoes']['valor'],2,',','.') }}&nbsp;&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif

                    {{-- Total geral quando existem os dois blocos --}}
                    @if($maquinas->isNotEmpty() && $caminhoes->isNotEmpty())
                    <p style="text-align:right;font-size:18px;margin-top:12px; color: #30a300;">
                        Total: R$ {{ number_format($totais['geral'], 2, ',', '.') }} &nbsp;&nbsp;
                    </p>
                    @endif
            </div>
        </div>
        <hr>
        <p style="font-size: 10px; font-weight:light;color: gray;"><br>
            <b> InterGestor - Gestão Inteligente de Negócios </b><br>
            www.intergestor.com.br / {{ now()->year }} / ERP v1.0.0
        </p>
    </div>
</body>

</html>
