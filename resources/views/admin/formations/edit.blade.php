@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Modifier la formation</h2>
                <form method="POST" action="{{ route('admin.formations.update', $formation->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="intitule">Intitulé</label>
                        <input type="text" name="intitule" id="intitule" class="form-control"
                            value="{{ old('intitule', $formation->intitule) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                    <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary">Retour</a>
                </form>
            </div>
        </div>
    </div>
@endsection
