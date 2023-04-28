@extends('layouts.modele')
@section('title', 'Liste des cours')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h1 class="text-center" style="color: #000000;">Liste des cours</h1>


                @foreach (['success', 'danger', 'warning'] as $alert)
                    @if (session($alert))
                        <div class="alert alert-{{ $alert }} alert-dismissible fade show" role="alert">
                            {!! session($alert) !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                @endforeach
                <a href="{{ route('cours.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Ajouter un
                    cours</a>
                @if ($cours->isEmpty())
                    <p>Il n'y a pas de cours actuellement.</p>
                @else
                    <div class="row justify-content-between">
                        <div class="col-md-6 mb-3">
                            <form action="{{ route('cours.index') }}" method="GET" class="input-group">
                                <input type="text" name="q" class="form-control"
                                    placeholder="Rechercher un cours..." value="{{ request('q') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('cours.index') }}" method="GET" class="input-group">
                                <select class="form-control" name="enseignant">
                                    <option value="">Tous les enseignants</option>
                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}"
                                            {{ request('enseignant') == $enseignant->id ? 'selected' : '' }}>
                                            {{ $enseignant->prenom }} {{ $enseignant->nom }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Filtrer</button>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Filtrer par enseignant</span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Intitulé</th>
                                <th>Enseignant</th>
                                <th>Formation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cours as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->intitule }}</td>
                                    <td>{{ $course->user->prenom }} {{ $course->user->nom }}</td>
                                    <td>{{ $course->formation->intitule }}</td>
                                    <td>
                                        <div class="d-flex justify-content-around">
                                            <a href="{{ route('cours.edit', $course->id) }}" class="btn btn-warning"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <form action="{{ route('cours.destroy', $course->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center pagination-custom">
                        {{ $cours->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
