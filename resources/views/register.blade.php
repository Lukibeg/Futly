@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="login-container">
            <div class="title-container">
                Olá, bem vindo a plataforma de futebol!
                <br>Registre-se aqui.
            </div>

            <!-- Alert component -->
            <x-alert />

            <form action="{{ route('register') }}" method="post">
                @csrf
                <input type="text" name="name" placeholder="Nome" value="{{ old('name') }}">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Senha">
                <input type="password" name="password_confirmation" placeholder="Confirme sua senha">
                <button type="submit">Criar usuário</button>
            </form>
        </div>
    </div>
@endsection