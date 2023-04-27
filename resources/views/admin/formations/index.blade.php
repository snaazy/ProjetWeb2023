@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h2>Liste des formations</h2>
                <a href="{{ route('admin.formations.create') }}" class="btn btn-primary mb-3">Ajouter une formation</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Intitulé</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formations as $formation)
                            <tr>
                                <td>{{ $formation->id }}</td>
                                <td>{{ $formation->intitule }}</td>
                                <td>
                                    <a href="{{ route('admin.formations.edit', $formation->id) }}"
                                        class="btn btn-warning">Modifier</a>
                                    <form method="POST" action="{{ route('admin.formations.destroy', $formation->id) }}"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?');">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
