<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap-theme.min.css" rel="stylesheet" integrity="sha384-QhE7VdpHJc8MYj0MjvzAaztT3q3sd8j7VXonvBdD7+mrv75bgpM4i4v4F1zmIm+" crossorigin="anonymous">
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Mon projet</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                @guest()
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">S'enregistrer</a>
                </li>
                <div class="vr"></div>
                @endguest
                
                @auth
            <li class="nav-item">
              <a class="nav-link">Mes Commandes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('profil') }}">Mon profil</a>
        </li>
          <div class="vr"></div>
          <div class="vr"></div>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
              </svg></a>
          </li>
          @endauth
          @if(auth()->check() && auth()->user()->isAdmin())
          <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.users.index') }}">Portail Admin</a>
          </li>  
          <div class="vr"></div>          
          @endif
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>


</body>
</html>
