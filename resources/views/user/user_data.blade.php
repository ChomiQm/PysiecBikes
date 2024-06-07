@extends('layouts.app')

@section('content')
    @vite(['resources/sass/user_data.scss'])
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dane Użytkownika</div>
                    <div class="card-body">
                        <div id="user-data">
                            <ul class="list-unstyled">
                                @foreach(['first_name', 'last_name', 'country', 'state', 'city', 'street_address', 'postal_code'] as $field)
                                    <li class="form-group">
                                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}:</label>
                                        <p id="{{ $field }}">{{ $userData->$field }}</p>
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn btn-primary" id="edit-button">Edytuj Dane</button>
                        </div>

                        <div id="edit-form-container" style="display: none;">
                            <form id="edit-form" method="POST" action="{{ route('user_data.update', $userData->id) }}">
                                @csrf
                                @method('PUT')
                                @foreach(['first_name', 'last_name', 'country', 'state', 'city', 'street_address', 'postal_code'] as $field)
                                    <div class="form-group">
                                        <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}:</label>
                                        <input type="text" class="form-control" id="edit-{{ $field }}" name="{{ $field }}" value="{{ $userData->$field }}">
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-success">Zapisz zmiany</button>
                                <button type="button" class="btn btn-secondary" id="cancel-button">Anuluj</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            // Przełączanie widoczności formularza edycji
            $('#edit-button').click(function() {
                $('#user-data').hide();
                $('#edit-form-container').show();
            });

            $('#cancel-button').click(function() {
                $('#edit-form-container').hide();
                $('#user-data').show();
            });

            $('#edit-form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Aktualizacja UI z nowymi danymi
                        for (let key in response) {
                            $('#' + key).text(response[key]);
                        }
                        $('#edit-form-container').hide();
                        $('#user-data').show();
                        alert('Dane zostały zaktualizowane.');
                    },
                    error: function(xhr) {
                        alert('Wystąpił błąd: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            });
        });
    </script>
@endpush
