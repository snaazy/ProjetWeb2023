@extends('layouts.modele')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-1 mb-5">U-Planning</h1>
           
            <div class="bg-light p-4">
                <p class="lead mb-0">Bienvenue sur U-Planning, le site de consultation des plannings de formations. Rien de compliqué, tout est très épuré et simple pour pouvoir consulter très facilement le planning.</p>
            </div>
            @if(auth()->check())
                <div class="mt-5">
                    @if(auth()->user()->type === 'etudiant')
                        <a href="{{ route('sessions.student_planning') }}" class="btn btn-primary me-3">Voir le planning</a>
                        <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma formation</a>
                    @elseif(auth()->user()->type === 'enseignant')
                        <a href="{{ route('sessions.index') }}" class="btn btn-primary me-3">Voir le planning</a>
                        <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma formation</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection