@extends('layouts.modele')

@section('content')
    <div class="container">
        <h2 class="text-center mb-5 title">Liste des cours de votre formation</h2>

        @foreach(['success', 'danger', 'warning'] as $alert)
            @if(session($alert))
                <div class="alert alert-{{ $alert }}">{!! session($alert) !!}</div>
            @endif
        @endforeach

        <form method="GET" action="{{ route('student.courses') }}" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Rechercher un cours par intitulé" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Rechercher</button>
                </div>
            </div>
        </form>

        @foreach($courses as $course)
            <div class="mb-5">
                <h3 class="font-weight-bold text-primary display-4" style="font-family: 'Montserrat', sans-serif;">
                    <span class="animate__animated animate__fadeInLeft">{{ $course->intitule }}</span>
                </h3>
                <p style="font-family: 'Montserrat', sans-serif;">
                    <i class="fas fa-chalkboard-teacher"></i> <strong>Enseignant :</strong> {{ $course->user->nom }} {{ $course->user->prenom }}
                </p>
                <p style="font-family: 'Montserrat', sans-serif;">
                    <i class="fas fa-graduation-cap"></i> <strong>Formation :</strong> {{ $course->formation->intitule }}
                </p>
                <p style="font-family: 'Montserrat', sans-serif;">
                    <i class="fas fa-list-ol"></i> <strong>ID :</strong> {{ $course->id }}
                </p>

                <div class="d-flex justify-content-between">
                    @if(Auth::user()->courses->contains($course))
                        <button type="button" class="btn btn-success" disabled><i class="fas fa-check"></i> Inscrit</button>
                    @else
                        <form method="POST" action="{{ route('student.enroll', $course->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> S'inscrire</button>
                        </form>
                        @endif
                        @if(Auth::user()->courses->contains($course))
                        <form method="POST" action="{{ route('student.unenroll', $course->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger"><i class="fas fa-user-minus"></i> Se désinscrire</button>
                        </form>
                    @else
                        <button type="button" class="btn btn-secondary" disabled><i class="fas fa-times"></i> Non inscrit</button>
                    @endif
                </div>
            </div>
            <hr>
        @endforeach
    </div>

    <style>
        .title {
            padding: 30px;
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
  
        }
    </style>

@endsection    
                        
