@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h1>Liste des cours</h1>
                @foreach(['success', 'danger', 'warning'] as $alert)
                @if(session($alert))
                    <div class="alert alert-{{ $alert }}">{!! session($alert) !!}</div>
                @endif
            @endforeach
                <a href="{{ route('cours.create') }}" class="btn btn-primary mb-3">Ajouter un cours</a>
                @if ($cours->isEmpty())
                    <p>Il n'y a pas de cours actuellement.</p>
                @else
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
                            @foreach($cours as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->intitule }}</td>
                                    <td>{{ $course->user->prenom }} {{ $course->user->nom }}</td>
                                    <td>{{ $course->formation->intitule }}</td>
                                    <td>
                                        <a href="{{ route('cours.show', $course->id) }}" class="btn btn-info">Voir</a>
                                        <a href="{{ route('cours.edit', $course->id) }}" class="btn btn-warning">Modifier</a>
                                        <form action="{{ route('cours.destroy', $course->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
