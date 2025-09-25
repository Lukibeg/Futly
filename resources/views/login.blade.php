@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-info">

        </div>

        <div class="login-container">
            <div class="title-container">
                Efetue o login em sua conta
            </div>

            <!-- Alert component -->
            <x-alert />

            <form action="{{ route('login') }}" method="post">
                @csrf
                <input type="text" name="name" placeholder="Usuário" value="{{ old('name') }}">
                <input type="password" name="password" placeholder="Senha">
                <button type="submit">Login</button>
            </form>
            <div class="forget-password">
                <span>Esqueci minha senha</span>
            </div>
        </div>
    </div>

    @vite('resources/js/login.js')

@endsection