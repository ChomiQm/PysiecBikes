@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Rejestracja</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Pola formularza dla pierwszego kroku rejestracji --}}
                            <div id="step1">
                                <div class="form-group">
                                    <label for="email">Adres Email
                                        <input type="email" class="form-control" name="email" required autofocus>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="password">Hasło
                                        <input type="password" class="form-control" name="password" required>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm">Potwierdź Hasło
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="showStep(2)">Dalej</button>
                                </div>
                            </div>

                            {{-- Pola formularza dla drugiego kroku rejestracji --}}
                            <div id="step2" style="display: none;">
                                {{-- Tutaj dodaj odpowiednie pola formularza --}}
                                {{-- ... --}}

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
            if (step === 1) {
                document.getElementById('step1').style.display = 'block';
                document.getElementById('step2').style.display = 'none';
            } else if (step === 2) {
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
            }
        }
    </script>
@endsection
