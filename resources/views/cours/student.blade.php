@extends('layouts.modele')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Liste des cours de votre formation</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Intitulé</th>
                            <th>Enseignant</th>
                            <th>Formation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['success', 'danger', 'warning'] as $alert)
                        @if(session($alert))
                            <div class="alert alert-{{ $alert }}">{!! session($alert) !!}</div>
                        @endif
                    @endforeach
                    
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->intitule }}</td>
                        <td>{{ $course->user->nom }} {{ $course->user->prenom }}</td>
                        <td>{{ $course->formation->intitule }}</td>
                        <td>
                            @if(Auth::user()->courses->contains($course))
                                <button type="button" class="btn btn-success" disabled>Inscrit</button>
                            @else
                                <form method="POST" action="{{ route('student.enroll', $course->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if(Auth::user()->courses->contains($course))
                                <form method="POST" action="{{ route('student.unenroll', $course->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Se désinscrire</button>
                                </form>
                            @else
                                <button type="button" class="btn btn-secondary" disabled>Non inscrit</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                
                        <form method="GET" action="{{ route('student.courses') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Rechercher un cours par intitulé" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </div>
                        </form>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
