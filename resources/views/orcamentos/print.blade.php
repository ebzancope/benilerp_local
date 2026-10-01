<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta name="author" content="Ebzancope">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $orcamento->numero }} - {{ config('app.name', 'Laravel') }}</title>
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
                <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Gestão Benil" width="200px"
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
                <p style="color: #475147FF;font-size: 22px;text-align: center;">Cliente
                </p>
                <p style="color: #475147FF;font-size: 15px;text-align: center;">
                    {{ $orcamento->cliente->nome ?? 'N/A' }}
                </p>
            </div>
            <div class="col" style="border-radius: 10px 10px 10px 10px;background-color: #dcecd3; color: #30a300; ">
                <p>&nbsp;</p>
                <p style="color: #931414;font-size: 22px;text-align: center;">
                    {{ $orcamento->numero }}
                </p>
            </div>
        </div>
        <hr>
    </div>
    <div class="container ">
        <div class="section" style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
            <table>
                <tr>

                    <th style="font-size: 12px;"> &nbsp;Cliente:</th>
                    <td style="font-size: 12px;">&nbsp;{{ $orcamento->cliente->nome ?? 'N/A' }}</td>
                    <th style="font-size: 12px;">&nbsp;&nbsp;&nbsp;Tel:</th>
                    <td style="font-size: 12px;">&nbsp;{{
                        $orcamento->cliente->celular ?? 'N/A' }} </td>
                </tr>
                <tr>
                    <th style="font-size: 12px;">&nbsp;CPF:</th>
                    <td style="font-size: 12px;">&nbsp;{{ $orcamento->cliente->cpfj ?? '' }}</td>
                    <th style="font-size: 12px;">&nbsp;&nbsp;&nbsp;Data</th>
                    <td style="font-size: 12px;">&nbsp;{{ optional($orcamento->data_emissao)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th style="font-size: 12px;">&nbsp;Local:</th>
                    <td style="font-size: 12px;">&nbsp;{{ $orcamento->local ?? '' }}</td>
                    <th style="font-size: 12px;">&nbsp;&nbsp;&nbsp;Obs:</th>
                    <td style="font-size: 12px;">&nbsp;Orçamento válido por 30 dias</td>
                </tr>
            </table>
        </div>
        <div class="table-responsive-md">
            <div>
                <hr>
                <p style="color:#475147">Serviços</p>
                <table class="c table-striped">
                    <thead>
                        <tr style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;!important">
                            <th>Item</th>
                            <th>Tipo</th>
                            <th>{{ $orcamento->titulo }}</th>
                            <th class="text-right">Unid.</th>
                            <th class="text-right">Quant.</th>
                            <th class="text-right">Valor Uni.</th>
                            <th class="text-right">&nbsp;</th>
                            <th class="text-right">&nbsp;</th>
                            <th class="text-right">Total:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orcamento->itens as $it)
                        <tr>
                            <td style="font-size: 12px;width:5%;">&nbsp;{{ $loop->iteration }}</td>
                            <td style="font-size: 12px;width:10%;">{{ $it->tipo_item }}</td>
                            <td style="font-size: 12px;">{{ $it->descricao }}</td>
                            <td class="text-right" style="font-size: 12px;">{{ $it->unidade }}</td>
                            <td class="text-right" style="font-size: 12px;">{{
                                number_format($it->quantidade,2,',','.')
                                }}</td>
                            <td class="text-right" style="font-size: 12px;">R$ {{
                                number_format($it->preco_unitario,2,',','.') }}</td>
                            <td class="text-right" style="font-size: 12px;">&nbsp;</td>
                            <td class="text-right" style="font-size: 12px;">&nbsp;</td>
                            <td class="text-right" style="font-size: 12px;">R$ {{
                                number_format($it->total_item,2,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SEÇÃO: DESPESAS DA OBRA -->
            @if($orcamento->despesas->count() > 0)
            <div style="margin-top: 20px;">
                <hr>
                <p style="color:#8b0000; font-weight: bold;">Despesas da Obra</p>
                <table class="c table-striped">
                    <thead>
                        <tr style="background-color: #ffebee;color: #b71c1c; border-bottom: 2px solid #b71c1c;">
                            <th style="font-size: 12px;">Item</th>
                            <th style="font-size: 12px;">Tipo</th>
                            <th style="font-size: 12px;">Descrição</th>
                            <th class="text-right" style="font-size: 12px;">Qtd</th>
                            <th class="text-right" style="font-size: 12px;">Unid.</th>
                            <th class="text-right" style="font-size: 12px;">Valor Uni.</th>
                            <th class="text-right" style="font-size: 12px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orcamento->despesas as $d)
                        <tr>
                            <td style="font-size: 12px;">{{ $loop->iteration }}</td>
                            <td style="font-size: 12px;">{{ $d->tipo }}</td>
                            <td style="font-size: 12px;">{{ $d->descricao }}</td>
                            <td class="text-right" style="font-size: 12px;">{{ number_format($d->quantidade,2,',','.') }}</td>
                            <td class="text-right" style="font-size: 12px;">{{ $d->unidade }}</td>
                            <td class="text-right" style="font-size: 12px;">R$ {{ number_format($d->custo_unitario,2,',','.') }}</td>
                            <td class="text-right" style="font-size: 12px; font-weight: bold;">R$ {{ number_format($d->total,2,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- RESUMO FINANCEIRO -->
            @php
                $totalItens = $orcamento->itens->sum('total_item');
                $totalDespesas = $orcamento->despesas->sum('total');
                $desconto = $orcamento->desconto_total ?? 0;
                $resultado = $totalItens - $totalDespesas - $desconto;
            @endphp

            <div style="margin-top: 20px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; font-size: 12px;">&nbsp;</td>
                        <td style="width: 50%; text-align: right;">
                            @if($desconto > 0)
                            <div style="font-size: 15px; color: rgb(90, 86, 86); margin-bottom: 10px;">
                                Desconto: R$ {{ number_format($desconto,2,',','.') }}
                            </div>
                            @endif
                            @if($totalDespesas > 0)
                            <div style="font-size: 15px; color: #b71c1c; margin-bottom: 10px;">
                                Despesas da obra: R$ {{ number_format($totalDespesas,2,',','.') }}
                            </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- TOTAL E RESULTADO -->
            <h5 style="border-radius: 10px 10px 10px 10px;text-align:right; margin-top:12px;background-color: #eaf4e5; color: rgb(90, 86, 86);padding: 10px;">
                <strong>Total Faturamento: R$ {{ number_format($totalItens,2,',','.') }}</strong>
            </h5>
            <h5 style="border-radius: 10px 10px 10px 10px;text-align:right; margin-top:8px;background-color: {{ $resultado >= 0 ? '#e8f5e9' : '#ffebee' }}; color: {{ $resultado >= 0 ? '#1b5e20' : '#b71c1c' }};padding: 10px;">
                <strong>Lucro / Prejuízo: R$ {{ number_format($resultado,2,',','.') }}</strong>
            </h5>
        </div>
        @if($orcamento->condicoes_pagamento != '')
        <table>
            <tr>
                <th style="font-size: 12px;">Observações: </th>
                <td colspan="3" style="font-size: 12px;">&nbsp;{{ $orcamento->condicoes_pagamento }}</td>
            </tr>
        </table>
        @endif
        </br>
        </br>
        </br>
        <table>
            <tr>
                <th style="font-size: 12px;">
                    <table>
                        <tr>
                            <th style="font-size: 12px;">_________________________________</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                            <th style="font-size: 12px;">&nbsp;</th>
                            <th style="font-size: 12px;">&nbsp;</th>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <th style="font-size: 12px;">Hebert Rocha</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                            <th style="font-size: 12px;">&nbsp;</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <th style="font-size: 10px;">Benil - Terraplanagem e Pavimentação</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                            <th style="font-size: 12px;">&nbsp;</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                        </tr>
                    </table>
                </th>
                <td style="font-size: 12px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <td style="font-size: 12px;">&nbsp;</td>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <td style="font-size: 12px;">&nbsp;</td>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <td style="font-size: 12px;">&nbsp;</td>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <td style="font-size: 12px;">&nbsp;</td>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <td style="font-size: 12px;">&nbsp;</td>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">&nbsp;</th>
                <th style="font-size: 12px;">
                    <table>
                        <tr>
                            <th style="font-size: 12px;">_________________________________</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                            <th style="font-size: 12px;">&nbsp;</th>
                            <th style="font-size: 12px;">&nbsp;</th>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <th style="font-size: 12px;">{{ $orcamento->cliente->nome ?? 'N/A' }}</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                            <th style="font-size: 12px;">&nbsp;</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <th style="font-size: 10px;">{{ $orcamento->local ?? '' }}</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                            <th style="font-size: 12px;">&nbsp;</th>
                            <td style="font-size: 12px;">&nbsp;</td>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>
        <hr>
        <p style="font-size: 10px; font-weight:light;color: gray;"><br>
            <b> InterGestor - Gestão Inteligente de Negócios </b><br>
            www.intergestor.com.br / {{ now()->year }} / ERP v1.0.0
        </p>
    </div>
    <script>
        // Abre a caixa de impressão automaticamente ao carregar
        window.onload = function() { window.print(); }
    </script>
</body>

</html>
