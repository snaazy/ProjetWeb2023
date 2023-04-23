@extends('layouts.modele')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Créer une nouvelle séance de cours pour "{{ $course->intitule }}"</h1>
            <form method="POST" action="{{ route('plannings.store') }}">
                @csrf
                <input type="hidden" name="cours_id" value="{{ $course->id }}">
                <div class="form-group">
                    <label for="date_debut">Date de début :</label>
                    <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required>
                </div>
                <div class="form-group">
                    <label for="date_fin">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" value="{{ old('date_fin') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('planning.byCourse', $course->id) }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
