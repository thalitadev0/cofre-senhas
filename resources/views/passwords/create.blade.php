@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Adicionar Nova Senha</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Existem alguns problemas com seu preenchimento.<br><br>
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Corrigido: rota era 'password.store' (errado), agora 'passwords.store' (correto) --}}
    <form action="{{ route('passwords.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="title">Título *</label>
            <input type="text" name="title" id="title" class="form-control"
                   placeholder="Ex: Gmail" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="url">URL (opcional)</label>
            <input type="url" name="url" id="url" class="form-control"
                   placeholder="https://www.exemplo.com" value="{{ old('url') }}">
        </div>

        <div class="form-group mb-3">
            <label for="username">Usuário *</label>
            <input type="text" name="username" id="username" class="form-control"
                   placeholder="Seu usuário ou e-mail" value="{{ old('username') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Senha *</label>
            <input type="password" name="password" id="password" class="form-control"
                   placeholder="Sua senha" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('passwords.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
