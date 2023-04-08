@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{ old('nom') }}">
                            </div>
                            @if ($errors->has('nom'))
                              <span class="text-danger">{{ $errors->first('nom') }}</span>
                             @endif
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}">
                            </div>
                            @if ($errors->has('prenom'))
                            <span class="text-danger">{{ $errors->first('prenom') }}</span>
                           @endif
                            <div class="form-group">
                                <label for="text" class="form-label font-weight-bold">Login</label>
                                <input type="text" name="login" class="form-control" id="password">
                              </div>
                              @if ($errors->has('login'))
                              <span class="text-danger">{{ $errors->first('login') }}</span>
                             @endif

                            <div class="form-group">
                                <label for="text" class="form-label font-weight-bold">MDP</label>
                                <input type="password" name="mdp" class="form-control" id="password">
                              </div>  
                              @if ($errors->has('mdp'))
                              <span class="text-danger">{{ $errors->first('mdp') }}</span>
                             @endif                      
                                <div class="form-group">
                                    <label class="form-label">Formation</label>
                                    <select name="formation_id" class="form-control">
                                        <option value="">Sélectionnez votre formation (optionnel pour les enseignants et les admins)</option>
                                        @foreach($formations as $formation)
                                            <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>{{ $formation->intitule }}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Créer un compte</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
