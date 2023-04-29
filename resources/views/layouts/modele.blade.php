<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap-theme.min.css" rel="stylesheet"
        integrity="sha384-QhE7VdpHJc8MYj0MjvzAaztT3q3sd8j7VXonvBdD7+mrv75bgpM4i4v4F1zmIm+" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">


</head>
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSGFpoO9xO8x+qlK59rh+KkhLTSR7OwRjSE1zmG//ffjjGPJU9U" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
    integrity="sha384-eMNCOe7tC1doHpGoJtKh7z7lGz7fuP4F8nfdFvAOA6Gg/z6Y5J6XqqyGXYM2ntX1" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xM6Qhm1B6" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/bootstrap-icons.min.js"></script>

<style>
    .navbar {
        background: linear-gradient(90deg, rgb(82, 34, 106) 0%, rgb(96, 62, 155) 100%);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        padding: 0.5rem 1rem;

    }

    .navbar-brand,
    .nav-link {
        color: #fff !important;
        transition: color 0.3s;
    }

    .nav-link:hover {
        color: #e5e5e5 !important;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30' width='30' height='30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .navbar-collapse {
        justify-content: flex-end;
    }

    .navbar-nav {
        align-items: center;
        margin-right: -15px;
    }

    .nav-item {
        margin-left: 15px;
        margin-right: 15px;
    }

    .navbar-toggler {
        border: none;
    }

    .btn-primary {
        background-color: rgb(82, 34, 106);
        border-color: rgb(82, 34, 106);
    }

    .btn-primary:hover {
        background-color: #6c278e;
        border-color: #6c278e;
    }

    .form-control:focus {
        border-color: #7f7fd5;
        box-shadow: 0 0 0 0.2rem rgba(127, 127, 213, 0.25);
    }

    .footer {
        background-color: #6c278e;
        color: #ffffff;
        padding: 0.5rem 1rem;
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;


    }

    .page-content {
        padding-bottom: 60px;
    }

    .btn-deconnexion {
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
    }

    .btn-deconnexion:focus,
    .btn-deconnexion:hover {
        background-color: #6c278e;
        color: white;
    }

    .btn-profile {
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
    }

    .btn-profile:focus,
    .btn-profile:hover {
        background-color: #6c278e;
        color: white;
    }

    .pagination-custom .page-link {
        background-color: #6c278e;
        border-color: #ffffff;
        color: #fff;
    }

    .pagination-custom .page-link:hover {
        background-color: #783798;
        border-color: #6f42c1;
        color: #fff;
    }
</style>



</head>

<body class="@yield('body-class')">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">U-Planning</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('main') }}">Accueil</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">S'enregistrer</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item btn-profile" href="{{ route('profil') }}">Mon profil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item btn-deconnexion">
                                            <i class="bi bi-box-arrow-right"></i> Se déconnecter
                                        </button>
                                    </form>

                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->type == 'enseignant')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('planning.index') }}">Gestion de planning</a>
                            </li>
                        @endif
                        @if (auth()->check() &&
                                auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.home') }}">Portail Admin</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="container page-content">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2023 Planning - Tous droits réservés.</p>
        </div>
    </footer>
</body>

</html>
