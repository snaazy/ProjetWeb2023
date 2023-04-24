@extends('layouts.modele')

@section('content')
<div class="container">
    <h1>Modifier la séance de cours</h1>

    <form action="{{ route('sessions.update', $session->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="datetime-local" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" value="{{ old('date_debut', \Carbon\Carbon::parse($session->date_debut)->format('Y-m-d\TH:i:s')) }}" required>

            @error('date_debut')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="datetime-local" class="form-control @error('date_fin') is-invalid @enderror" name="date_fin" value="{{ old('date_fin', \Carbon\Carbon::parse($session->date_fin)->format('Y-m-d\TH:i:s')) }}" required>

            @error('date_fin')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
@endsection
