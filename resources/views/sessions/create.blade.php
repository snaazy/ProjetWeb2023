@extends('layouts.modele')

@section('content')

    <style>
        .form-label {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .custom-form-control {
            border-radius: 15px;
            background-color: #f8f9fa;
        }
    </style>

    <div class="bg-gradient-secondary min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h1 class="mb-4 text-center">Créer une nouvelle séance de cours</h1>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('sessions.store') }}">
                                @csrf

                                <div class="form-group mb-4">
                                    <label for="course" class="form-label"><i class="fas fa-book me-2"></i>Cours</label>
                                    <select
                                        class="form-control custom-form-control @error('course_id') is-invalid @enderror"
                                        id="course" name="course_id">
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->intitule }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="date_debut" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Date
                                        de début</label>
                                    <input type="datetime-local"
                                        class="form-control custom-form-control @error('date_debut') is-invalid @enderror"
                                        id="date_debut" name="date_debut" required onchange="updateEndDate(this)">
                                    @error('date_debut')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="date_fin" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Date de
                                        fin</label>
                                    <input type="datetime-local"
                                        class="form-control custom-form-control @error('date_fin') is-invalid @enderror"
                                        id="date_fin" name="date_fin" required>
                                    @error('date_fin')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group text-center">
                                    <br>
                                    <button type="submit" class="btn btn-primary mt-3">Créer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pour que la date de fin soit mise automatiquemet à la date de début -->
    <script>
        function updateEndDate(dateInput) {
            const endDateInput = document.querySelector("#date_fin");
            endDateInput.min = dateInput.value;
            endDateInput.value = dateInput.value;
        }
    </script>

@endsection
