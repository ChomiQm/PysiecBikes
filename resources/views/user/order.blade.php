@extends('layouts.app')

@section('content')
    @vite(['resources/sass/order.scss'])
    <div class="container mt-4" id="ordersContainer">
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
                                            <button class="btn btn-primary" onclick="showOrderDetails(this)" data-details='@json($order->orderItems)'>Pokaż szczegóły</button>
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

    <!-- Modal-like section for order details -->
    <div class="order-details-modal" id="orderDetailsModal">
        <div class="order-details-content">
            <span class="close" onclick="hideOrderDetails()">&times;</span>
            <h5>Szczegóły zamówienia</h5>
            <div id="modalContent"></div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            hideOrderDetails();
        });

        function showOrderDetails(button) {
            var orderItems = JSON.parse(button.getAttribute('data-details'));
            var contentHtml = '<ul>';
            orderItems.forEach(function(item) {
                var totalPrice = parseFloat(item.total_price);
                contentHtml += '<li>' + item.bike.name + ' - ' + item.quantity + ' szt - ' + totalPrice.toFixed(2) + ' zł</li>';
            });
            contentHtml += '</ul>';
            document.getElementById('modalContent').innerHTML = contentHtml;
            document.getElementById('orderDetailsModal').style.display = 'flex';
            document.getElementById('ordersContainer').style.display = 'none';
        }

        function hideOrderDetails() {
            document.getElementById('orderDetailsModal').style.display = 'none';
            document.getElementById('ordersContainer').style.display = 'flex';
        }
    </script>
@endpush
