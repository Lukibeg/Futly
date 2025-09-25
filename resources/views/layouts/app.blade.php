<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Projeto de Futebol') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<header>
    <nav class="navbar-list">
        <div class="navbar-buttons">
            <a href="{{ route('dashboard')}}">Início</a>
            <a href="{{ route('teams.index')}}">Times</a>
            <a href="{{ route('users.index')}}">Jogadores</a>
            <a href="{{ route('manage')}}">Gerenciar</a>
            <a href="{{ route('logout')}}">Sair</a>
        </div>
    </nav>
</header>

<body>
    @yield('content')
    @vite('resources/js/app.js')
    @if(request()->server('REQUEST_URI') == '/teams' || request()->server('REQUEST_URI') == '/teams/manage')
        @vite('resources/js/teams.js')
    @endif
    @if(request()->server('REQUEST_URI') == '/users')
        @vite('resources/js/players.js')
    @endif
</body>

</html>