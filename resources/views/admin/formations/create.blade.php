@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h2 class="text-center mb-5">Ajouter une formation</h2>
                <div class="d-flex justify-content-center">
                    <form method="POST" action="{{ route('admin.formations.store') }}" class="p-5 shadow">
                        @csrf
                        <div class="form-group">
                            <label for="intitule" class="h4">Intitulé de la formation</label>
                            <input type="text" name="intitule" id="intitule" class="form-control form-control-lg"
                                value="{{ old('intitule') }}" required>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mx-3">Ajouter la formation</button>
                            <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary mx-3">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
