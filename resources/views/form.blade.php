<html lang="pl-PL">
	<head>
	<meta name="viewport" content="with=device-width, initial-scale=1.0" charset="UTF-8">
	<link rel="stylesheet" href="{{ asset('css/styleform.css') }}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
		<title>Mateusz Urbanek 102297</title>
	</head>
	<body>
	<!-- ---------------------------HEADERFORM--------------------------- -->
		<section class="header">
		<!-- 1920x1080 -->
			<div class="nav-box" id="nav-box">
				<nav>
                    <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
					<div class="navLinks">
					<i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
						<ul>
                            <li><a class="navjump" href="{{ url('/') }}">Główna</a></li>
                            <li><a href="#about_us">O nas</a></li>
                            <li><a class="navjump" href="{{ url('/shop') }}">Sklep</a></li>
                            <li><a href="#CTA">Kontakt</a></li>
{{--							<?php--}}
{{--							if($login_session == null) :--}}
{{--							?>--}}
{{--							<li><a href="login.php">Login</a></li>--}}
{{--							<?php--}}
{{--							else :--}}
{{--							?>--}}
{{--							<li><a href="logouthandler.php">Logout</a></li>--}}
{{--							<?php--}}
{{--							endif;--}}
{{--							?>--}}
						</ul>
					</div>
					<i class="fa-solid fa-bars" onclick="showMenu()"> </i>
				</nav>
			</div>
			<header>
			<div class="text-box">
				<h1>Formularz zgłoszeniowy</h1>

			</div>
			<!-- ---------------------------HOSTING NEEDED BO NIE ZABANGLA --------------------------- -->
			<form action="https://formsubmit.co/mateusz.urbanek@student.po.edu.pl" method="POST">

				<div class="form-row">
					<div class="input-group">
						<input type="text" id="name" pattern="\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$" required>
						<label for="name"> <i class="fa-solid fa-user"></i> Imie i nazwisko </label>
					</div>

					<div class="input-group">
						<input type="text" id="number" pattern="^[0-9]{9}$" required>
						<label for="number"><i class="fa-solid fa-phone"></i> Numer telefonu (np. 123123123) </label>
					</div>
				</div>

				<div class="input-group">
					<input type="email" id="email" pattern="^[\w\d]+\.?[\w\d]+@[\w\d]+\.+[a-z]{2,4}$" required>
					<label for="email"><i class="fa-solid fa-envelope"></i> Email </label>
				</div>

				<div class="input-group">
					<textarea id="message" rows="8" required></textarea>
					<label for="message"><i class="fa-solid fa-comment"></i> Twoja wiadomość </label>
				</div>
				<input type="hidden" name="_next" value="thankyou.php">
				<button type="submit">Wyślij! <i class="fa-solid fa-paper-plane"></i></button>

			</form>

			</header>
		</section>

		<!-- ---------------------------FOOTER--------------------------- -->

			<section class="footer">

			<h4> Copyrights </h4>
			<p> Pysiec_bikes &trade; <br />
			Stworzone przez: Mateusz Urbanek&copy; <br />
			lab_gr7 102297 <br />
			All rights reserved <br />
			</p>

			</section>


	<!-- ---------------------------JS toggle--------------------------- -->

    <script src="{{ asset('js/menutoggle.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.navLinks').on("click", ".navjump", function(e) {
                e.preventDefault();
                let page = $(this).attr('href');
                $('body').load(page);
            });
        });
    </script>
	</body>
</html>
