@extends('layouts.modele')

@section('title', 'Gestion des plannings')

@section('content')
    <div class="container my-4">
        <h2 class="text-center mb-4">Gestion des plannings</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Nouvelle séance de cours</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('planning.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="cours_id" class="form-label">Cours :</label>
                                <select class="form-select" id="cours_id" name="cours_id" required>
                                    <option selected disabled value="">Sélectionnez un cours</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->intitule }} - {{ $course->formation->intitule }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début :</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de fin :</label>
                                <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer une séance de cours</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Mes séances de cours</h4>
                    </div>
                    <div class="card-body">
                        @if(count($plannings) > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cours</th>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($plannings as $planning)
                                    <tr>
                                        <td>{{ $planning->id }}</td>
                                        @if($planning->course && $planning->course->formation)
                                            <td>{{ $planning->course->intitule }} - {{ $planning->course->formation->intitule }}</td>
                                        @else
                                            <td>{{ $planning->course->intitule }} - Formation introuvable</td>
                                        @endif
                                        <td>{{ $planning->date_debut->format('d/m/Y') }}</td>
                                        <td>{{ $planning->date_fin->format('d/m/Y') }}</td>
                                        <td>
                                            <form action="{{ route('planning.destroy', $planning->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                
                                </tbody>
                            </table>
                        @else
                            <p>Aucune séance de cours pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection