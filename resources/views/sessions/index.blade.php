@extends('layouts.modele')

@section('content')
    <style>
        .title {
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
            color: #4A4A4A;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .table {
            font-size: 14px;
            margin-bottom: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            text-align: left;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #4A4A4A;
            color: #fff;
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

        .btn-outline-primary {
            border-color: #4A4A4A;
            color: #4A4A4A;
        }

        .btn-outline-primary:hover {
            background-color: #4A4A4A;
            color: #fff;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
    </style>

    <div class="container">
        <h1 class="title">Liste des séances de cours</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('sessions.index') }}" class="btn btn-outline-primary"><i class="bi bi-list"></i> Toutes les
                séances</a>
            @if (Auth::user()->type == 'enseignant')
                <a href="{{ route('sessions.create') }}" class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i>
                    Créer une séance de cours</a>
            @endif
            <a href="{{ route('sessions.index', ['week' => 'current']) }}" class="btn btn-outline-primary"><i
                    class="bi bi-calendar-week"></i> Séances de la semaine</a>
            @if (Auth::user()->type == 'etudiant')
                <a href="{{ route('sessions.student_planning') }}" class="btn btn-outline-primary"><i
                        class="bi bi-plus-circle"></i>Voir le planning simplifié</a>
            @endif
            <a href="{{ route('sessions.index', ['sort_by_course' => 1]) }}" class="btn btn-outline-primary"><i
                    class="bi bi-sort-alpha-down"></i> Trier par cours</a>

        </div>

        @if ($sessions->isEmpty())
            <h2> Il n'y a aucune séance de cours programmées pour le moment.</h2>
        @else
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Intitulé du cours</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Enseignant</th>
                        @if (Auth::user()->type == 'enseignant' || Auth::user()->type == 'admin')
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessions as $session)
                        <tr>
                            <td>{{ $session->intitule }}</td>
                            <td>{{ \Carbon\Carbon::parse($session->date_debut)->format('d-m-Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($session->date_fin)->format('d-m-Y H:i') }}</td>
                            <td>{{ $session->prenom }} {{ $session->nom }}</td>
                            @if (Auth::user()->type == 'enseignant' || Auth::user()->type == 'admin')

                                <td>
                                    <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Modifier
                                    </a>
                                    <form action="{{ route('sessions.destroy', $session->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance de cours ?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach




                </tbody>
            </table>
            <br>
            <div class="d-flex justify-content-center">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
@endsection
