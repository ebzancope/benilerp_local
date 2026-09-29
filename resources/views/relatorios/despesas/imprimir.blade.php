<! DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Relatório de Despesas - Impressão</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Arial', sans-serif;
                color: #333;
                line-height: 1.6;
                -webkit-print-color-adjust: exact ! important;
                print-color-adjust: exact !important;
                background: white;
            }

            @media print {
                @page {
                    size: A4;
                    margin: 15mm;
                }

                body {
                    margin: 0;
                    padding: 0;
                }

                .no-print {
                    display: none !important;
                }

                table {
                    page-break-inside: avoid;
                }

                tr {
                    page-break-inside: avoid;
                }
            }

            .container {
                max-width: 900px;
                margin: 0 auto;
                padding: 20px;
            }

            /* ===== HEADER ===== */
            .header {
                text-align: center;
                margin-bottom: 25px;
                border-bottom: 3px solid #30a300;
                padding-bottom: 20px;
            }

            .company-logo {
                font-size: 28px;
                font-weight: bold;
                color: #30a300;
                margin-bottom: 8px;
            }

            . company-info {
                font-size: 11px;
                color: #666;
                line-height: 1.4;
            }

            .report-title {
                font-size: 22px;
                font-weight: bold;
                color: #141513;
                margin: 15px 0 5px 0;
            }

            .report-period {
                font-size: 12px;
                color: #666;
                margin-bottom: 10px;
            }

            /* ===== INFO CARDS ===== */
            .info-box {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 12px;
                margin-bottom: 20px;
            }

            .info-card {
                background-color: #eaf4e5;
                border-left: 4px solid #30a300;
                padding: 12px;
                border-radius: 4px;
                font-size: 11px;
            }

            .info-label {
                color: #666;
                margin-bottom: 4px;
                font-weight: bold;
            }

            .info-value {
                font-size: 16px;
                font-weight: bold;
                color: #30a300;
            }

            /* ===== TABELA ===== */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 11px;
            }

            thead {
                background-color: #dcecd3;
                color: #30a300;
            }

            th {
                padding: 10px;
                text-align: left;
                font-weight: bold;
                border-bottom: 2px solid #30a300;
            }

            td {
                padding: 8px 10px;
                border-bottom: 1px solid #e0e0e0;
            }

            tbody tr:nth-child(even) {
                background-color: #f9faf8;
            }

            . text-right {
                text-align: right;
            }

            .text-center {
                text-align: center;
            }

            . total-row {
                background-color: #dcecd3;
                font-weight: bold;
                color: #30a300;
            }

            /* ===== FOOTER ===== */
            . footer {
                text-align: center;
                font-size: 10px;
                color: #999;
                margin-top: 30px;
                padding-top: 15px;
                border-top: 1px solid #ddd;
            }

            . print-date {
                text-align: right;
                font-size: 10px;
                color: #666;
                margin-bottom: 10px;
            }

            /* ===== BOTÕES (NÃO IMPRESSÃO) ===== */
            .button-container {
                text-align: center;
                margin: 30px 0;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
            }

            .btn {
                padding: 12px 24px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 14px;
                font-weight: bold;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }

            .btn-print {
                background-color: #30a300;
                color: white;
            }

            .btn-print:hover {
                background-color: #228b22;
            }

            . btn-back {
                background-color: #6c757d;
                color: white;
            }

            . btn-back:hover {
                background-color: #5a6268;
            }

            /* ===== OBSERVAÇÕES ===== */
            . observations {
                background-color: #f6faf4;
                padding: 12px;
                border-radius: 4px;
                font-size: 10px;
                margin-bottom: 20px;
                border-left: 4px solid #30a300;
            }

            .observations strong {
                color: #30a300;
                display: block;
                margin-bottom: 5px;
            }

            . observations ul {
                margin-left: 20px;
                color: #666;
            }

            .observations li {
                margin-bottom: 3px;
            }

            . badge {
                display: inline-block;
                padding: 3px 8px;
                border-radius: 3px;
                font-size: 10px;
                font-weight: bold;
                background-color: #e9ecef;
                color: #333;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <!-- HEADER -->
            <div class="header">
                <div class="company-logo">💰 RELATÓRIO DE DESPESAS</div>
                <div class="company-info">
                    <strong>Benil - Terraplanagem e Pavimentação</strong><br>
                    CNPJ: 22.418.881/0001-06 | Telefone: (37) 3426-2181<br>
                    Endereço: Av. Newton Ferreira de Paiva, 514 | www.benilterraplanagem.com. br
                </div>
                <div class="report-title">Relatório Detalhado de Despesas</div>
                <div class="report-period">
                    📅 Período: <strong>{{ $dataInicioFormatada ?? date('d/m/Y') }}</strong> até
                    <strong>{{ $dataFimFormatada ?? date('d/m/Y') }}</strong>

                    <!-- ✅ MOSTRAR FILTRO APLICADO -->
                    @if(isset($filtroTipoConta) && $filtroTipoConta !== 'Todos')
                    <br>📌 <strong>Filtro: </strong> {{ $filtroTipoConta }}
                    @endif
                </div>
            </div>

            <!-- PRINT DATE -->
            <div class="print-date">
                <strong>Emitido em:</strong> {{ now()->format('d/m/Y H:i: s') }}
            </div>

            <!-- INFO CARDS -->
            <div class="info-box">
                <div class="info-card">
                    <div class="info-label">💰 Total Geral</div>
                    <div class="info-value">R$ {{ number_format($totalDespesas ?? 0, 2, ',', '.') }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">📊 Quantidade</div>
                    <div class="info-value">{{ $totalRegistros ?? 0 }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">📈 Média Diária</div>
                    <div class="info-value">R$ {{ number_format($mediaDiaria ?? 0, 2, ',', '.') }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">🔴 Maior Despesa</div>
                    <div class="info-value">R$ {{ number_format($maiorDespesa ?? 0, 2, ',', '.') }}</div>
                </div>
            </div>

            <!-- TABELA PRINCIPAL -->
            @if(isset($despesasPorTipo) && $despesasPorTipo->isNotEmpty())

            <table>
                <thead>
                    <tr>
                        <th width="45%">Tipo de Conta</th>
                        <th width="20%" class="text-right">Valor Total</th>
                        <th width="15%" class="text-center">Quantidade</th>
                        <th width="20%" class="text-right">Percentual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despesasPorTipo as $item)
                    @php
                    $percentual = 0;
                    if (isset($totalDespesas) && $totalDespesas > 0) {
                    $percentual = ($item->total / $totalDespesas) * 100;
                    }
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $tiposContas[$item->tipoconta] ?? $item->tipoconta }}</strong>
                        </td>
                        <td class="text-right">
                            R$ {{ number_format($item->total, 2, ',', '.') }}
                        </td>
                        <td class="text-center">
                            {{ $item->count }}
                        </td>
                        <td class="text-right">
                            <span class="badge">{{ number_format($percentual, 1) }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td><strong>TOTAL GERAL</strong></td>
                        <td class="text-right">
                            <strong>R$ {{ number_format($totalDespesas ?? 0, 2, ',', '.') }}</strong>
                        </td>
                        <td class="text-center">
                            <strong>{{ $totalRegistros ?? 0 }}</strong>
                        </td>
                        <td class="text-right">
                            <strong>100%</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- OBSERVAÇÕES -->
            <div class="observations">
                <strong>📋 OBSERVAÇÕES E INFORMAÇÕES ADICIONAIS:</strong>
                <ul>
                    <li>Relatório gerado automaticamente pelo sistema Intelisoft ERP</li>
                    <li>Total de registros de despesas: <strong>{{ $totalRegistros ?? 0 }}</strong></li>
                    <li>Período analisado: <strong>{{ $dataInicioFormatada ?? date('d/m/Y') }}</strong> a <strong>{{
                            $dataFimFormatada ?? date('d/m/Y') }}</strong></li>
                    <li>Número de dias: <strong>{{ $numeroDias ?? 0 }}</strong></li>
                    <li>Valor total consolidado: <strong>R$ {{ number_format($totalDespesas ?? 0, 2, ',', '.')
                            }}</strong></li>
                    <li>Média por dia: <strong>R$ {{ number_format($mediaDiaria ?? 0, 2, ',', '.') }}</strong></li>
                    @if(isset($maiorDespesa) && $maiorDespesa > 0)
                    <li>Maior despesa registrada: <strong>{{ $tipoMaiorDespesa }}</strong> - R$ {{
                        number_format($maiorDespesa, 2, ',', '.') }}</li>
                    @endif
                    <li>Data da emissão: <strong>{{ now()->format('d/m/Y H:i:s') }}</strong></li>
                </ul>
            </div>

            @else
            <div class="observations">
                <strong>⚠️ AVISO:</strong> Nenhuma despesa encontrada para o período selecionado.
            </div>
            @endif

            <!-- FOOTER -->
            <div class="footer">
                <strong>Intelisoft ® - Gestão Inteligente de Negócios</strong><br>
                www.intelisoft.pro | © {{ now()->year }} | ERP v1.0.0<br>
                <em>Este relatório foi gerado automaticamente e não requer assinatura.</em>
            </div>
        </div>

        <!-- BOTÕES (NÃO IMPRESSÃO) -->
        <div class="button-container no-print">
            <button class="btn btn-print" onclick="window.print()">
                📄 Imprimir Relatório
            </button>
            <button class="btn btn-back" onclick="window.history.back()">
                ⬅️ Voltar
            </button>
        </div>
    </body>

    </html>