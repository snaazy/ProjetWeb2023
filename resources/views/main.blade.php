@extends('layouts.modele')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Planning</h1>
            <p>Sur ce site, vous pouvez consulter le planning des formations disponibles.</p>
            <a href="{{ route('planning') }}" class="btn btn-primary">Voir le planning</a>
        </div>
    </div>
</div>
@endsection
