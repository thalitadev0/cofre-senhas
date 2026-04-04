@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Senha</h1>

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

    <form action="{{ route('passwords.update', $password->id) }}" method="POST">
        @csrf
        {{-- Corrigido: era @crsf (typo), agora @csrf correto --}}
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Título *</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $password->title) }}"
                   class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="url">URL (opcional)</label>
            <input type="url" name="url" id="url"
                   value="{{ old('url', $password->url) }}"
                   class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="username">Usuário *</label>
            <input type="text" name="username" id="username"
                   value="{{ old('username', $password->username) }}"
                   class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Nova Senha *</label>
            {{-- Corrigido: era type="text" expondo a senha, e usava campo errado --}}
            <input type="password" name="password" id="password"
                   class="form-control" required
                   placeholder="Digite a nova senha">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('passwords.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
