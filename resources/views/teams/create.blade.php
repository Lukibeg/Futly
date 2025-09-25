@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="login-container">

            <div class="title-container">
                Criar Time
                <div class="description-container text-center mb-4 text-sm text-gray-500">
                    <p>Crie um time para gerenciar seus jogadores e partidas</p>
                </div>
            </div>

            <!-- Componente de alerta -->
            <x-alert />

            <form action="{{ route('teams.store') }}" method="post">
                @csrf
                <label for="name">Nome do time:</label>
                <input type="text" name="name" placeholder="Nome">
                <label for="list-members">Membros:</label>

                <div class="flex items-center gap-2 border-2 border-gray-300 rounded-md p-2">
                    @forelse ($users as $user)
                        <input type="checkbox" name="members[]" id="members{{ $user->id }}" value="{{ $user->id }}">
                        <label for="members">{{ $user->name }}</label>
                    @empty
                        <p class="text-sm text-gray-500 font-bold">Nenhum usuário encontrado ou usuários já possuem time.</p>
                    @endforelse

                </div>


                <div class="border-2 border-gray-300 rounded-md p-2">
                    <p class="text-sm text-gray-500 font-bold">Não altere o campo abaixo</p>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="owner" id="owner" value="{{ auth()->user()->id }}" checked disabled>
                        <input type="hidden" name="owner_id" id="owner_id" value="{{ auth()->user()->id }}" checked>
                        <label for="owner_id">Sou o líder do time</label>

                        <input type="checkbox" name="nomembers" id="nomembers" value="1">
                        <label for="nomembers">Iniciar sem membros</label>  
                    </div>
                </div>
                <button type="submit">Criar</button>


            </form>
        </div>
    </div>
@endsection