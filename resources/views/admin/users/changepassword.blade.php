@extends('layouts.modele')
@section('title', 'Changer MDP')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Modifier le mot de passe') }}</div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.users.changepassword', $user->id) }}">
                            @csrf
                            @method('POST')


                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label"
                                    style="font-weight: bold; margin-bottom: 8px; display: block;">{{ __('Nouveau mot de passe') }}</label>
                                <input type="password" class="form-control" name="new_password"
                                    placeholder="{{ __('Entrez votre nouveau mot de passe') }}">
                                @error('new_password')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label"
                                    style="font-weight: bold; margin-bottom: 8px; display: block;">{{ __('Confirmez votre nouveau mot de passe') }}</label>
                                <input type="password" class="form-control" name="new_password_confirmation"
                                    placeholder="{{ __('Confirmez votre nouveau mot de passe') }}">
                                @error('new_password_confirmation')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" value="{{ __('Envoyer') }}"
                                    class="btn btn-primary btn-lg">{{ __('Modifier le mot de passe') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
