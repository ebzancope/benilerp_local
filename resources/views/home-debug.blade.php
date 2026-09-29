<!DOCTYPE html>
<html>

<head>
    <title>Debug Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>🎯 Debug Dashboard</h1>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4>Informações do Controller</h4>
            </div>
            <div class="card-body">
                <h5>Variáveis Recebidas:</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Variável</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>boletosPendentes</td>
                        <td>{{ $boletosPendentes ?? 'NULL' }}</td>
                        <td class="{{ isset($boletosPendentes) ? 'bg-success text-white' : 'bg-danger text-white' }}">
                            {{ isset($boletosPendentes) ? 'DEFINIDA' : 'NÃO DEFINIDA' }}
                        </td>
                    </tr>
                    <tr>
                        <td>totalPendente</td>
                        <td>{{ $totalPendente ?? 'NULL' }}</td>
                        <td class="{{ isset($totalPendente) ? 'bg-success text-white' : 'bg-danger text-white' }}">
                            {{ isset($totalPendente) ? 'DEFINIDA' : 'NÃO DEFINIDA' }}
                        </td>
                    </tr>
                    <tr>
                        <td>debug_time</td>
                        <td>{{ $debug_time ?? 'NULL' }}</td>
                        <td class="{{ isset($debug_time) ? 'bg-success text-white' : 'bg-danger text-white' }}">
                            {{ isset($debug_time) ? 'DEFINIDA' : 'NÃO DEFINIDA' }}
                        </td>
                    </tr>
                </table>

                @if (isset($mensagem))
                    <div class="alert alert-success">
                        <strong>Mensagem:</strong> {{ $mensagem }}
                    </div>
                @endif

                @if (isset($erro))
                    <div class="alert alert-danger">
                        <strong>Erro:</strong> {{ $erro }}
                    </div>
                @endif

                <div class="mt-3">
                    <a href="/" class="btn btn-secondary">Voltar para Home Normal</a>
                    <a href="/teste-dashboard" class="btn btn-primary">Testar Rota Especial</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
