@extends('layouts.modele')

@section('title', 'Accueil')

@section('content')

    <div class="container my-5">
        @if (Auth::guest() || auth()->user()->type === 'admin')
            <br>
            <br>
            <br>
        @endif

        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-1 mb-5 animate__animated animate__fadeInDown">U-Planning</h1>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-12">
                <p class="lead text-center">Bienvenue sur U-Planning, le site de consultation des plannings de formations.
                    Rien de compliqué, tout est très épuré et simple pour pouvoir consulter très facilement le planning.</p>
            </div>
        </div>

        @if (auth()->check() && (auth()->user()->type === 'etudiant' || auth()->user()->type === 'enseignant'))
            <div class="row my-5">
                <div class="col-md-12 text-center">
                    <h2 class="mb-4">Que souhaitez-vous faire ?</h2>
                    @if (auth()->user()->type === 'etudiant')
                        <a href="{{ route('sessions.student_planning') }}" class="btn btn-primary me-3">Voir le planning</a>
                        <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma formation</a>
                    @elseif(auth()->user()->type === 'enseignant')
                        <a href="{{ route('sessions.index') }}" class="btn btn-primary me-3">Voir le planning</a>
                        <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma formation</a>
                    @endif
                </div>
            </div>
        @endif
        <div class="row justify-content-center my-5">
            <div class="col-md-3">
                <div class="card border-0 bg-transparent text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt fa-3x mb-3" style="color: #6c278e;"></i>
                        <h3>Planifiez vos cours</h3>
                        <p>Consultez facilement le planning de vos cours.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-transparent text-center">
                    <div class="card-body">
                        <i class="fas fa-search fa-3x mb-3" style="color: #6c278e;"></i>
                        <h3>Recherchez des cours</h3>
                        <p>Explorez la liste des cours disponibles.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-transparent text-center">
                    <div class="card-body">
                        <i class="fas fa-user fa-3x mb-3" style="color: #6c278e;"></i>
                        <h3>Gérez votre compte</h3>
                        <p>Connectez-vous pour accéder à votre compte et consulter vos informations personnelles.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-transparent text-center">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap fa-3x mb-3" style="color: #6c278e;"></i>
                        <h3>Gérez les formations</h3>
                        <p>Créez, modifiez, supprimez des formations.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-transparent text-center">
                    <div class="card-body">
                        <i class="fas fa-users-cog fa-3x mb-3" style="color: #6c278e;"></i>
                        <h3>Gestion des utilisateurs</h3>
                        <p>En tant qu'admin vous avez une totale gestion sur les utilisateurs.</p>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection
