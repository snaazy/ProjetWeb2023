@extends('layouts.modele')

@section('title', 'Profil')

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-light p-3" style="box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1)">
                    <div class="text-center">
                        <img class="rounded-circle" src="https://via.placeholder.com/150" alt="Profile picture" width="100">
                    </div>
                    <div class="mt-3">
                        <h5 class="card-title text-center">{{ $user->prenom }} {{ $user->nom }}</h5>
                        <p class="card-text text-center">{{ $user->type }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card bg-light p-3">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <h3 class="card-title">Mes informations</h3>
                        <hr class="my-4">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="login" class="form-label">Login :</label>
                                <input type="text" class="form-control" id="login" value="{{ $user->login }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                    value="{{ $user->nom }}">
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom :</label>
                                <input type="text" class="form-control" id="prenom" name="prenom"
                                    value="{{ $user->prenom }}">
                            </div>

                            <div class="mb-3">
                                <label for="mdp" class="form-label">Mot de passe :</label>
                                <input type="text" class="form-control" id="mdp" value="{{ $user->mdp }}"
                                    disabled>
                                <a href="{{ route('user.changePassword') }}" class="btn btn-link mt-2"
                                    style="text-decoration: none;">Changer de mot de passe</a>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Enregistrer les modifications</button>
                        </form>
                    </div>
                </div>
                <div class="card bg-light p-3 mt-4">
                    <div class="card-body">
                        <h3 class="card-title">Mes cours</h3>
                        <hr class="my-4">
                        @if (count($user->courses) > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Intitulé</th>
                                        <th>Enseignant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->courses as $course)
                                        <tr>
                                            <td>{{ $course->id }}</td>
                                            <td>{{ $course->intitule }}</td>
                                            <td>{{ $course->user->prenom }} {{ $course->user->nom }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Vous n'êtes inscrit à aucun cours pour le moment.</p>
                        @endif
                    </div>
                </div>
                @if (Auth::user()->type == 'enseignant')
                    <div class="card bg-light p-3 mt-4">
                        <div class="card-body">
                            <h3 class="card-title">Gestion de planning</h3>
                            <hr class="my-4">
                            <a href="{{ route('sessions.index') }}" class="btn btn-primary mt-3">Accéder à la gestion des
                                plannings</a>
                        </div>
                    </div>
                @endif
                <div class="card bg-light p-3 mt-4">
                    <div class="card-body">
                        @if (Auth::user()->type == 'etudiant')
                            <h3 class="card-title">Ma formation</h3>
                            <hr class="my-4">
                            <div class="mb-3">
                                <label for="formation" class="form-label">Formation :</label>
                                <input type="text" class="form-control" id="formation"
                                    value="{{ $user->formation ? $user->formation->intitule : 'non-étudiant' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="etablissement" class="form-label">Etablissement :</label>
                                <input type="text" class="form-control" id="etablissement"
                                    value="Université Paris-Est Créteil" readonly>
                            </div>
                        @endif
                        @if (Auth::user()->type == 'enseignant')
                            <h3 class="card-title">Cours assignés</h3>
                            <p>Liste des cours dont je suis responsable </p>
                            <hr class="my-4">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Intitulé</th>
                                        <th>Formation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Auth::user()->assignedCourses as $course)
                                        <tr>
                                            <td>{{ $course->id }}</td>
                                            <td>{{ $course->intitule }}</td>
                                            <td>{{ $course->formation->intitule }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
