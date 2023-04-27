@extends('layouts.modele')

@section('content')
    <style>
        .admin-portal {
            min-height: 100vh;
            padding: 20px;
            background-color: #ffffff;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .card-text {
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
            color: #666;
        }

        .btn-lg {
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 15px 40px;
            margin-top: auto;
        }

        .btn-primary {
            background-color: #5a2d82;
            border-color: #5a2d82;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #4e256f;
            border-color: #4e256f;
            color: #fff;
        }

        .btn-success {
            background-color: #5a2d82;
            border-color: #5a2d82;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #4e256f;
            border-color: #4e256f;
            color: #fff;
        }

        .btn-info {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .btn-info:hover {
            background-color: #0a58ca;
            border-color: #0a58ca;
            color: #fff;
        }

        .card-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: #5a2d82;
        }
    </style>

    <div class="container-fluid admin-portal">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <h1 class="text-center mb-5">Portail Administrateur</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="bi bi-people card-icon"></i>
                            <h2 class="card-title">Liste des utilisateurs</h2>
                            <p class="card-text">Voyez la liste des utilisateurs, modifiez leur type, approuvez ou refusez
                                leurs demandes d'inscription.</p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-lg btn-primary">Accéder</a>
                        </div>
                    </div>
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="bi bi-calendar2-check card-icon"></i>
                            <h2 class="card-title">Liste des cours</h2>
                            <p class="card-text">Voyez la liste de tous les cours disponibles et gérez leur inscription.</p>
                            <a href="{{ route('cours.index') }}" class="btn btn-lg btn-info">Accéder</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="bi bi-journal-plus card-icon"></i>
                            <h2 class="card-title">Créer une formation</h2>
                            <p class="card-text">Créez une nouvelle formation en renseignant son intitulé et sa description.
                            </p>
                            <a href="{{ route('admin.formations.create') }}" class="btn btn-lg btn-success">Accéder</a>
                        </div>
                    </div>
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="bi bi-journal-text card-icon"></i>
                            <h2 class="card-title">Liste des formations</h2>
                            <p class="card-text">Voyez la liste de toutes les formations créées et gérez leur modification
                                et leur suppression.</p>
                            <a href="{{ route('admin.formations.index') }}" class="btn btn-lg btn-info">Accéder</a>
                        </div>
                    </div>
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="bi bi-calendar2-check card-icon"></i>
                            <h2 class="card-title">Gestion des plannings</h2>
                            <p class="card-text">Voyez la liste de tous les cours disponibles et gérez leur inscription.</p>
                            <a href="" class="btn btn-lg btn-info">Accéder</a>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
@endsection
