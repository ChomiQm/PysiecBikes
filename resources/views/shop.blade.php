<html lang="pl-PL">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>Mateusz Urbanek 102297</title>
    <link rel="stylesheet" href="{{ asset('css/styleshop.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
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
                <div class="product-box">
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
</html>
