@extends('layouts.modele')
@section('title', 'Modifier une formation')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-5" style="font-size: 2.5rem;">Modifier la formation</h2>
                <form method="POST" action="{{ route('admin.formations.update', $formation->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="intitule" class="form-label">Intitulé</label>
                        <input type="text" name="intitule" id="intitule" class="form-control"
                            value="{{ old('intitule', $formation->intitule) }}" required>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
                        <button type="submit" class="btn btn-primary me-md-2">Modifier</button>
                        <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
