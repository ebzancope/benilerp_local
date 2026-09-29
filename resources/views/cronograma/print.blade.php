<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta name="author" content="Ebzancope">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Cronograma - {{ config('app.name', 'Laravel') }}</title>
    @include('scripts')
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-family: Arial, sans-serif;
            background: white !important;
        }
        @media print {
            @page { size: A4; margin: 40px !important; }
            body, html { margin: 0 !important; padding: 0 !important; width:100% !important; height:100% !important; }
            .no-print { display:none !important; }
        }
        table { width:100%; border-collapse: collapse; }
        th, td { padding: 6px 8px; font-size: 12px; border-bottom: 1px solid #e0e0e0; }
        th { background:#dcecd3; color:#30a300; text-align:left; }
        .totals { text-align: right; font-weight: bold; font-size: 14px; margin-top: 10px; }
        .brand {
            background-color: #dcecd3; color:#30a300; padding: 10px; border-radius: 10px;
            display: flex; align-items: center; gap: 16px;
        }
        .brand img { border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container" style="padding: 10px 0 0 0;">
        <div class="brand">
            <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Logo" width="160">
            <div>
                <div style="font-size: 16px; font-weight: bold; color:#141513;">Relatório de Cronograma</div>
                <div style="font-size: 12px; color:#475147;">Gerado em {{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <div style="margin-left:auto; text-align:right; color:#475147;">
                <div style="font-size: 18px; font-weight: bold;">Total</div>
                <div style="font-size: 16px;">R$ {{ number_format($totalValor,2,',','.') }}</div>
            </div>
        </div>

        <div style="margin-top: 12px;">
            <table>
                <thead>
                    <tr>
                        <th style="width:30%;">Cliente</th>
                        <th style="width:15%;">Início</th>
                        <th style="width:15%;">Fim</th>
                        <th style="width:20%;">Descrição</th>
                        <th style="width:10%; text-align:right;">Valor</th>
                        <th style="width:10%; text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($itens as $item)
                        <tr>
                           <td>{{ $item->clienteInfo->nome ?? 'N/A' }}</td>
                            <td>{{ optional($item->dataini)->format('d/m/Y') }}</td>
                            <td>{{ optional($item->datafim)->format('d/m/Y') }}</td>
                            <td>{{ $item->descricao ?? $item->titulo }}</td>
                            <td style="text-align:right;">R$ {{ number_format($item->valor,2,',','.') }}</td>
                            <td style="text-align:center;">{{ $item->estatus }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;">Nenhum item encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="totals">
                Total: R$ {{ number_format($totalValor,2,',','.') }}
            </div>
        </div>

        <div style="margin-top: 20px; font-size:10px; color: gray; text-align:center;">
            <b>Intelisoft ® - Gestão Inteligente de Negócios</b><br>
            www.intelisoft.pro / {{ now()->year }} / ERP v1.0.0
        </div>
    </div>

    <script> window.onload = function() { window.print(); } </script>
</body>
</html>
