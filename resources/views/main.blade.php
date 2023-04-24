@extends('layouts.modele')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Planning</h1>
            <p>Sur ce site, vous pouvez consulter le planning des formations disponibles.</p>
            @if(auth()->check())
            @if(auth()->user()->type === 'etudiant')
                <a href="{{ route('sessions.student_planning') }}" class="btn btn-primary">Voir le planning</a>
                <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma formation</a>
            @elseif(auth()->user()->type === 'enseignant')
                <a href="{{ route('sessions.index') }}" class="btn btn-primary">Voir le planning</a>
                <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma formation</a>
            @endif
        @endif
        
        </div>
    </div>
</div>
@endsection
