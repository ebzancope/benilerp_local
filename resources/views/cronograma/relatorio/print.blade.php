<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta name="author" content="Ebzancope">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Cronograma - {{ config('app.name', 'Laravel') }}</title>
    @include('scripts')
        @php
    // Configurações de data e hora para português do Brasil
    setlocale(LC_TIME, 'pt_BR.UTF-8');
    date_default_timezone_set('America/Sao_Paulo');
    @endphp
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; font-family: Arial, sans-serif; background: white !important; }
        @media print {
            @page { size: A4; margin: 40px !important; }
            body, html { margin: 0 !important; padding: 0 !important; width:100% !important; height:100% !important; }
            .no-print { display:none !important; }
        }
        table { width:100%; border-collapse: collapse; }
        th, td { padding: 6px 8px; font-size: 12px; border-bottom: 1px solid #e0e0e0; }
        th { background:#dcecd3; color:#30a300; text-align:left; }
        .totals { text-align: right; font-weight: bold; font-size: 14px; margin-top: 10px; }
        .brand { background-color: #dcecd3; color:#30a300; padding: 10px; border-radius: 10px; display: flex; align-items: center; gap: 16px; }
        .brand img { border-radius: 8px; }
        .filters { margin-top: 8px; font-size: 11px; color: #475147; display:flex; gap:16px; flex-wrap:wrap; }
        .filters span { background:#f3f6f4; padding:4px 8px; border-radius:8px; }
        .badge { display:inline-block; padding: 3px 8px; border-radius: 999px; font-size: 11px; color:#fff; }
        .bg-primary { background:#0d6efd; }
        .bg-success { background:#198754; }
        .bg-warning { background:#ffc107; color:#212529; }
        .bg-info { background:#0dcaf0; color:#212529; }
        .bg-secondary { background:#6c757d; }
        .bg-dark { background:#212529; }
        .bg-danger { background:#dc3545; }
        .bg-light { background:#dee2e6; color:#212529; }
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

               {{-- Filtros aplicados --}}
        <div class="filters">
            @foreach($filtrosAplicados as $label => $valor)
                @php
                    // Normaliza o valor para string
                    if (is_scalar($valor)) {
                        $display = $valor;
                    } elseif (is_object($valor)) {
                        // Se vier um modelo Cronograma, tenta usar status_text ou estatus
                        $display = $valor->status_text ?? $valor->estatus ?? json_encode($valor);
                    } elseif (is_array($valor)) {
                        $display = json_encode($valor);
                    } else {
                        $display = (string) $valor;
                    }
                @endphp
                <span><strong>{{ $label }}:</strong> {{ $display }}</span>
            @endforeach
        </div>

        <div style="margin-top: 12px;">
            <table>
                <thead>
                    <tr>
                        <th style="width:15%;">Cliente</th>
                        <th style="width:10%;">Início</th>
                        <th style="width:10%;">Fim</th>
                        <th style="width:30%;">Descrição</th>
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
                            <td>{{ $item->observacao ?? $item->titulo }}</td>
                            <td style="text-align:right;">R$ {{ number_format($item->valor,2,',','.') }}</td>
                            <td style="text-align:center;">
                                @php
                                    $colorMap = [
                                        '1' => 'primary',   // A Receber
                                        '2' => 'success',   // Pago
                                        '3' => 'warning',   // Em Execução
                                        '4' => 'info',      // Agendar
                                        '5' => 'secondary', // A Visitar
                                        '6' => 'dark',      // Finalizado
                                        '7' => 'danger',    // Agendado
                                    ];
                                    $badge = $colorMap[$item->estatus] ?? 'light';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $item->status_text }}</span>




                                 @php
                                        $venc = $item->datafim ?? null;
                                        if ($venc instanceof \DateTimeInterface) {
                                        $vencTs = strtotime($venc->format('Y-m-d H:i:s'));
                                        } elseif (is_string($venc)) {
                                        $vencTs = strtotime($venc);
                                        } else {
                                        $vencTs = null;
                                        }
                                        $nowTs = time();
                                        @endphp

                                        @if ($item->estatus == '1' && $vencTs && $nowTs > ($vencTs + 30 * 24 * 60
                                        * 60))
                                        <span class="badge badge-danger">
                                            <i class='fa-solid fa-triangle-exclamation'></i> Vencido
                                        </span>
                                        @endif


                            </td>
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
