@extends('layouts.modele')

@section('content')
<div class="container">
    <h2>Créer un cours</h2>
    <form action="{{ route('cours.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="intitule">Intitulé</label>
            <input type="text" class="form-control" id="intitule" name="intitule" required>
        </div>
        <div class="form-group">
            <label for="formation_id">Formation</label>
            <select class="form-control" id="formation_id" name="formation_id" required>
                @foreach($formations as $formation)
                <option value="{{ $formation->id }}">{{ $formation->intitule }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Enseignant</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($enseignants as $enseignant)
                <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer le cours</button>
    </form>
</div>
@endsection
