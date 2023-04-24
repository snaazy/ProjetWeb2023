@extends('layouts.modele')

@section('content')
    <style>
        .title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            color: #4A4A4A;
        }
        .table {
            font-size: 14px;
            margin-bottom: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: .5rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <div class="container">
        <h1 class="title">Liste des séances de cours</h1>
        <div class="btn-group mb-3" role="group">
            <a href="{{ route('sessions.index') }}" class="btn btn-outline-primary"><i class="bi bi-list"></i> Toutes les séances</a>
            <a href="{{ route('sessions.planning') }}" class="btn btn-outline-primary"><i class="bi bi-calendar3"></i> Voir le planning</a>
            <a href="{{ route('sessions.create') }}" class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i> Creer une séance de cours</a>
        </div>
        <table class="table table-bordered table-striped table-hover">
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
                            <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </a>
                            <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance de cours ?')">
                                    <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                    </form>
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                                   
                                   
               <br>                     
    <div class="d-flex justify-content-center">
        {{ $sessions->links() }}
    </div>
                                  
                                    </div>
                                    @endsection
