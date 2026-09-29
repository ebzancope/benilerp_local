<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta name="author" content="Ebzancope">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas - {{ config('app.name', 'Laravel') }}</title>
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

        .filters {
            margin-top: 10px;
            padding: 8px;
            border-left: 4px solid #30a300;
            background: #f6faf4;
            font-size: 11px;
        }

        .filters div {
            margin-bottom: 2px;
            color: #475147;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            background: #30a300;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container" style="padding: 10px 0 0 0;">
        <div class="brand">
            <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Logo" width="160">
            <div>
                <div style="font-size: 16px; font-weight: bold; color:#141513;">Relatório de Despesas</div>
                <div style="font-size: 12px; color:#475147;">
                    Gerado em {{ now()->format('d/m/Y H:i') }}
                    @if(!empty($dataInicioFormatada) && !empty($dataFimFormatada))
                    | Período: {{ $dataInicioFormatada }} a {{ $dataFimFormatada }}
                    @endif
                </div>
            </div>
            <div style="margin-left:auto; text-align:right; color:#475147;">
                <div style="font-size: 18px; font-weight: bold;">Total</div>
                <div style="font-size: 16px;">R$ {{ number_format($totalGeral ?? 0,2,',','.') }}</div>
            </div>
        </div>

        {{-- Filtros aplicados --}}
        @if(!empty($filtrosAplicados) && count($filtrosAplicados) > 0)
        <div class="filters">
            <strong style="color:#30a300;">Filtros aplicados:</strong>
            @foreach($filtrosAplicados as $label => $valor)
            <div>{{ $label }}: <strong>{{ $valor }}</strong></div>
            @endforeach
        </div>
        @endif

        <div style="margin-top: 12px;">
            <table>
                <thead>
                    <tr>
                        <th style="width:10%;">Data</th>
                        <th style="width:12%;">Tipo de Conta</th>
                        <th style="width:15%;">Fornecedor</th>
                        <th style="width:40%;">Descrição</th>
                        <th>Documento</th>
                        <th style="width:10%; text-align:right;">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($despesas as $despesa)
                    <tr>
                        <td>{{ optional($despesa->competencia)->format('d/m/Y') }}</td>
                        <td>{{ $tiposContas[$despesa->tipoconta] ?? $despesa->tipoconta }}</td>
                        <td>{{ $despesa->clieforne->nome ?? '' }}</td>
                        <td>{{ $despesa->descricao ?? '' }} - {{ $despesa->veiculo_modelo ?? '' }}</td>
                        <td style="text-align:right;">
                            @if($despesa->tipodocumento)
                            <span class="badge">{{ $tiposDocumentos[$despesa->tipodocumento] ?? $despesa->tipodocumento
                                }}</span>
                            @endif
                            @if($despesa->notafiscal)
                            <div style="font-size:11px; color:#475147;">{{ $despesa->notafiscal }}</div>
                            @endif
                        </td>
                        <td style="text-align:right;">R$ {{ number_format((float)$despesa->valortotal,2,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Nenhuma despesa encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="totals">
                Total : R$ {{ number_format($totalGeral ?? 0,2,',','.') }}
                @if(!empty($totalRegistros))
                — Registros: {{ number_format($totalRegistros,0,',','.') }}
                @endif
            </div>
        </div>

        <div style="margin-top: 20px; font-size:10px; color: gray; text-align:center;">
            <b>Intelisoft ® - Gestão Inteligente de Negócios</b><br>
            www.intelisoft.pro / {{ now()->year }} / ERP v1.0.0
        </div>
    </div>

    <script>
        // Abre a caixa de impressão automaticamente ao carregar
        window.onload = function() { window.print(); }
    </script>
</body>

</html>
