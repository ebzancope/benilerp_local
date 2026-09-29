<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta name="author" content="Ebzancope">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Cobranças - {{ config('app.name', 'Laravel') }}</title>
    @include('scripts')
    @php
    // Configurações de data e hora para português do Brasil
    setlocale(LC_TIME, 'pt_BR.UTF-8');
    date_default_timezone_set('America/Sao_Paulo');
    @endphp
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

            body,
            html {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
            }

            .no-print {
                display: none !important;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px 8px;
            font-size: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #dcecd3;
            color: #30a300;
            text-align: left;
        }

        .totals {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
        }

        .header-row {
            margin-bottom: 12px;
        }

        .brand {
            background-color: #dcecd3;
            color: #30a300;
            padding: 10px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand img {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container" style="padding: 10px 0 0 0;">
        <div class="brand">
            <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Logo" width="160">
            <div>
                <div style="font-size: 16px; font-weight: bold; color:#141513;">Relatório de Cobranças</div>
                <div style="font-size: 12px; color:#475147;">Gerado em {{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <div style="margin-left:auto; text-align:right; color:#475147;">
                <div style="font-size: 18px; font-weight: bold;">Total Recebido</div>
                <div style="font-size: 16px;">R$ {{ number_format($totalRecebido,2,',','.') }}</div>
            </div>
        </div>
        <div style="margin-top: 12px;">
            <table>
                <thead>
                    <tr>
                        <th style="width:10%;">Pagamento</th>
                        <th style="width:20%;">Cliente</th>
                        <th style="width:35%;">Observação</th>
                        <th style="width:10%;">Pagamento</th>
                        <th style="width:5%; text-align:center;">Status</th>
                        <th style="width:10%; text-align:right;">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $contasLegiveis = [
                    'benloca' => 'Benil Locação',
                    'benpavi' => 'Benil Pavimentação',
                    'niltonm' => 'Nilton ME',
                    ];

                    $map = [
                    'a_cobrar' => 'secondary',
                    'cobrado' => 'info',
                    'pago' => 'success',
                    'cancelado' => 'dark',
                    'nilton' => 'warning',
                    'hebert' => 'danger',
                    'cortesia' => 'dark',
                    'outros' => 'primary',
                    ];
                    @endphp

                    @forelse($cobrancas as $cob)
                    @php
                    $color = $map[$cob->status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td>{{ optional($cob->data_vencimento)->format('d/m/Y') }}</td>
                        <td>{{ $cob->cliente->nome ?? 'N/A' }}</td>
                        <td>{{ $cob->observacao ?? 'N/A' }}</td>
                        <td>
                            {{ strtoupper($cob->tipo_pagamento) }}
                            -
                            {{ $contasLegiveis[$cob->contabanc] ?? strtoupper($cob->contabanc) }}
                        </td>
                        <td style="text-align:center; font-weight:bold;">
                            <div class=" text-{{ $color }} ">
                                {{ ucwords(str_replace('_',' ', $cob->status)) }}</div>
                        </td>
                        <td class="text-end">R$ {{ number_format($cob->valor, 2, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma cobrança encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="totals">
                Total: R$ {{ number_format($totalRecebido,2,',','.') }}
            </div>
        </div>
        <div style="margin-top: 20px; font-size:10px; color: gray; text-align:center;">
            <b>InterGestor - Gestão Inteligente de Negócios</b><br>
            www.intergestor.com.br / {{ now()->year }} / ERP v1.0.0
        </div>
    </div>
    <script>
        // Abre a caixa de impressão automaticamente ao carregar
        window.onload = function() { window.print(); }
    </script>
</body>

</html>