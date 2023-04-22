@extends('layouts.modele')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Portail Administrateur</h1>
            <div class="d-flex justify-content-center mt-5">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg mr-3">Liste des utilisateurs</a>
                <a href="{{ route('admin.formations.create') }}" class="btn btn-success btn-lg mr-3">Créer une formation</a>
                <a href="{{ route('cours.index') }}" class="btn btn-info btn-lg">Liste des cours</a>
                <a href="{{ route('admin.formations.index') }}" class="btn btn-info btn-lg">Liste des formations</a>
            </div>
        </div>
    </div>
</div>
@endsection
