@extends('layouts.modele')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow">
                    <div class="card-header" style="background-color: #6c278e;">
                        <h2 class="mb-0 text-white">{{ __('Créer un nouvel utilisateur') }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="login">{{ __('Login') }}</label>
                                <input id="login" type="text"
                                    class="form-control @error('login') is-invalid @enderror" name="login"
                                    value="{{ old('login') }}" required autocomplete="login" autofocus>
                                @error('login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nom">{{ __('Nom') }}</label>
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror"
                                    name="nom" value="{{ old('nom') }}" required autocomplete="nom">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="prenom">{{ __('Prénom') }}</label>
                                <input id="prenom" type="text"
                                    class="form-control @error('prenom') is-invalid @enderror" name="prenom"
                                    value="{{ old('prenom') }}" required autocomplete="prenom">
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mdp">{{ __('Mot de passe') }}</label>
                                <input id="mdp" type="password"
                                    class="form-control @error('mdp') is-invalid @enderror" name="mdp" required
                                    autocomplete="new-password">
                                @error('mdp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mdp-confirm">{{ __('Confirmer le mot de passe') }}</label>
                                <input id="mdp-confirm" type="password" class="form-control" name="mdp_confirmation"
                                    required autocomplete="new-password">
                            </div>

                          

                            <div class="form-group">
                                <label for="type">{{ __('Type') }}</label>
                                <select name="type" class="form-control custom-select @error('type') is-invalid @enderror" id="type">
                                    <option value="etudiant" {{ old('type') == 'etudiant' ? 'selected' : '' }}>
                                        {{ __('Etudiant') }}</option>
                                    <option value="enseignant" {{ old('type') == 'enseignant' ? 'selected' : '' }}>
                                        {{ __('Enseignant') }}</option>
                                    <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>
                                        {{ __('Administrateur') }}</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            @if(old('type') !== 'admin' && old('type') !== 'enseignant')

                            <div class="form-group">
                                <label for="formation_id">{{ __('Formation') }}</label>
                                <select name="formation_id" id="formation_id" class="form-control custom-select @error('formation_id') is-invalid @enderror">
                                    <option value="">{{ __('Sélectionnez une formation') }}</option>
                                    @foreach($formations as $formation)
                                        <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                                        {{ $formation->intitule }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Optionnel pour les enseignants et admin</small>
                                @error('formation_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                         
                        
                            </div>
                            
                            @endif
                            
                            
                            <div class="form-group mt-4">
                                <button type="submit"
                                    class="btn btn-primary rounded-pill">{{ __('Enregistrer') }}</button>
                                <a href="{{ route('admin.users.index') }}"
                                    class="btn btn-secondary rounded-pill">{{ __('Annuler') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
