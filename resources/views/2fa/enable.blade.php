@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ativar 2FA</h1>

    <p>Escaneie o QR Code abaixo com seu aplicativo autenticador (Google Authenticator, Authy, etc):</p>

    <div>
        {!! $QR_Image !!}
    </div>

    <p><strong>Ou insira esse código manualmente:</strong> {{ $secret }}</p>

    <form action="{{ route('2fa.disable') }}" method="POST">
        @csrf
        <button class="btn btn-danger">Desativar 2FA</button>
    </form>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
