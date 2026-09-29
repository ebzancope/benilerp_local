<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - Sistema ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Sistema ERP</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Olá, {{ $user['name'] }} (Nível: {{ $user['access_level'] }})
                </span>
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm me-2">Voltar</a>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Relatórios</h1>
        <p>Área de relatórios - Acesso nível 2+</p>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Relatório de Vendas</h5>
                        <p class="card-text">Relatório completo de vendas</p>
                        <a href="#" class="btn btn-primary">Gerar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Relatório Financeiro</h5>
                        <p class="card-text">Relatório financeiro mensal</p>
                        <a href="#" class="btn btn-primary">Gerar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>