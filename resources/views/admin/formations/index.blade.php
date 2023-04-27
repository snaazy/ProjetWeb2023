@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="my-4">Liste des formations</h2>
                <a href="{{ route('admin.formations.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i>
                    Ajouter une formation</a>
                @if(count($formations) == 0)
                    <div class="alert alert-info" role="alert">
                        Aucune formation trouvée.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Intitulé</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (['success', 'danger', 'warning', 'error'] as $alert)
                                    @if (session($alert))
                                        <div class="alert alert-{{ $alert }} alert-dismissible fade show" role="alert">
                                            {!! session($alert) !!}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                @endforeach
                                @foreach ($formations as $formation)
                                    <tr>
                                        <td>{{ $formation->id }}</td>
                                        <td>{{ $formation->intitule }}</td>
                                        <td>
                                            <a href="{{ route('admin.formations.edit', $formation->id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"></i> Modifier</a>
                                            <form method="POST"
                                                action="{{ route('admin.formations.destroy', $formation->id) }}"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation? Note: Si un étudiant ou plusieurs sont inscrits à cette formation, vous les affecterez au type null, et devront faire une nouvelle demande d\'inscription à une formation.')"><i
                                                            class="fas fa-trash"></i> Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
