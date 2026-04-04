<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação 2FA</title>
</head>
<body>
    <h1>Autenticação em Dois Fatores</h1>

    @if(session('message'))
        <div style="color: green;">{{ session('message') }}</div>
    @endif

    @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <p>Por favor, insira o código que foi enviado para você.</p>

    <form method="POST" action="{{ route('2fa.store') }}">
        @csrf
        <input type="text" name="two_factor_code" placeholder="Código 2FA" required>
        <button type="submit">Verificar</button>
    </form>

    <form method="POST" action="{{ route('2fa.resend') }}" style="margin-top: 10px;">
        @csrf
        <button type="submit">Reenviar Código</button>
    </form>
</body>
</html>
