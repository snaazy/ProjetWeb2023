@extends('layouts.modele')

@section('title', 'Profil')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <img class="rounded-circle mb-3" src="https://via.placeholder.com/150" alt="Profile picture" width="150">
                </div>
                <h1 class="text-center mb-4">{{ $user->prenom }} {{ $user->nom }}</h1>
                <p class="text-center text-muted">{{ $user->type }}</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-6">
                <div class="card mb-4" style="border-radius: 15px; background-color: #f1f1f1;">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <h3 class="card-title"><i class="fas fa-user"></i> Mes informations</h3>
                        <hr class="my-4" style="border-top: 1px solid #555;">
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
            </div>
            <div class="col-12 col-md-6">
                <div class="card mb-4" style="border-radius: 15px; background-color: #f1f1f1;">
                    <div class="card-body">
                        <h3 class="card-title"><i class="fas fa-book"></i> Mes cours</h3>
                        <hr class="my-4" style="border-top: 1px solid #555;">
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
                        @if (Auth::user()->type == 'enseignant')
                            <h3 class="card-title mt-4"><i class="fas fa-chalkboard-teacher"></i> Cours assignés</h3>
                            <p>Liste des cours dont je suis responsable </p>
                            <hr class="my-4" style="border-top: 1px solid #555;">
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
                <div class="col-md-15">
                    @if (Auth::user()->type == 'etudiant')
                        <div class="card mb-4" style="border-radius: 15px; background-color: #f1f1f1;">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Ma formation</h3>
                                <hr class="my-4" style="border-top: 1px solid #555;">
                                <div class="mb-3">
                                    <label for="formation" class="form-label">Formation :</label>
                                    <input type="text" class="form-control" id="formation"
                                        value="{{ $user->formation ? $user->formation->intitule : 'non-étudiant' }}"
                                        readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="promotion" class="form-label">Université :</label>
                                    <input type="text" class="form-control" id="promotion"
                                        value="Université Paris-Est Créteil" readonly>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @if (Auth::user()->type == 'enseignant')
                <div class="col-12 col-md-6">
                    <div class="card mb-4" style="border-radius: 15px; background-color: #f1f1f1;">
                        <div class="card-body">
                            <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Gestion de planning</h3>
                            <hr class="my-4" style="border-top: 1px solid #555;">
                            <a href="{{ route('planning.index') }}" class="btn btn-primary mt-3">Accéder à la gestion des
                                plannings</a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endsection
