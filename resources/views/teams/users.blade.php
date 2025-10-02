@extends('layouts.app')


@section('content')


    <div class="title-page flex flex-col justify-center items-center mt-10">
        <h1 class="text-4xl font-bold">Jogadores do time: {{ $team->name }}</h1>
        <div class="description-container text-center mb-4 text-lg text-gray-500">
            <p class="description-text">Veja os jogadores do time</p>
        </div>
    </div>

    <x-alert />

    <div class="container-users w-4/5 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($users as $user)
                <div class="user-card bg-white border border-gray-300 rounded-md p-5 shadow-md">
                    <div class="mb-4 flex justify-center items-center">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : Vite::asset('resources/images/default_profile.png') }}"
                            alt="Player Photo" class="user-photo">
                    </div>

                    <hr class="w-full border-gray-300 my-4">

                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">Posição: {{ $user->position ?? 'Não informado' }}</p>
                        <p class="text-sm text-gray-500">Pé dominante: {{ $user->preferred_foot ?? 'Não informado' }}</p>
                        <p class="text-sm text-gray-500">Altura: {{ $user->height ?? 'Não informado' }}</p>
                        <p class="text-sm text-gray-500">Forças: {{ $user->strengths ?? 'Não informado' }}</p>
                        <p class="text-sm text-gray-500">Fraquezas: {{ $user->weaknesses ?? 'Não informado' }}</p>
                    </div>

                    <div class="flex flex-row items-center justify-center gap-4 mt-3">
                        <a href="{{ route('users.show', $user->id) }}">Ver perfil</a>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

@endsection