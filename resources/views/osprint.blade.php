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


<body>
    <!-- Seu conteúdo atual aqui -->
    <div class="container ">
        <div class="row">
            <div class="col"
                style="border-radius: 10px 0px 0px 10px;background-color: #dcecd3; color: #30a300; padding: 10px 0px 10px 30px;">
                <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Gestão Benil" width="190px"
                    style="padding-right: 10px; border-radius: 10px;" class="rounded float-start">
            </div>

            <div class="col"
                style="border-radius: 0px 10px 10px 0px;background-color: #dcecd3; color: #141513FF;  padding: 10px 0px 10px 0px;  ">
                <p style="font-size: 11px; font-weight:bold;"><br>
                    <b> Benil - Terraplanagem e Pavimentação </b><br>
                    22.418.881/0001-06 - (37) 3426-2181 <br>
                    Av. Newton Ferreira de Paiva, 514 <br> www.benilterraplanagem.com.br
                </p>

            </div>
            <div class="col" style="border-radius: 10px 10px 10px 10px;background-color: #dcecd3; color: #30a300;  ">
                &nbsp;
                <p style="color: #475147FF;font-size: 22px;text-align: center;">Fechamento de Serviços</p>
            </div>
            <div class="col " style="border-radius: 10px 10px 10px 10px;background-color: #dcecd3; color: #30a300; ">
                &nbsp;
                <p style="color: #931414;font-size: 22px;text-align: center; font-weight:bold;"> OS nº 00{{
                    $oservicos->idnumos }}
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
                        &nbsp; Cliente</th>
                    <th class="wd-20p" style="background-color: #dcecd3; color: #30a300;"> &nbsp;</th>
                    <th class="wd-20p" style="background-color: #dcecd3; color: #30a300;"> &nbsp;</th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                </tr>
            </thead>


            <tbody>
                <tr style="height: 2px; border: 1px solid rgb(230, 224, 224);">
                    <td class="tx-left " style="font-size: 14px;">
                        &nbsp; {{ $cliefornes->nome }} ({{ $cliefornes->apelido }}) - Fone: {{ $cliefornes->fone }}
                        / ({{ $cliefornes->celular }})
                    </td>
                    <td class="tx-left" style="font-size: 12px;">
                        &nbsp;
                    </td>
                    <td class="tx-left" style="font-size: 12px;">
                        &nbsp;
                    </td>
                    <td class="tx-left" style="font-size: 12px;">
                        &nbsp;
                    </td>

                </tr>
            </tbody>
            <thead>
                <tr>
                    <th scope="col order-6"
                        style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                        &nbsp; Descrição</th>
                    <th class="wd-20p" style="background-color: #dcecd3; color: #30a300;"> &nbsp;</th>
                    <th class="wd-20p" style="background-color: #dcecd3; color: #30a300;"> &nbsp;</th>
                    <th class="tx-left" style="background-color: #dcecd3; color: #30a300;"> &nbsp; </th>
                    <th class="tx-right" style="background-color: #dcecd3; color: #30a300;">Emissão</th>
                    <th class="tx-right"
                        style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end">
                        Vencimento &nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 2px; border: 1px solid rgb(230, 224, 224);">
                    <td class="tx-left " style="font-size: 14px;">
                        &nbsp; {{ $oservicos->numos_descricao }} - {{ $oservicos->cnpj }}
                    </td>
                    <td class="tx-left" style="font-size: 12px;">
                        &nbsp;
                    </td>
                    <td class="tx-left" style="font-size: 12px;">
                        &nbsp;
                    </td>
                    <td class="tx-left" style="font-size: 12px;">
                        &nbsp;
                    </td>
                    <td class="tx-right" style="font-size: 12px;">
                        {{ date('d/m/Y', strtotime($oservicos->dataoscli)) }}
                    </td>
                    <td class="tx-right" style="font-size: 12px;">
                        {{ date('d/m/Y', strtotime($oservicos->dataoscli . ' + 10 day')) }} &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
    </div>
    <div class="container ">
        <div class="table-responsive-md">
            <div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
                <table class="c  table-striped">
                    <thead>
                        <tr>
                            <th class="wd-12p" scope="col order-6"
                                style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                                &nbsp; Item - Data</th>
                            <th class="wd-14p" style="background-color: #dcecd3; color: #30a300;">Fatura
                            </th>
                            <th class="wd-16p" style="background-color: #dcecd3; color: #30a300;">Equipamento </th>
                            <th class="wd-14p" style="background-color: #dcecd3; color: #30a300;">Qtd</th>
                            <th class="wd-25p tx-left" style="background-color: #dcecd3; color: #30a300;">Descrição
                            </th>
                            <th class="tx-right" style="background-color: #dcecd3; color: #30a300;">V.Unitário</th>
                            <th class="tx-right"
                                style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end">
                                Subtotal &nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($faturasrgeral as $faturasrgerals)
                        <tr style="height: 2px; border: 1px solid rgb(230, 224, 224);">
                            <td class="tx-left " style="font-size: 12px;">
                                &nbsp;
                                {{ sprintf('%02d', ++$i) }} -
                                {{ date('d/m/Y', strtotime($faturasrgerals->datacadfat)) }}
                            </td>
                            <td class="tx-left" style="font-size: 12px;">
                                {{ $faturasrgerals->numnota }}
                            </td>

                            <td class="tx-left" style="font-size: 12px;">
                                {{ $faturasrgerals->codigo }} -
                                {{ $faturasrgerals->modelo }}
                            </td>
                            <td class="tx-left" style="font-size: 12px;">
                                @php
                                // Código para comparação correta
                                $codigo = $faturasrgerals->codigo;
                                $isMaquina = $codigo >= 300;
                                $isCaminhao = $codigo <= 299; @endphp @if ($isCaminhao) {{ sprintf('%02d',
                                    $faturasrgerals->qtda) }}
                                    @elseif ($isMaquina)
                                    {{ $faturasrgerals->tothmaquina }}&nbsp;h
                                    @endif
                            </td>
                            <td class="tx-left" style="font-size: 12px;">
                                {{ $faturasrgerals->servicos }}.
                            </td>
                            <td class="tx-right" style="font-size: 12px;">
                                @if ($faturasrgerals->valhora > '0')
                                R$
                                {{ number_format($faturasrgerals->valhora, 2, ',', '.') }}&nbsp;
                                @endif
                                @if ($faturasrgerals->valora > '0')
                                R$
                                {{ number_format($faturasrgerals->valora, 2, ',', '.') }}&nbsp;
                                @endif
                            </td>
                            <td class="tx-right" style="font-size: 12px;">
                                @if ($faturasrgerals->totmaquina > '0')
                                R$
                                {{ number_format($faturasrgerals->totmaquina, 2, ',', '.') }}&nbsp;
                                @endif
                                @if ($faturasrgerals->totala > '0')
                                R$
                                {{ number_format($faturasrgerals->totala, 2, ',', '.') }}&nbsp;
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">Sem dados.</td>
                        </tr>
                        @endforelse
                        <tr>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                        </tr>
                        @foreach ($totaisPorMaquina as $maquina)
                        @if ($maquina->total_maquina > '0')
                        <tr>
                            <td colspan="2" class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right" style="font-size: 12px;">Máquina: {{ $maquina->modelo }}
                            </td>
                            <td class="tx-right" style="font-size: 12px;">Total:
                                {{ number_format($maquina->total_maquina, 2, ',', '.') }} h &nbsp;&nbsp;</td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                            <td class="tx-right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="tx-right">
                                <p
                                    style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;text-align: end;font-size: 20px;">
                                    Total:&nbsp;&nbsp;</p>
                                <h4 class='tx-primary tx-bold tx-lato'> R$
                                    {{ number_format($totala + $totalMaquina, 2, ',', '.') }} &nbsp;&nbsp;
                                </h4>
                            </td>
                        </tr>
                    </tbody>

                </table>
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