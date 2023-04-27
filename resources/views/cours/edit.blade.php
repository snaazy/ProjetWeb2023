@extends('layouts.modele')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 my-4">
            <div class="card">
                <div class="card-header">{{ __('Modifier le cours "') }}{{ $course->intitule }}{{ __('"') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cours.update', $course->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="intitule" class="col-md-4 col-form-label text-md-right">{{ __('Intitulé du cours :') }}</label>

                            <div class="col-md-6">
                                <input id="intitule" type="text" class="form-control @error('intitule') is-invalid @enderror" name="intitule" value="{{ old('intitule', $course->intitule) }}" required autofocus>

                                @error('intitule')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="enseignant" class="col-md-4 col-form-label text-md-right">{{ __('Enseignant :') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('user_id') is-invalid @enderror" id="enseignant" name="user_id" required>
                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}" @if ($enseignant->id === $course->user->id) selected @endif>
                                            {{ $enseignant->prenom }} {{ $enseignant->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enregistrer') }}
                                </button>
                                <a href="{{ route('cours.index', $course->id) }}" class="btn btn-secondary">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
