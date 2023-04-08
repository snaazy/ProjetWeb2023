@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Ajouter une formation</h2>
                <form method="POST" action="{{ route('admin.formations.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="intitule">Intitulé</label>
                        <input type="text" name="intitule" id="intitule" class="form-control" value="{{ old('intitule') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary">Retour</a>
                </form>
            </div>
        </div>
    </div>
@endsection
