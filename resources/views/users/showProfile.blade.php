@extends('layouts.app')

@section('content')

    <x-alert />

    <div class="container">

        <div class="title-page">
            <h1 class="name-profile">Perfil de {{ $user->name }}</h1>
            <div class="description-container">
                <p class="description-text">Veja as informações do jogador {{ $user->name }}.</p>
            </div>
        </div>

        <div class="profile-form">
            <div class="profile-grid">
                <!-- Coluna da Esquerda -->
                <div>

                    <div class="mb-4">
                        <label class="label-profile" for="birthdate">
                            Data de Nascimento
                        </label>
                        <input disabled class="input-profile" id="birthdate" name="birthdate" type="date"
                            value="{{ $user->birthdate }}">
                    </div>

                    <div class="mb-4">
                        <label class="label-profile" for="position">
                            Sua Posição Principal
                        </label>
                        <input disabled class="input-profile" id="position" name="position" type="text"
                            placeholder="Ex: Atacante, Goleiro" value="{{ $user->position }}">
                    </div>

                    <div class="mb-6">
                        <label class="label-profile" for="preferred_foot">
                            Pé Preferido
                        </label>
                        <select disabled class="select-profile" id="preferred_foot" name="preferred_foot">
                            <option value="">Selecione</option>
                            <option value="Direito" {{ $user->preferred_foot == 'Direito' ? 'selected' : '' }}>
                                Direito</option>
                            <option value="Esquerdo" {{ $user->preferred_foot == 'Esquerdo' ? 'selected' : '' }}>
                                Esquerdo</option>
                            <option value="Ambidestro" {{ $user->preferred_foot == 'Ambidestro' ? 'selected' : '' }}>
                                Ambidestro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="label-profile" for="about_me">
                            Sobre Mim
                        </label>
                        <textarea disabled class="input-profile" id="about_me" name="about_me" rows="4"
                            placeholder="Fale um pouco sobre você, seu estilo de jogo, etc.">{{ $user->about_me }}</textarea>
                    </div>

                    @if ($user->id == auth()->user()->id)
                        <div class="mb-4">
                            <label class="label-profile" for="profile_picture">
                                Foto de Perfil
                            </label>
                            <input disabled type="file" id="profile_picture" name="profile_picture">
                        </div>
                    @endif
                </div>

                <!-- Coluna da Direita -->
                <div>
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-1/2">
                            <label class="label-profile" for="city">
                                Cidade
                            </label>
                            <input disabled class="input-profile" id="city" name="city" type="text" placeholder="Sua cidade"
                                value="{{ $user->city }}">
                        </div>
                        <div class="w-1/2">
                            <label class="label-profile" for="state">
                                Estado
                            </label>
                            <input disabled class="input-profile" id="state" name="state" type="text"
                                placeholder="Seu estado" value="{{ $user->state }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="label-profile" for="height">
                            Altura (cm)
                        </label>
                        <input disabled class="input-profile" id="height" name="height" type="number" placeholder="Ex: 180"
                            value="{{ $user->height }}">
                    </div>

                    <div class="mb-4">
                        <label class="label-profile" for="strengths">
                            Pontos Fortes
                        </label>
                        <textarea disabled class="input-profile" id="strengths" name="strengths" rows="3"
                            placeholder="Ex: Chute forte, Drible, Marcação">{{ $user->strengths }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="label-profile" for="weaknesses">
                            Pontos Fracos
                        </label>
                        <textarea disabled class="input-profile" id="weaknesses" name="weaknesses" rows="3"
                            placeholder="Ex: Jogo aéreo, Perna esquerda">{{ $user->weaknesses }}

                                        </textarea>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection