@extends('layouts.modele')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-5">Gestion des utilisateurs</h2>
        <form method="GET" action="{{ route('admin.users.index') }}" class="row justify-content-center mb-5">
            <div class="col-md-4 mb-3">
                <label for="search" class="form-label">Recherche</label>
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}"
                        placeholder="Nom, prénom ou login">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="">Tous les types</option>
                    <option value="etudiant" {{ request('type') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                    <option value="enseignant" {{ request('type') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                    <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
            </div>
            <div class="col-md-2 mb-3 d-flex align-items-end justify-content-center">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </form>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($users as $user)
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="fas fa-user"></i> {{ $user->prenom }} {{ $user->nom }}
                                </h5>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if ($user->type === null)
                                            <li>
                                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Approuver</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.refuse', $user->id) }}" method="post"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item">Refuser</button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Supprimer</button>
                                            </form>
                                        <li>
                                            <form action="{{ route('admin.users.update', $user) }}" method="POST"
                                                class="dropdown-item">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group mt-2">
                                                    <label for="type-{{ $user->id }}" class="form-label">Changer le
                                                        type d'utilisateur</label>
                                                    <div class="input-group">
                                                        <select name="type" id="type-{{ $user->id }}"
                                                            class="form-control" required>
                                                            <option value="">Sélectionner un type</option>
                                                            <option value="etudiant"
                                                                {{ $user->type == 'etudiant' ? 'selected' : '' }}>Étudiant
                                                            </option>
                                                            <option value="enseignant"
                                                                {{ $user->type == 'enseignant' ? 'selected' : '' }}>
                                                                Enseignant</option>
                                                            <option value="admin"
                                                                {{ $user->type == 'admin' ? 'selected' : '' }}>
                                                                Administrateur</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fas fa-save"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="card-text"><strong>Login :</strong> {{ $user->login }}</p>
                                <p class="card-text"><strong>Email :</strong> {{ $user->email }}</p>
                                <p class="card-text"><strong>Type :</strong> {{ $user->type }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $users->appends(request()->except('page'))->links() }} <!-- pour garder les filtres dans la pagination -->
        </div> 
    </div>
@endsection
