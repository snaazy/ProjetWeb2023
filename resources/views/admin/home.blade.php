@extends('layouts.modele')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-5">Portail Administrateur</h1>
            <div class="d-flex justify-content-center flex-wrap mb-5">
                <div class="card m-3 shadow">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h2 class="card-title text-center mb-4">Liste des utilisateurs</h2>
                        <p class="card-text text-center mb-4">Voyez la liste des utilisateurs, modifiez leur type, approuvez ou refusez leurs demandes d'inscription.</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg btn-block">Accéder</a>
                    </div>
                </div>
                <div class="card m-3 shadow">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h2 class="card-title text-center mb-4">Créer une formation</h2>
                        <p class="card-text text-center mb-4">Créez une nouvelle formation en renseignant son intitulé et sa description.</p>
                        <a href="{{ route('admin.formations.create') }}" class="btn btn-success btn-lg btn-block">Accéder</a>
                    </div>
                </div>
                <div class="card m-3 shadow">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h2 class="card-title text-center mb-4">Liste des cours</h2>
                        <p class="card-text text-center mb-4">Voyez la liste de tous les cours disponibles et gérez leur inscription.</p>
                        <a href="{{ route('cours.index') }}" class="btn btn-info btn-lg btn-block">Accéder</a>
                    </div>
                </div>
                <div class="card m-3 shadow">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h2 class="card-title text-center mb-4">Liste des formations</h2>
                        <p class="card-text text-center mb-4">Voyez la liste de toutes les formations créées et gérez leur modification et leur suppression.</p>
                        <a href="{{ route('admin.formations.index') }}" class="btn btn-info btn-lg btn-block">Accéder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
