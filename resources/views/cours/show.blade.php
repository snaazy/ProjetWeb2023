@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Détails du cours</h1>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $course->id }}</td>
                        </tr>
                        <tr>
                            <th>Intitulé</th>
                            <td>{{ $course->intitule }}</td>
                        </tr>
                        <tr>
                            <th>Enseignant</th>
                            <td>{{ $course->user->prenom }} {{ $course->user->nom }}</td>
                        </tr>
                        <tr>
                            <th>Formation</th>
                            <td>{{ $course->formation->intitule }}</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{ route('cours.index') }}" class="btn btn-primary">Retour à la liste des cours</a>
                <a href="{{ route('cours.edit', $course->id) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('cours.destroy', $course->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
