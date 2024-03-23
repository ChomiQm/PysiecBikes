@extends('layouts.app')

@section('content')
    @vite(['resources/sass/register.scss'])
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Rejestracja</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" class="form-container" autocomplete="on">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- Step 1: User Credentials -->
                            <div id="step1" class="form-step full-width-inputs">
                                <!-- Nickname -->
                                <div class="form-group">
                                    <label for="email">Nazwa użytkownika
                                        <input type="text" class="form-control" name="name" required autofocus>
                                    </label>
                                </div>
                                <!-- Email Address -->
                                <div class="form-group">
                                    <label for="email">Adres Email
                                        <input type="email" class="form-control" name="email" required autofocus>
                                    </label>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Hasło
                                        <input type="password" class="form-control" name="password" required>
                                    </label>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password-confirm">Potwierdź Hasło
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="showStep(2)">Dalej</button>
                                </div>
                            </div>

                            <!-- Step 2: User Personal Data -->
                            <div id="step2" class="form-step side-by-side-inputs" style="visibility: hidden; position: absolute;">
                                <!-- First Name -->
                                <div class="form-group">
                                    <label for="first_name">Imię
                                        <input type="text" class="form-control" name="first_name" required>
                                    </label>
                                </div>

                                <!-- Last Name -->
                                <div class="form-group">
                                    <label for="last_name">Nazwisko
                                        <input type="text" class="form-control" name="last_name" required>
                                    </label>
                                </div>

                                <!-- Country -->
                                <div class="form-group">
                                    <label for="country">Kraj
                                        <input type="text" class="form-control" name="country" required>
                                    </label>
                                </div>

                                <!-- State -->
                                <div class="form-group">
                                    <label for="state">Województwo
                                        <input type="text" class="form-control" name="state" required>
                                    </label>
                                </div>

                                <!-- City -->
                                <div class="form-group">
                                    <label for="city">Miasto
                                        <input type="text" class="form-control" name="city" required>
                                    </label>
                                </div>

                                <!-- Street Address -->
                                <div class="form-group">
                                    <label for="street_address">Adres
                                        <input type="text" class="form-control" name="street_address" required>
                                    </label>
                                </div>

                                <!-- Postal Code -->
                                <div class="form-group">
                                    <label for="postal_code">Kod pocztowy
                                        <input type="text" class="form-control" name="postal_code" required>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary" onclick="showStep(1)">Wstecz</button>
                                    <button type="submit" class="btn btn-success">Zarejestruj się</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function saveData(step) {
            // Pobierz wszystkie inputy z obecnego kroku i zapisz ich wartości w Local Storage
            const inputs = document.querySelectorAll('#step' + step + ' input');
            inputs.forEach(input => {
                localStorage.setItem(input.name, input.value);
            });
        }

        function loadData(step) {
            // Załaduj dane dla obecnego kroku z Local Storage i wstaw je do inputów
            const inputs = document.querySelectorAll('#step' + step + ' input');
            inputs.forEach(input => {
                if (localStorage.getItem(input.name)) {
                    input.value = localStorage.getItem(input.name);
                }
            });
        }

        function showStep(stepNumber) {
            // Ukryj wszystkie kroki
            var steps = document.querySelectorAll('.form-step');
            steps.forEach(function(step) {
                step.style.visibility = 'hidden';
                step.style.position = 'absolute';
            });

            // Zapisz dane przed przejściem do następnego kroku
            if (stepNumber > 1) {
                saveData(stepNumber - 1);
            }

            // Pokaż wybrany krok
            var stepToShow = document.querySelector('#step' + stepNumber);
            if (stepToShow) {
                stepToShow.style.visibility = 'visible';
                stepToShow.style.position = 'relative';
            }

            // Załaduj dane jeśli wracamy do poprzedniego kroku
            loadData(stepNumber);
        }

        // Wywołaj tę funkcję na początku, aby pokazać tylko pierwszy krok i załadować dane jeśli są dostępne
        showStep(1);

        // Przyciski do przełączania kroków
        document.querySelector('#nextBtn').addEventListener('click', function() {
            showStep(2);
        });

        document.querySelector('#prevBtn').addEventListener('click', function() {
            showStep(1);
        });

        // Usuń dane z Local Storage po pomyślnym wysłaniu formularza
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.clear();
        });
    </script>

@endsection
