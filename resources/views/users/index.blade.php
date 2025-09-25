@extends('layouts.app')

@section('content')

    <div class="title-page flex flex-col justify-center items-center mt-10">
        <h1 class="text-4xl font-bold">Jogadores</h1>
        <div class="description-container text-center mb-4 text-lg text-gray-500">
            <p class="description-text">Aqui você pode visualizar todos os jogadores presentes na plataforma.</p>
        </div>
    </div>

    <x-alert />

    <div class="container-users w-4/5 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($users as $user)
                <div
                    class="user-card bg-white border border-gray-300 rounded-md p-5 shadow-md flex flex-col justify-center items-center">
                    <div class="player-photo mb-4">
                        <img src="{{ Vite::asset('resources/images/player.png')}}" alt="Player Photo">
                    </div>
                    <hr class="w-full border-gray-300 my-4">
                    <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">Posição: {{ $user->position ?? 'Não informado' }}</p>
                    <p class="text-sm text-gray-500">Status: {{ $user->status ?? 'Não informado'  }}</p>

                    <div class="flex flex-row gap-4">
                        <a href="{{ route('users.show', $user->id) }}">Ver perfil</a>
                        <a href="">Convidar para time</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection