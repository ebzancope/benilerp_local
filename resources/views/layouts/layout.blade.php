<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta name="author" content="ebzancope@gmail.com">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('scripts')
    @php
    // Configurações de data e hora para português do Brasil
    setlocale(LC_TIME, 'pt_BR.UTF-8');
    date_default_timezone_set('America/Sao_Paulo');
    @endphp
</head>

<body>
    @if (!session('user.id'))
    @else
    @include('top_bar')
    @endif
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
<div class="slim-footer">
    <div class="container">

        <p style="font-size: 10px; font-weight:light;color: gray;"><br>
            <b> InterGestor - Gestão Inteligente de Negócios </b><br>
            www.intergestor.com.br / {{ now()->year }} / ERP v1.0.6
        </p>
        <p><a href="#" class="text-decoration-none"> Suporte <svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-headset" viewBox="0 0 16 16">
                    <path
                        d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5z" />
                </svg></a> </p>

    </div><!-- container -->
</div><!-- slim-footer -->

</html>