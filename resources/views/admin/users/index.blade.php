@extends('layouts.modele')
@section('title', 'Liste des utilisateurs')
@section('content')
    <div class="container mt-5">


        <h2 class="text-center mb-5">Gestion des utilisateurs</h2>
        @if ($enAttente > 0)
            <div class="position-fixed top-3 start-0 p-3" style="z-index: 9999">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-secondary text-white">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Il y a {{ $enAttente }} utilisateur(s) en attente d'approbation.
                    </div>
                </div>
            </div>

            <script>
                var toast = new bootstrap.Toast(document.querySelector('.toast'), {
                    autohide: true,
                    delay: 5000
                });
                toast.show();
            </script>
        @endif
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
        <div class="alert alert-secondary mt-4" role="alert">
            <p>Avant de supprimer un utilisateur, veuillez vous assurer que toutes les données liées ont été supprimées,
                telles que les formations, les cours, les séances de cours associées, etc.</p>
            <p>Il est également nécessaire que l'enseignant supprime d'abord ses planifications de séances de cours pour un
                cours de la formation en question.</p>
        </div>
        @foreach (['success', 'danger', 'warning', 'error'] as $alert)
            @if (session($alert))
                <div class="alert alert-{{ $alert }} alert-dismissible fade show mt-3" role="alert">
                    {!! session($alert) !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">
            @foreach ($users as $user)
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="fas fa-user"></i> {{ $user->prenom }} {{ $user->nom }}
                                </h5>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        @if ($user->type === null)
                                            <li>
                                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"><i
                                                            class="fas fa-check"></i> Approuver</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.refuse', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item"><i
                                                            class="fas fa-times"></i> Refuser</button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('admin.users.update', $user) }}" method="POST"
                                                class="my-form-class">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label for="nom-{{ $user->id }}" class="form-label">Nom
                                                            :</label>
                                                        <input type="text" name="nom" id="nom-{{ $user->id }}"
                                                            class="form-control" value="{{ $user->nom }}" required>
                                                    </div>
                                                    <div class="col">
                                                        <label for="prenom-{{ $user->id }}" class="form-label">Prénom
                                                            :</label>
                                                        <input type="text" name="prenom"
                                                            id="prenom-{{ $user->id }}" class="form-control"
                                                            value="{{ $user->prenom }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="login-{{ $user->id }}" class="form-label">Login
                                                        :</label>
                                                    <input type="text" name="login" id="login-{{ $user->id }}"
                                                        class="form-control" value="{{ $user->login }}" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-save"></i>
                                                    Enregistrer</button>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.users.changepassword', $user) }}"
                                                class="dropdown-item"><i class="fas fa-key"></i> Changer le mot de
                                                passe</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i
                                                        class="fas fa-trash"></i> Supprimer</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.users.update.type', $user) }}" method="POST"
                                                class="dropdown-item">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-2">
                                                    <label for="type-{{ $user->id }}" class="form-label">Changer le
                                                        type d'utilisateur :</label>
                                                    <select name="type" id="type-{{ $user->id }}"
                                                        class="form-select" required>
                                                        <<option value="etudiant"
                                                            {{ $user->type == 'etudiant' ? 'selected' : '' }}>Étudiant
                                                            </option>
                                                            <option value="enseignant"
                                                                {{ $user->type == 'enseignant' ? 'selected' : '' }}>
                                                                Enseignant</option>
                                                            <option value="admin"
                                                                {{ $user->type == 'admin' ? 'selected' : '' }}>
                                                                Administrateur</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-save"></i>
                                                    Enregistrer</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="card-text"><strong>Login :</strong> {{ $user->login }}</p>
                            @if ($user->type === null)
                                <span class="badge bg-warning text-dark">En attente d'approbation</span>
                            @else
                                <span class="badge bg-success">{{ ucfirst($user->type) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4 pagination-custom">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>

    <style>
        .my-form-class {
            padding: 10px;
        }



        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            margin-bottom: 1rem;
            font-weight: 500;
        }
    </style>
@endsection
