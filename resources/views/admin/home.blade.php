@extends('layouts.modele')
@section('title', 'Portail Admin')
@section('content')
<style>
.admin-portal {
min-height: 100vh;
padding: 20px;
background-color: #ffffff;
}
.option {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        transition: 0.3s ease;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .option:hover {
        transform: translateY(-5px);
    }

    .option-title {
        font-weight: bold;
        font-size: 28px;
        margin-bottom: 20px;
        margin-top: 0;
        color: #5a2d82;
    }

    .option-text {
        font-size: 18px;
        margin-bottom: 30px;
        color: #666;
    }

    .btn-lg {
        border-radius: 50px;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        padding: 15px 40px;
        margin-top: auto;
        transition: 0.3s ease;
        width: 100%;
        max-width: 300px;
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
        background-color: #7ac142;
        border-color: #7ac142;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #6ba038;
        border-color: #6ba038;
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

    .option-icon {
        font-size: 60px;
        margin-bottom: 20px;
    }

    .option-icon-1 {
        color: #0d6efd;
    }

    .option-icon-2 {
        color: #7ac142;
    }

    .option-icon-3 {
        color: #5a2d82;
    }

    .options-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 30px;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    @media only screen and (min-width: 768px) {
        .options-container {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .option {
            margin-right: 30px;
            margin-left: 30px;
        }
    }
</style>

<div class="container-fluid admin-portal">
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
            <h1 class="text-center display-3 fw-bold mb-5">Portail Administrateur</h1>
            </div>
            </div>
            <div class="options-container">
                <div class="option">
                    <i class="bi bi-people option-icon option-icon-1"></i>
                    <h2 class="option-title">Liste des utilisateurs</h2>
                    <p class="option-text">Voyez la liste des utilisateurs, modifiez leur type, approuvez ou refusez leurs
                        demandes d'inscription.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-lg btn-primary">Accéder</a>
                </div>
                <div class="option">
                    <i class="bi bi-calendar2-check option-icon option-icon-3"></i>
                    <h2 class="option-title">Liste des cours</h2>
                    <p class="option-text">Voyez la liste de tous les cours disponibles et gérez leur création.</p>
                    <a href="{{ route('cours.index') }}" class="btn btn-lg btn-primary">Accéder</a>
                </div>
                <div class="option">
                    <i class="bi bi-journal-plus option-icon option-icon-2"></i>
                    <h2 class="option-title">Créer une formation</h2>
                    <p class="option-text">Créez une nouvelle formation en renseignant son intitulé.</p>
                    <a href="{{ route('admin.formations.create') }}" class="btn btn-lg btn-success">Accéder</a>
                </div>
                <div class="option">
                    <i class="bi bi-journal-text option-icon option-icon-3"></i>
                    <h2 class="option-title">Liste des formations</h2>
                    <p class="option-text">Voyez la liste de toutes les formations créées et gérez leur modification et leur
                        suppression.</p>
                    <a href="{{ route('admin.formations.index') }}" class="btn btn-lg btn-primary">Accéder</a>
                </div>
                <div class="option">
                    <i class="bi bi-calendar2-check option-icon option-icon-1"></i>
                    <h2 class="option-title">Gestion des plannings</h2>
                    <p class="option-text">Visualisez toutes les séances de cours planifiées et gérez leur suppression ou modification.</p>
                    <a href="{{ route('planning.index') }}" class="btn btn-lg btn-info">Accéder</a>
                </div>
                <div class="option">
                    <i class="bi bi-person-plus option-icon option-icon-2"></i>
                    <h2 class="option-title">Créer un utilisateur</h2>
                    <p class="option-text">Créez un nouvel utilisateur en renseignant ses informations.</p>
                    <a href="{{ route('users.create') }}" class="btn btn-lg btn-success">Accéder</a>
                </div>
            </div>
        </div>
</div>
@endsection        
            
