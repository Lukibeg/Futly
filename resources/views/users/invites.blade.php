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
            @foreach ($invitesForUser as $invites)

                <div class="join-request p-5 flex flex-col gap-2 border border-gray-500 rounded-md bg-gray-100">
                    <div class="flex flex-col text-center gap-2">
                        <h2>Convidado por: {{ $invites->inviteBy->name }}</h2>
                        <p>Time: {{ $invites->team->name }}</p>
                        <p>Status: {{ $invites->status === 'pending' ? 'Pendente' : 'Não conhecido' }}</p>
                    </div>
                    <form action="{{ route('responseJoinRequest', $invites->id) }}" class="flex flex-row justify-center gap-2" method="post">
                        @csrf
                        <button type="submit" name="status" value="approved">Aceitar</button>
                        <button type="submit" name="status" value="rejected">Rejeitar</button>
                    </form>
                </div>
            @endforeach

        </div>
    </div>

@endsection