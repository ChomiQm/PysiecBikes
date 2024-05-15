@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Moje zamówienia</h4>
                        <form method="GET" action="{{ route('orders.index') }}">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Szukaj zamówienia..." name="search" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Szukaj</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        @if ($orders->isEmpty())
                            <p>Nie znaleziono zamówień.</p>
                        @else
                            <ol class="list-group list-group-numbered">
                                @foreach ($orders as $order)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            Numer: {{ $order->order_number }} |
                                            Data: {{ $order->created_at->format('d-m-Y H:i') }} |
                                            Ilość produktów: {{ $order->quantity }}
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#detailsModal" data-details='@json($order->orderItems)'>Pokaż szczegóły</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                            <div class="d-flex justify-content-center">
                                {!! $orders->links() !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Szczegóły zamówienia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Dane zamówienia będą załadowane tutaj -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            // Pokaż modal 'detailsModal' po kliknięciu przycisku 'Pokaż szczegóły'
            $('.btn-primary').click(function() {
                var orderItems = $(this).data('details');
                var contentHtml = '<ul>';
                orderItems.forEach(function(item) {
                    var totalPrice = parseFloat(item.total_price);  // Konwersja na liczbę
                    contentHtml += '<li>' + item.bike.name + ' - ' + item.quantity + ' szt - ' + totalPrice.toFixed(2) + ' zł</li>';
                });
                contentHtml += '</ul>';
                $('#modalContent').html(contentHtml);
                $('#detailsModal').modal('show');
            });

            // Zamykanie modala 'detailsModal' przy użyciu przycisku zamknięcia w modalu
            $('.close').click(function() {
                $('#detailsModal').modal('hide');
            });
        });
    </script>
@endpush
