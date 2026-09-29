<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $orcamento->numero }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
        }

        .header {
            border-bottom: 3px solid #30a300;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .company-info {
            text-align: center;
            font-size: 10px;
            line-height: 1.4;
        }

        .doc-title {
            background: #dcecd3;
            color: #30a300;
            text-align: center;
            padding: 8px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            margin: 15px 0;
        }

        .info-section {
            margin: 15px 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .info-table td {
            padding: 5px 8px;
            border: 1px solid #ddd;
        }

        .info-table td.label {
            background: #f5f5f5;
            font-weight: bold;
            width: 25%;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .items-table th {
            background: #dcecd3;
            color: #30a300;
            padding: 8px 5px;
            border: 1px solid #ccc;
            font-size: 10px;
            text-align: left;
        }

        .items-table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-section {
            margin-top: 15px;
            text-align: right;
        }

        .total-row {
            display: inline-block;
            width: 300px;
            text-align: right;
        }

        .total-label {
            font-weight: bold;
            padding: 5px 10px;
        }

        .total-value {
            background: #dcecd3;
            color: #30a300;
            font-size: 14px;
            font-weight: bold;
            padding: 8px 10px;
            border-radius: 3px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .obs-section {
            margin: 15px 0;
            padding: 10px;
            background: #f9f9f9;
            border-left: 3px solid #30a300;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('assets/img/Logo_benil_11-2025.png') }}" alt="Logo" style="max-height: 60px;">
        </div>
        <div class="company-info">
            <strong>Benil - Terraplanagem e Pavimentação</strong><br>
            22.418.881/0001-06 - (37) 3426-2181<br>
            Av. Newton Ferreira de Paiva, 514<br>
            www.benilterraplanagem.com.br
        </div>
    </div>

    <div class="doc-title">
        ORÇAMENTO {{ $orcamento->numero }}
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Cliente:</td>
                <td>{{ $orcamento->cliente->nome ?? 'N/A' }}</td>
                <td class="label">Status:</td>
                <td>{{ ucfirst($orcamento->status) }}</td>
            </tr>
            <tr>
                <td class="label">Emissão:</td>
                <td>{{ optional($orcamento->data_emissao)->format('d/m/Y') }}</td>
                <td class="label">Validade:</td>
                <td>{{ optional($orcamento->data_validade)->format('d/m/Y') }}</td>
            </tr>
            @if($orcamento->prazo_execucao)
            <tr>
                <td class="label">Prazo de execução:</td>
                <td colspan="3">{{ $orcamento->prazo_execucao }}</td>
            </tr>
            @endif
            @if($orcamento->condicoes_pagamento)
            <tr>
                <td class="label">Condições de pagamento:</td>
                <td colspan="3">{{ $orcamento->condicoes_pagamento }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($orcamento->titulo)
    <h3 style="color: #30a300; margin: 15px 0 10px 0;">{{ $orcamento->titulo }}</h3>
    @endif

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">Item</th>
                <th style="width: 12%;">Tipo</th>
                <th style="width: 35%;">Descrição</th>
                <th class="text-center" style="width: 8%;">Unid.</th>
                <th class="text-right" style="width: 10%;">Quant.</th>
                <th class="text-right" style="width: 12%;">Valor Uni.</th>
                <th class="text-right" style="width: 8%;">Desc %</th>
                <th class="text-right" style="width: 10%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orcamento->itens as $it)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $it->tipo_item }}</td>
                <td>{{ $it->descricao }}</td>
                <td class="text-center">{{ $it->unidade }}</td>
                <td class="text-right">{{ number_format($it->quantidade, 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($it->preco_unitario, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($it->desconto_percentual, 2, ',', '.') }}%</td>
                <td class="text-right">R$ {{ number_format($it->total_item, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        @if($orcamento->desconto_total > 0)
        <div class="total-row">
            <span class="total-label">Desconto geral:</span>
            <span style="color: #c00;">R$ {{ number_format($orcamento->desconto_total, 2, ',', '.') }}</span>
        </div>
        <br>
        @endif
        <div class="total-row">
            <span class="total-label">VALOR TOTAL:</span>
            <span class="total-value">R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</span>
        </div>
    </div>

    @if($orcamento->descricao)
    <div class="obs-section">
        <strong>Observações / Escopo:</strong><br>
        {{ $orcamento->descricao }}
    </div>
    @endif

    <div class="footer">
        <strong>Intelisoft® - Gestão Inteligente de Negócios</strong><br>
        www.intergestor.com.br / {{ now()->year }} / ERP v1.0.0<br>
        Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>