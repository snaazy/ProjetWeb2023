@extends('layouts.modele')

@section('content')
    <div class="container">
        <h1>Créer une nouvelle séance de cours</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sessions.store') }}">
            
            @csrf
        
            <div class="form-group">
                <label for="course">Cours</label>
                <select class="form-control" id="course" name="course_id">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->intitule }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required>
            </div>
        
            <div class="form-group">
                <label for="date_fin">Date de fin</label>
                <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
        
    </div>
@endsection
