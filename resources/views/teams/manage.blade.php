@extends('layouts.app')


@section('content')


    <div class="title-page flex flex-col justify-center items-center mt-10">
        <h1 class="text-4xl font-bold">Gerenciar pedidos</h1>
        <div class="description-container text-center mb-4 text-lg text-gray-500">
            <p class="description-text">Gerencie seus pedidos de entrada</p>
        </div>
    </div>

    <x-alert />

    <div class="container">
        <div class="join-requests rounded-md p-5">
            @foreach ($joinRequests as $request)

                <div class="join-request p-5 flex flex-col gap-2 border border-gray-500 rounded-md bg-gray-100">
                    <div class="flex flex-col text-center gap-2">
                        <h2>Solicitante: {{ $request->user->name }}</h2>
                        <p>Time: {{ $request->team->name }}</p>
                        <p>Status: {{ $request->status }}</p>
                    </div>
                    <form action="{{ route('responseJoinRequest', $request->id) }}" class="flex flex-row gap-2"
                        method="post">
                        @csrf
                        <button type="submit" name="status" value="approved">Aceitar</button>
                        <button type="submit" name="status" value="rejected">Rejeitar</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

@endsection