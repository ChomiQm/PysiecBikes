@extends('layouts.app')

@section('content')
    @vite(['resources/sass/register.scss', 'resources/css/register.css'])
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Rejestracja</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" class="form-container">
                            @csrf

                            <!-- Step 1: User Credentials -->
                            <div id="step1" class="form-step full-width-inputs">
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
                            <div id="step2" class="form-step side-by-side-inputs" style="display: none;">
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
        function showStep(step) {
            document.getElementById('step1').style.display = step === 1 ? 'block' : 'none';
            document.getElementById('step2').style.display = step === 2 ? 'block' : 'none';
        }
    </script>
@endsection
