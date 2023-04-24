@extends('layouts.modele')

@section('content')
    <div class="container">
        <h1>Liste des séances de cours</h1>
        <a href="{{ route('sessions.planning') }}" class="btn btn-primary mb-3">Voir le planning</a>
        <a href="{{ route('sessions.create') }}" class="btn btn-primary mb-3">Creer une séance de cours</a>
        <div class="btn-group mb-3" role="group">
            <a href="{{ route('sessions.index') }}" class="btn btn-primary">Toutes les séances</a>
            <a href="{{ route('sessions.by_course') }}" class="btn btn-primary">Par cours</a>
            <a href="{{ route('sessions.by_week') }}" class="btn btn-primary">Par semaine</a>
          </div>
          <table class="table table-bordered table-striped">
            <!-- contenu de la table -->
          </table>
          
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    
                    <th>Intitulé du cours</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Enseignant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->intitule }}</td>
                        <td>{{ $session->date_debut }}</td>
                        <td>{{ $session->date_fin }}</td>
                        <td>{{ $session->prenom }} {{ $session->nom }}</td>
                        <td>
                            <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance de cours ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
