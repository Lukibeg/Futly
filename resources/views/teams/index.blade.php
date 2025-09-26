@extends('layouts.app')

@section('content')

    <div class="title-page flex flex-col justify-center items-center mt-10">
        <h1 class="text-4xl font-bold">Times</h1>
        <div class="description-container text-center mb-4 text-lg text-gray-500">
            <p class="description-text"></p>
        </div>
    </div>

    <x-alert />
    <div class="container-teams w-4/5 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($teams as $team)

                <div class="team-card bg-white border border-gray-300 rounded-md p-5 shadow-md">
                    <div class="flex flex-col gap-2 mb-4">
                        <h3 class="text-lg font-bold">{{ $team->name }}</h3>
                        <p class="text-sm text-gray-500">Time {{ $loop->iteration }}</p>
                        <p class="text-sm text-gray-500">Vagas preenchidas: {{ $membersQuantity . ' de ' . $team->capacity}}</p>
                        <p class="text-sm text-gray-500">Criador do time: <span
                                class="font-bold">{{ $team->owner->name }}</span></p>
                        <p class="text-sm text-gray-500">Criado em: {{ $team->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md text-xs">
                            Ver Jogadores
                        </a>

                        <a href="{{ route('requestJoinTeam', $team->id) }}" class="bg-red-500 text-white px-4 py-2 rounded-md text-xs">
                            Pedir para entrar no time
                        </a>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection