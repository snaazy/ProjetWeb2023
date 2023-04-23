@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Modifier le cours "{{ $course->intitule }}"</h1>
                <form method="POST" action="{{ route('cours.update', $course->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="intitule">Intitulé du cours :</label>
                        <input type="text" class="form-control" id="intitule" name="intitule" value="{{ old('intitule', $course->intitule) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="enseignant">Enseignant :</label>
                        <select class="form-control" id="enseignant" name="user_id" required>
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" @if($enseignant->id === $course->user->id) selected @endif>{{ $enseignant->prenom }} {{ $enseignant->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('cours.show', $course->id) }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection