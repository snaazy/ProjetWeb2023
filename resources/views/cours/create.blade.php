@extends('layouts.modele')

@section('content')
<div class="container">
    <br>
    <h2 class="text-center mb-5">Créer un cours</h2>
    <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('cours.store') }}" class="p-5 shadow">
            @csrf
            <div class="form-group">

                <label for="intitule" class="h4">Intitulé du cours</label>
                <input type="text" name="intitule" id="intitule" class="form-control form-control-lg" value="{{ old('intitule') }}" required>
            </div>
            <div class="form-group">
                <label for="formation_id" class="h4">Formation</label>
                <select class="form-control form-control-lg" id="formation_id" name="formation_id" required>
                    @foreach($formations as $formation)
                    <option value="{{ $formation->id }}">{{ $formation->intitule }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id" class="h4">Enseignant</label>
                <select class="form-control form-control-lg" id="user_id" name="user_id" required>
                    @foreach($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group d-flex justify-content-center mt-5">
                <button type="submit" class="btn btn-primary mx-3">Créer le cours</button>
                <a href="{{ route('cours.index') }}" class="btn btn-secondary mx-3">Retour</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    form {
        max-width: 600px;
        margin: 0 auto;
    }
</style>
@endsection
