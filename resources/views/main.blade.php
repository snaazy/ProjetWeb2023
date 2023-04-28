@extends('layouts.modele')
@section('title', 'Accueil')
@section('content')
    <style>
        .u-planning-animation {
            animation: fadeInDown 2s ease-in-out;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-70px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .how-to-use {
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 0 20px;
        }

        .how-to-use h2 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .how-to-use .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .how-to-use .col-md-4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .how-to-use .col-md-4 .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            background-color: #007bff;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .how-to-use .col-md-4 .icon-container i {
            color: #ffffff;
            font-size: 2.5rem;
        }

        .how-to-use .col-md-4 h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .how-to-use .col-md-4 p {
            font-size: 1.2rem;
            line-height: 1.5;
        }


        .separator {
            width: 100%;
            border-bottom: 1px solid #ddd;
            margin-top: 50px;
            margin-bottom: 50px;
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-1 mb-5 u-planning-animation">U-Planning</h1>
                <div class="bg-light p-4">
                    <p class="lead mb-0">Bienvenue sur U-Planning, le site de consultation des plannings de formations. Rien
                        de compliqué, tout est très épuré et simple pour pouvoir consulter très facilement le planning.</p>
                </div>
                @if (auth()->check())
                    <div class="mt-5">
                        @if (auth()->user()->type === 'etudiant')
                            <a href="{{ route('sessions.student_planning') }}" class="btn btn-primary me-3">Voir le
                                planning</a>
                            <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma
                                formation</a>
                        @elseif(auth()->user()->type === 'enseignant')
                            <a href="{{ route('sessions.index') }}" class="btn btn-primary me-3">Voir le planning</a>
                            <a href="{{ route('student.courses') }}" class="btn btn-primary">Voir les cours de ma
                                formation</a>
                        @endif
                    </div>
                @endif
            </div>
        </div> <!-- fermeture de la première div row -->
        <!-- Ajout du séparateur -->



    </div>
    <div class="separator"></div>
    <!-- Section "Comment utiliser U-Planning ?" -->
    <div class="row how-to-use">
        <div class="col-md-12">
            <h2>Comment utiliser U-Planning ?</h2>
        </div>

        <div class="col-md-4">
            <div class="icon-container">
                <i class="fas fa-search"></i>
            </div>
            <h3>Rechercher une formation</h3>
            <p>Utilisez la barre de recherche pour trouver la formation qui vous intéresse. Vous pouvez filtrer les
                résultats en fonction de la ville, du domaine d'études, ou du niveau de formation.</p>
        </div>

        <div class="col-md-4">
            <div class="icon-container">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Consulter le planning</h3>
            <p>Une fois que vous avez trouvé la formation qui vous intéresse, cliquez sur le bouton "Voir le planning" pour
                consulter les horaires des cours et des examens.</p>
        </div>

        <div class="col-md-4">
            <div class="icon-container">
                <i class="fas fa-book-open"></i>
            </div>
            <h3>Voir les cours</h3>
            <p>Si vous êtes étudiant, vous pouvez également consulter la liste des cours de votre formation en cliquant sur
                le bouton "Voir les cours de ma formation".</p>
        </div>
    </div>
@endsection
