@extends('layouts.modele')

@section('content')
<style>
.title {
    font-family: 'Montserrat', sans-serif;
    font-size: 3rem;
    color: #4A4A4A;
    padding: 20px;
}
.container {
    max-width: 1200px;
    margin: 0 auto;
}
.table {
    font-size: 14px;
    margin-bottom: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    text-align: left;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #4A4A4A;
    color: #fff;
    font-weight: bold;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}
.table-bordered {
    border: 1px solid #dee2e6;
}
.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6;
}
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}
.btn-outline-primary {
    border-color: #4A4A4A;
    color: #4A4A4A;
}
.btn-outline-primary:hover {
    background-color: #4A4A4A;
    color: #fff;
}
.btn-group {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}
</style>

<div class="container">
    <h1 class="title">Liste des séances de cours auxquelles je suis inscrit</h1>
    @if(Auth::user()->type == 'etudiant')
    <a href="{{ route('sessions.student_sessions') }}" class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i>Voir le planning simplifié</a>
@endif

    @if($sessions->isEmpty())
        <h2> Il n'y a aucune séance de cours programmées pour le moment.</h2>
    @else
    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Intitulé du cours</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Enseignant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->intitule }}</td>
                        <td>{{ \Carbon\Carbon::parse($session->date_debut)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($session->date_fin)->format('d-m-Y H:i') }}</td>
                        <td>{{ $session->prenom }} {{ $session->nom }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
      
    @endif
</div>
@endsection
