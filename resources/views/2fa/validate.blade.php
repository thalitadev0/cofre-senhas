@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Validação 2FA</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.post') }}">
        @csrf

        <div class="form-group">
            <label for="one_time_password">Digite o código do seu autenticador:</label>
            <input type="text" class="form-control" name="one_time_password" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Validar</button>
    </form>
</div>
@endsection
