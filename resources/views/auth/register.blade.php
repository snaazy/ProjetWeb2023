@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white text-center pb-0">
                        <h1 class="display-5">S'inscrire</h1>
                        <p class="text-muted">Remplissez le formulaire ci-dessous pour créer un compte.</p>
                    </div>
                    <div class="card-body px-4">
                        <form method="post" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" name="nom"
                                    class="form-control rounded-pill @error('nom') is-invalid @enderror"
                                    value="{{ old('nom') }}">
                                @error('nom')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" name="prenom"
                                    class="form-control rounded-pill @error('prenom') is-invalid @enderror"
                                    value="{{ old('prenom') }}">
                                @error('prenom')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" name="login"
                                    class="form-control rounded-pill @error('login') is-invalid @enderror"
                                    value="{{ old('login') }}">
                                @error('login')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="mdp" class="form-label">Mot de passe</label>
                                <input type="password" name="mdp"
                                    class="form-control rounded-pill @error('mdp') is-invalid @enderror">
                                @error('mdp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Sélectionnez votre type d'utilisateur :</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="enseignant"
                                        value="enseignant" {{ old('type') == 'enseignant' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enseignant">
                                        Enseignant
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="admin"
                                        value="admin" {{ old('type') == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="admin">
                                        Admin
                                    </label>
                                </div>
                                @error('type')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Formation</label>
                                <select name="formation_id"
                                    class="orm-control rounded-pill @error('formation_id') is-invalid @enderror">
                                    <option value="">Sélectionnez votre formation (optionnel pour les enseignants et
                                        les admins)</option>
                                    @foreach ($formations as $formation)
                                        <option value="{{ $formation->id }}"
                                            {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                                            {{ $formation->intitule }}</option>
                                    @endforeach
                                </select>
                                @error('formation_id')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary btn-block rounded-pill">Créer un
                                    compte</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white text-center pt-0">
                        <p class="mb-0">Vous avez déjà un compte ? <a href="{{ route('login') }}" class="link-primary">Se
                                connecter</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
