@extends('layouts.modele')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Gestion des utilisateurs</h2>
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="form-group">
                    <label for="search">Recherche</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nom, prénom ou login">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Tous les types</option>
                        <option value="etudiant" {{ request('type') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="enseignant" {{ request('type') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                        <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Login</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->prenom }}</td>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->type }}</td>
                        <td>
                            @if($user->type === null)
                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                @csrf
                                <select name="type" required>
                                    <option value="etudiant">Étudiant</option>
                                </select>
                                <button type="submit" class="btn btn-success">Approuver</button>
                            </form>
                            
                               
                                <form action="{{ route('admin.users.refuse', $user->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Refuser</button>
                                </form>
                                

                            @endif
                        </td>
                        <td>
                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">                               
                                        <select name="type" required>
                                            <option value="">Sélectionner un type</option>
                                            <option value="etudiant" {{ $user->type == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                            <option value="enseignant" {{ $user->type == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                            <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
                
            </div>
        </div>
    </div>
    @endsection
    
                   
