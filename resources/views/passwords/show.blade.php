@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Visualizar Senha</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $password->title }}</h5>

            @if ($password->url)
                <p><strong>URL:</strong>
                    <a href="{{ $password->url }}" target="_blank">{{ $password->url }}</a>
                </p>
            @endif

            <p><strong>Usuário:</strong> {{ $password->username }}</p>

            {{-- Corrigido: usar password_encrypted com Crypt::decryptString --}}
            @php
                $decrypted = \Illuminate\Support\Facades\Crypt::decryptString($password->password_encrypted);
            @endphp

            <p>
                <strong>Senha:</strong>
                <span style="font-weight:bold;">{{ $decrypted }}</span>
                <button onclick="copyToClipboard('{{ $decrypted }}')" class="btn btn-sm btn-outline-secondary">
                    Copiar
                </button>
            </p>

            <a href="{{ route('passwords.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function () {
            alert('Senha copiada para a área de transferência!');
        }, function (err) {
            alert('Erro ao copiar: ' + err);
        });
    }
</script>
@endsection
