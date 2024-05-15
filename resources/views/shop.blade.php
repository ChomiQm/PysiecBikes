<html lang="pl-PL">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>Mateusz Urbanek 102297</title>
    <link rel="stylesheet" href="{{ asset('css/styleshop.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <header>

        <div class="nav container">
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
            <i class='bx bx-shopping-bag' id="cart-icon"></i>
            <div class="cart">
                <h2 class="cart-title">Twój koszyk</h2>

                <div class="cart-content">

                </div>

                <div class="total">
                    <div class="total-title">Razem</div>
                    <div class="total-price">$0</div>
                </div>

                <button type="button" class="btn-clear-cart">Wyczyść koszyk</button>
                <button type="button" class="btn-buy">Kup teraz!</button>

                <i class='bx bx-x' id="close-cart"></i>

            </div>
        </div>
    </header>
	<section id="main">
    <section class="shop container">
        <h2 class="section-title">Produkty</h2>

        <div class="shop-content">
            @foreach($bikes as $bike)
                <div class="product-box" data-id="{{ $bike->id }}">
                    <img src="{{ asset($bike->image_path) }}" alt="" class="product-img">
                    <h2 class="product-title">{{ $bike->name }}</h2>
                    <span class="price">${{ $bike->price }}</span>
                    <i class='bx bx-shopping-bag add-cart' style="color: white"></i>
                </div>
            @endforeach

        </div>

    </section>
	</section>
	<section id="main2">
		<section class="footer">

			<h4> Copyrights </h4>
			<p> Pysiec_bikes &trade; <br />
			Stworzone przez: Mateusz Urbanek&copy; <br />
			lab_gr7 102297 <br />
			All rights reserved <br />
			</p>

		</section>
	</section>

</body>

<script>
    $(document).ready(function() {
        // Otwieranie koszyka
        $('#cart-icon').click(function() {
            $('.cart').addClass('active');
        });

        // Zamykanie koszyka
        $('#close-cart').click(function() {
            $('.cart').removeClass('active');
        });

        // Dodawanie produktu do koszyka lub aktualizacja ilości
        $('.add-cart').click(function() {
            var parentBox = $(this).closest('.product-box');
            var productImg = parentBox.find('.product-img').attr('src');
            var productName = parentBox.find('.product-title').text();
            var productPrice = parentBox.find('.price').text();
            var productId = parentBox.data('id');  // Przechwytywanie ID produktu

            var isProductAdded = false;

            // Sprawdzenie, czy produkt już jest w koszyku
            $('.cart-box').each(function() {
                var existingId = $(this).data('id');
                if (existingId === productId) {
                    var quantityInput = $(this).find('.cart-quantity');
                    quantityInput.val(parseInt(quantityInput.val()) + 1);
                    isProductAdded = true;
                    updateTotal();
                    return false; // Zakończenie pętli
                }
            });

            // Jeśli produkt nie jest jeszcze w koszyku, dodaj go
            if (!isProductAdded) {
                var productHtml = `
                    <div class="cart-box" data-id="${productId}">
                        <img src="${productImg}" alt="" class="cart-img">
                        <div class="detail-box">
                            <div class="cart-product-title">${productName}</div>
                            <div class="cart-price">${productPrice}</div>
                        </div>
                        <div>
                            <input type="number" value="1" min="1" class="cart-quantity">
                            <i class='bx bx-trash cart-remove'></i>
                        </div>
                    </div>`;
                $('.cart-content').append(productHtml);
                updateTotal();
            }
        });

        // Aktualizacja sumy koszyka
        function updateTotal() {
            var total = 0;
            $('.cart-price').each(function() {
                var price = parseFloat($(this).text().replace('$', ''));
                var quantity = $(this).closest('.cart-box').find('.cart-quantity').val();
                total += price * parseInt(quantity);
            });
            $('.total-price').text('$' + total.toFixed(2));
        }

        // Usuwanie produktu z koszyka
        $(document).on('click', '.cart-remove', function() {
            $(this).closest('.cart-box').remove();
            updateTotal();
        });

        // Aktualizacja sumy przy zmianie ilości
        $(document).on('change', '.cart-quantity', function() {
            updateTotal();
        });

        // Czyszczenie koszyka
        $('.btn-clear-cart').click(function() {
            $('.cart-content').empty(); // Usuwa wszystkie produkty z koszyka
            updateTotal(); // Aktualizuje sumę na 0
        });

        $('.btn-buy').click(function() {
            var cartItems = [];
            $('.cart-box').each(function() {
                var item = {
                    id: $(this).data('id'),  // ID produktu
                    name: $(this).find('.cart-product-title').text(),  // Nazwa produktu
                    price: parseFloat($(this).find('.cart-price').text().replace('$', '')),  // Cena produktu jako wartość zmiennoprzecinkowa
                    quantity: parseInt($(this).find('.cart-quantity').val())  // Ilość produktu
                };
                cartItems.push(item);
            });

            $.ajax({
                url: '/place-order',
                type: 'POST',
                data: {
                    cartItems: cartItems,
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    alert('Zamówienie zostało złożone pomyślnie.');
                    $('.cart-content').empty();  // Czyszczenie koszyka
                    updateTotal();  // Aktualizacja sumy
                },
                error: function() {
                    alert('Wystąpił błąd przy składaniu zamówienia.');
                }
            });
        });
    });
</script>

</html>
