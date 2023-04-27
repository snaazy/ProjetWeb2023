@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white text-center pb-0">
                        <h1 class="display-5">Se connecter</h1>
                        <p class="text-muted">Entrez votre login et votre mot de passe pour accéder à votre compte.</p>
                    </div>
                    <div class="card-body px-4">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @foreach (['success', 'danger', 'warning'] as $alert)
                            @if (session($alert))
                                <div class="alert alert-{{ $alert }}">{!! session($alert) !!}</div>
                            @endif
                        @endforeach

                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label class="form-label">Login</label>
                                <input type="text" name="login" class="form-control rounded-pill"
                                    value="{{ old('login') }}">
                                @error('login')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="mdp" class="form-control rounded-pill">
                                @error('mdp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary btn-block rounded-pill">Se connecter</button>
                            </div>

                            @if (Route::has('password.request'))
                                <p class="text-center"><a class="link-primary" href="{{ route('password.request') }}">Mot de
                                        passe oublié ?</a></p>
                            @endif
                        </form>
                    </div>

                    <div class="card-footer bg-white text-center pt-0">
                        <p class="mb-0">Vous n'avez pas de compte ? <a href="{{ route('register') }}"
                                class="link-primary">S'enregistrer</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
