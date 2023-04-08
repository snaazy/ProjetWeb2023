@extends('layouts.modele')

@section('title', 'Profil')

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1)">
                    <img class="card-img-top" src="https://via.placeholder.com/150" alt="Profile picture">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->prenom }} {{ $user->nom }}</h5>
                        <p class="card-text">{{ $user->type }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mes informations</h5>
                        <div class="form-group">
                            <label for="login">Login :</label>
                            <input type="text" class="form-control" id="login" value="{{ $user->login }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" class="form-control" id="nom" value="{{ $user->nom }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom :</label>
                            <input type="text" class="form-control" id="prenom" value="{{ $user->prenom }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mdp">Mot de passe :</label>
                            <input type="text" class="form-control" id="mdp" value="{{ $user->mdp }}" disabled>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
