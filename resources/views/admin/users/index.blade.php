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
                                        <option value="enseignant">Enseignant</option>
                                    </select>
                                    <button type="submit" class="btn btn-success">Approuver</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endsection
    
                   
