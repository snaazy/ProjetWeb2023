@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Liste des séances de cours</div>

                    <div class="card-body">
                        <a href="{{ route('sessions.create') }}" class="btn btn-primary mb-2">Créer une séance de cours</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Cours</th>
                                    <th scope="col">Enseignant</th>
                                    <th scope="col">Date de début</th>
                                    <th scope="col">Date de fin</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>{{ optional($session->course)->intitule }}</td>
                                        <td>{{ optional($session->course->user)->nom }}</td>
                                        <td>{{ $session->date_debut }}</td>
                                        <td>{{ $session->date_fin }}</td>
                                        
                                        <td>
                                            <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                            
                                            <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" class="d-inline">
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
                </div>
            </div>
        </div>
    </div>
@endsection
