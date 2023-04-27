@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h1 style="color: #007bff;">Liste des cours</h1>
                @foreach (['success', 'danger', 'warning'] as $alert)
                @if (session($alert))
                    <div class="alert alert-{{ $alert }} alert-dismissible fade show" role="alert">
                        {!! session($alert) !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach
                <a href="{{ route('cours.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Ajouter un cours</a>
                @if ($cours->isEmpty())
                    <p>Il n'y a pas de cours actuellement.</p>
                @else
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('cours.index') }}" method="GET" class="input-group mb-3">
                            <input type="text" name="q" class="form-control" placeholder="Rechercher un cours..." value="{{ request('q') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
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
                                        <a href="{{ route('cours.show', $course->id) }}" class="btn btn-info"><i class="fas fa-eye"></i> Voir</a>
                                        <a href="{{ route('cours.edit', $course->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Modifier</a>
                                        <form action="{{ route('cours.destroy', $course->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"><i class="fas fa-trash"></i> Supprimer</button>
                                        </form>
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
