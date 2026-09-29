{{-- resources/views/emails/user-registration.blade.php --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Credenciais de Acesso</title>
</head>

<body>
    <h2>Bem-vindo ao nosso ERP!</h2>

    <p>Olá, {{ $name }}!</p>

    <p>Suas credenciais de acesso foram criadas:</p>

    <div style="background: #f4f4f4; padding: 15px; margin: 15px 0;">
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Senha:</strong> {{ $password }}</p>
        <p><strong>URL de Acesso:</strong> <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
    </div>

    <p>Recomendamos que altere sua senha no primeiro acesso.</p>

    <p>Atenciosamente,<br>Equipe do ERP</p>
</body>

</html>
app/Http/Middleware/LogUserActions
