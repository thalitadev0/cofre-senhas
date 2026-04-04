@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Minhas Senhas</h1>

    <a href="{{ route('passwords.create') }}" class="btn btn-primary mb-3">Adicionar Nova Senha</a>
    {{-- Exportar fica fora do loop, só aparece uma vez --}}
    <a href="{{ route('passwords.export') }}" class="btn btn-outline-secondary mb-3">Exportar Senhas</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($passwords->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>URL</th>
                    <th>Usuário</th>
                    <th>Senha</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- Corrigido: variável era $passwords (plural) dentro do foreach --}}
                @foreach ($passwords as $password)
                <tr>
                    <td>{{ $password->title }}</td>
                    <td>{{ $password->url }}</td>
                    <td>{{ $password->username }}</td>
                    <td>
                        ********
                        <a href="{{ route('passwords.show', $password->id) }}">Mostrar</a>
                    </td>
                    <td>
                        <a href="{{ route('passwords.edit', $password->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('passwords.destroy', $password->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Você ainda não tem senhas cadastradas.</p>
    @endif
</div>
@endsection