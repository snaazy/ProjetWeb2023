@extends('layouts.modele')

@section('content')
<div class="container">
    <h1>Mon planning</h1>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('sessions.student_planning', ['week' => $week - 1]) }}" class="week-change">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L6.707 8l4.647 4.646a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708 0z"/>
                </svg>
            </a>
            <span>Semaine {{ $week }}</span>
            <a href="{{ route('sessions.student_planning', ['week' => $week + 1]) }}" class="week-change">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </a>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Heures</th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>
                <th>Dimanche</th>
            </tr>
        </thead>
        <tbody>
            @for ($heure = 8; $heure <= 19; $heure++)
                <tr>
                    <td>{{ $heure }}:00 - {{ $heure + 1 }}:00</td>
                    @for ($jour = 1; $jour <= 7; $jour++)
                        <td>
                            @php
                                $sessionTrouvee = false;
                            @endphp
                            @foreach($sessions as $session)
                            @php
                                $dateDebut = new DateTime($session->date_debut);
                                $heureDebut = $dateDebut->format('G');
                            @endphp
                                 @if($dateDebut->format('W') == $week && $dateDebut->format('N') == $jour && $heureDebut == $heure)
                                <div class="bg-info text-white p-2">
                                    {{ $session->intitule }}<br>
                                    {{ $session->prenom }} {{ $session->nom }}<br>
                                    {{ date('H:i', strtotime($session->date_debut)) }} - {{ date('H:i', strtotime($session->date_fin)) }}
                                </div>
                                
                                
                                    @php
                                        $sessionTrouvee = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                            @if(!$sessionTrouvee)
                                &nbsp;
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<style>
  table {
    border-collapse: collapse;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    table-layout: fixed;
    width: 100%; /* Largeur fixe pour le tableau */
    margin-left: 0%; /* Permet de centrer le tableau horizontalement */
}

thead tr {
    background-color: #343a40;
    color: rgb(251, 251, 251);
}

td, th {
    height: 50px;
    padding: 10px;
    text-align: center;
}

th:first-child,
td:first-child {
    font-weight: bold;
    background-color: #f5f5f5;
    color: black;
}

h1{
    padding: 16px;
}

td {
    position: relative;
}

td:not(:first-child):before {
    content: "";
    position: absolute;
    top: -10px;
    bottom: -10px;
    left: 0;
    width: 1px;
    background-color: #ddd;
}
.bg-info {
    background-color: #5fa1bb !important;
    color: #fff;
}

.p-2 {
    padding: 1rem !important;
}

.container h1 {
    margin-top: 1rem;
}
.col-md-12 {
    display: flex;
    justify-content: center;
    align-items: center;
}
h2 {
    margin-top: 0.5rem;
    margin-bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}
.fa-chevron-left,
.fa-chevron-right {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2rem;
}
.btn {
    margin: 0 0.5rem;
}
    </style>

@endsection
