@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dane Użytkownika</div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach(['first_name', 'last_name', 'country', 'state', 'city', 'street_address', 'postal_code'] as $field)
                                <li class="form-group">
                                    <label>{{ ucfirst(str_replace('_', ' ', $field)) }}:</label>
                                    <p id="{{ $field }}">{{ $userData->$field }}</p>
                                </li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edytuj Dane</button>
                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edytuj Dane</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-form" method="POST" action="{{ route('user_data.update', $userData->id) }}">
                                            @csrf
                                            @method('PUT')
                                            @foreach(['first_name', 'last_name', 'country', 'state', 'city', 'street_address', 'postal_code'] as $field)
                                                <div class="form-group">
                                                    <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}:</label>
                                                    <label for="edit-{{ $field }}"></label><input type="text" class="form-control" id="edit-{{ $field }}" name="{{ $field }}" value="{{ $userData->$field }}">
                                                </div>
                                            @endforeach
                                            <button type="submit" class="btn btn-success">Zapisz zmiany</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
            console.log("skrypt odpala");

            // Ukrywanie modala po ładowaniu
            $('#editModal').modal('hide');

            // Pokaż modal przy kliknięciu przycisku
            $('.btn-primary').click(function() {
                $('#editModal').modal('show');
            });

            $('#edit-form').submit(function(e) {
                console.log("edit-form");
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
                        $('#editModal').modal('hide'); // Ukryj modal
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
