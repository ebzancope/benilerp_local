<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            -webkit-print-color-adjust: exact ! important;
            print-color-adjust: exact !important;
        }

        @media print {
            @page {
                size: A4;
                margin: 20mm;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none ! important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #30a300;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #30a300;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        . report-title {
            font-size: 20px;
            font-weight: bold;
            color: #141513;
            margin: 15px 0;
        }

        .filters {
            background-color: #f6faf4;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .filters-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 10px;
        }

        . filter-item {
            margin-bottom: 8px;
        }

        .filter-label {
            font-weight: bold;
            color: #30a300;
            display: block;
            margin-bottom: 3px;
        }

        . filter-value {
            color: #333;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            background-color: #eaf4e5;
            border-left: 4px solid #30a300;
            padding: 15px;
            border-radius: 5px;
        }

        .summary-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        . summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #30a300;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #dcecd3;
            color: #30a300;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #30a300;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9faf8;
        }

        tbody tr:hover {
            background-color: #eaf4e5;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }

        . badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #999;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }

        .print-date {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 15px;
        }

        . total-row {
            background-color: #dcecd3;
            font-weight: bold;
            color: #30a300;
        }

        .buttons {
            text-align: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        . btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
            background-color: #30a300;
            color: white;
        }

        .btn:hover {
            background-color: #228b22;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">💰 RELATÓRIO DE DESPESAS</div>
            <div class="company-info">
                <strong>Benil - Terraplanagem e Pavimentação</strong><br>
                CNPJ: 22.418.881/0001-06 | Tel: (37) 3426-2181<br>
                www.benilterraplanagem.com.br
            </div>
            <div class="report-title">Relatório Geral de Despesas</div>
        </div>

        <!-- Print Date -->
        <div class="print-date">
            <strong>Emitido em: </strong> {{ now()->format('d/m/Y H:i') }}
        </div>

        <!-- Filtros Aplicados -->
        @if(request()->filled('data_inicio') || request()->filled('data_fim') || request()->filled('tipoconta') ||
        request()->filled('fornecedor'))
        <div class="filters">
            <strong style="color: #30a300; display: block; margin-bottom: 10px;">FILTROS APLICADOS: </strong>
            <div class="filters-row">
                @if(request()->filled('data_inicio'))
                <div class="filter-item">
                    <span class="filter-label">📅 Data Início: </span>
                    <span class="filter-value">{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                        request('data_inicio'))->format('d/m/Y') }}</span>
                </div>
                @endif
                @if(request()->filled('data_fim'))
                <div class="filter-item">
                    <span class="filter-label">📅 Data Fim: </span>
                    <span class="filter-value">{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                        request('data_fim'))->format('d/m/Y') }}</span>
                </div>
                @endif
                @if(request()->filled('tipoconta'))
                <div class="filter-item">
                    <span class="filter-label">📌 Tipo de Conta: </span>
                    <span class="filter-value">{{ $tiposContas[request('tipoconta')] ?? request('tipoconta') }}</span>
                </div>
                @endif
                @if(request()->filled('fornecedor'))
                <div class="filter-item">
                    <span class="filter-label">🏢 Fornecedor:</span>
                    <span class="filter-value">
                        @php
                        $fornecedorSelecionado = $fornecedores->find(request('fornecedor'));
                        @endphp
                        {{ $fornecedorSelecionado->nome ?? 'N/A' }}
                    </span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Resumo -->
        <div class="summary">
            <div class="summary-card">
                <div class="summary-label">📊 Total Geral</div>
                <div class="summary-value">R$ {{ number_format($totalDespesas, 2, ',', '. ') }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">📅 Este Mês</div>
                <div class="summary-value">R$ {{ number_format($totalMes, 2, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">⏳ A Pagar</div>
                <div class="summary-value">R$ {{ number_format($totalPendente, 2, ',', '. ') }}</div>
            </div>
        </div>

        <!-- Tabela de Despesas -->
        <table>
            <thead>
                <tr>
                    <th>Competência</th>
                    <th>Tipo Conta</th>
                    <th>Fornecedor</th>
                    <th>Centro Custo</th>
                    <th>Documento</th>
                    <th class="text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($despesas as $despesa)
                <tr>
                    <td>
                        @if($despesa->competencia)
                        {{ $despesa->competencia->format('d/m/Y') }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        <strong>{{ $tiposContas[$despesa->tipoconta] ?? $despesa->tipoconta }}</strong>
                    </td>
                    <td>{{ $despesa->clieforne->nome ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-secondary">
                            {{ $centrosCustos[$despesa->centrocustos] ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        @if($despesa->tipodocumento)
                        <span class="badge badge-info">
                            {{ $tiposDocumentos[$despesa->tipodocumento] ?? $despesa->tipodocumento }}
                        </span>
                        @endif
                        @if($despesa->notafiscal)
                        <br><small>NF: {{ $despesa->notafiscal }}</small>
                        @endif
                    </td>
                    <td class="text-right">
                        <strong>R$ {{ number_format((float)$despesa->valortotal, 2, ',', '. ') }}</strong>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">
                        <em>Nenhuma despesa encontrada</em>
                    </td>
                </tr>
                @endforelse

                <!-- Total Final -->
                <tr class="total-row">
                    <td colspan="5" class="text-right">TOTAL GERAL:</td>
                    <td class="text-right">R$ {{ number_format($despesas->sum('valortotal'), 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Observações -->
        <div
            style="background-color: #f6faf4; padding: 15px; border-radius: 5px; font-size: 11px; margin-bottom: 20px;">
            <strong style="color: #30a300;">📝 OBSERVAÇÕES:</strong>
            <ul style="margin-left: 20px; margin-top: 8px;">
                <li>Relatório gerado automaticamente pelo sistema</li>
                <li>Total de registros: <strong>{{ $despesas->count() }}</strong></li>
                <li>Período: {{ request()->filled('data_inicio') ? \Carbon\Carbon::createFromFormat('Y-m-d',
                    request('data_inicio'))->format('d/m/Y') : 'Sem filtro' }} até {{ request()->filled('data_fim') ?
                    \Carbon\Carbon::createFromFormat('Y-m-d', request('data_fim'))->format('d/m/Y') : 'Sem filtro' }}
                </li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <strong>Intelisoft ® - Gestão Inteligente de Negócios</strong><br>
            www.intelisoft.pro | {{ now()->year }} | ERP v1.0.0
        </div>
    </div>

    <!-- Buttons (No Print) -->
    <div class="buttons no-print" style="margin-top: 30px;">
        <button class="btn" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimir
        </button>
        <button class="btn btn-secondary" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i> Voltar
        </button>
    </div>
</body>

</html>