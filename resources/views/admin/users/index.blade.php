@extends('layouts.modele')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Gestion des utilisateurs</h2>
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="form-group">
                    <label for="search">Recherche</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nom, prénom ou login">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Tous les types</option>
                        <option value="etudiant" {{ request('type') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="enseignant" {{ request('type') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                        <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
            <div class="mt-3">
                <ul class="list-group">
                    @foreach($users as $user)
                    <li class="list-group-item shadow">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <i class="fas fa-user-circle fa-3x"></i>
                            </div>
                            <div class="col-md-4">
                                <h5 class="card-title">{{ $user->prenom }} {{ $user->nom }}</h5>
                                <p class="card-text mb-1">Login: {{ $user->login }}</p>
                                <p class="card-text mb-0">Type: {{ $user->type }}</p>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column align-items-end">
                                    @if($user->type === null)
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Approuver</button>
                                    </form>
                                    
                                    <form action="{{ route('admin.users.refuse', $user->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm mb-2">Refuser</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group mt-2">
                                            <select name="type" required>
                                                <option value="">Sélectionner un type</option>
                                                <option value="etudiant" {{ $user->type == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                                <option value="enseignant" {{ $user->type == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                                <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                                                </div>
                                                </form>
                                                </div>
                                                </div>
                                                </div>
                                                </li>
                                                @endforeach
                                                </ul>
                                                <div class="d-flex justify-content-center mt-3">
                                                {{ $users->links('pagination::bootstrap-4') }}
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                                @endsection
