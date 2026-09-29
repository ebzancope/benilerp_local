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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-family: Arial, sans-serif;
            background: white !important;
        }

        @media print {
            @page {
                size: A4;
                margin: 40px !important;
            }

            .no-print {
                display: none !important;
            }
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 12px;
        }

        .header {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            align-items: center;
        }

        .logo {
            background: #dcecd3;
            border-radius: 10px 0 0 10px;
            padding: 10px 0 10px 20px;
        }

        .logo img {
            border-radius: 10px;
            max-height: 70px;
        }

        .company {
            background: #dcecd3;
            border-radius: 0;
            padding: 12px;
            color: #141513;
            font-size: 11px;
        }

        .title {
            background: #dcecd3;
            border-radius: 0 10px 10px 0;
            padding: 12px;
            text-align: center;
            color: #475147;
        }

        h2,
        h3,
        h4,
        h5 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background: #dcecd3;
            color: #30a300;
        }

        .text-right {
            text-align: right;
        }

        .mt-2 {
            margin-top: 12px;
        }

        .mb-2 {
            margin-bottom: 12px;
        }

        .section {
            margin-top: 18px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="container">
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
                <p style="color: #475147FF;font-size: 22px;text-align: center;">Orçamento</p>
            </div>
            <div class="col" style="border-radius: 10px 10px 10px 10px;background-color: #dcecd3; color: #30a300; ">
                &nbsp;
                <p style="color: #931414;font-size: 22px;text-align: center;">
                    {{ $orcamento->numero }}
                </p>
            </div>
        </div>
        <hr>

        <div class="section">
            <table>
                <tr>
                    <th style="width: 25%;">Status</th>
                    <td>{{ ucfirst($orcamento->status) }}</td>
                    <th style="width: 25%;">Emissão</th>
                    <td>{{ optional($orcamento->data_emissao)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Validade</th>
                    <td>{{ optional($orcamento->data_validade)->format('d/m/Y') }}</td>
                    <th>Cliente</th>
                    <td>{{ $orcamento->cliente->nome ?? 'N/A' }}</td>
                </tr>
                @if($orcamento->prazo_execucao)
                <tr>
                    <th>Prazo de execução</th>
                    <td colspan="3">{{ $orcamento->prazo_execucao }}</td>
                </tr>
                @endif
                @if($orcamento->condicoes_pagamento)
                <tr>
                    <th>Condições de pagamento</th>
                    <td colspan="3">{{ $orcamento->condicoes_pagamento }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="section">
            <h4 style="color:#475147;">Itens</h4>
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th class="text-right">Qtd</th>
                        <th>Unid</th>
                        <th class="text-right">Preço</th>
                        <th class="text-right">Desc %</th>
                        <th class="text-right">Desc R$</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->itens as $it)
                    <tr>
                        <td style="font-size: 12px;">{{ $it->tipo_item }}</td>
                        <td style="font-size: 12px;">{{ $it->descricao }}</td>
                        <td class="text-right" style="font-size: 12px;">{{ number_format($it->quantidade,3,',','.') }}</td>
                        <td style="font-size: 12px;">{{ $it->unidade }}</td>
                        <td class="text-right" style="font-size: 12px;">R$ {{ number_format($it->preco_unitario,2,',','.') }}</td>
                        <td class="text-right" style="font-size: 12px;">{{ number_format($it->desconto_percentual,2,',','.') }}%</td>
                        <td class="text-right" style="font-size: 12px;">R$ {{ number_format($it->desconto_valor,2,',','.') }}</td>
                        <td class="text-right" style="font-size: 12px;">R$ {{ number_format($it->total_item,2,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h3 style="text-align:right; margin-top:12px;">Total: R$ {{ number_format($orcamento->valor_total,2,',','.')
                }}</h3>
        </div>

        @if($orcamento->descricao)
        <div class="section">
            <h4 style="color:#475147;">Observações / Escopo</h4>
            <p style="margin-top:6px;">{{ $orcamento->descricao }}</p>
        </div>
        @endif

        <div class="section no-print" style="text-align:right; margin-top:16px;">
            <button onclick="window.print()" class="btn btn-secondary">Imprimir</button>
        </div>

        <div style="text-align:center; font-size:10px; color:gray; margin-top:18px;">
            <b>Intelisoft® - Gestão Inteligente de Negócios</b><br>
            www.intergestor.com.br / {{ now()->year }} / ERP v1.0.0
        </div>
    </div>
</body>

</html>
