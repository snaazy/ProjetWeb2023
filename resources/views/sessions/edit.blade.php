@extends('layouts.modele')

@section('content')

<div class="bg-gradient-secondary min-vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg">
          <div class="card-body">
            <h1 class="mb-4 text-center">Modifier la séance de cours</h1>
            <form action="{{ route('sessions.update', $session->id) }}" method="POST">
              @csrf
              @method('PUT')
    
              <div class="form-group">
                <label for="date_debut"><i class="fas fa-calendar-alt mr-1"></i>Date de début</label>
                <input type="datetime-local" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" value="{{ old('date_debut', \Carbon\Carbon::parse($session->date_debut)->format('Y-m-d\TH:i:s')) }}" required>
    
                @error('date_debut')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="form-group">
                <label for="date_fin"><i class="fas fa-calendar-alt mr-1"></i>Date de fin</label>
                <input type="datetime-local" class="form-control @error('date_fin') is-invalid @enderror" name="date_fin" value="{{ old('date_fin', \Carbon\Carbon::parse($session->date_fin)->format('Y-m-d\TH:i:s')) }}" required>
    
                @error('date_fin')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="form-group text-center">
                <br>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Modifier</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
