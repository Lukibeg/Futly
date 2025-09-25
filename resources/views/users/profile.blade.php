@extends('layouts.app')

@section('content')

    <div class="title-page flex flex-col justify-center items-center mt-10">
        <h1 class="text-4xl font-bold">Perfil do Jogador</h1>
        <div class="description-container text-center mb-4 text-lg text-gray-500">
            <p class="description-text">Aqui você pode visualizar o perfil do jogador.</p>
        </div>
    </div>

    <x-alert />


@endsection