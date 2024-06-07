<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Pysiec Bikes!</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<section class="header" style="margin: 0; padding: 0;">
    <div class="nav-box" id="nav-box">
        <nav>
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
            <div class="navLinks">
                <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
                <ul>
                    <li><a class="navjump" href="{{ url('/') }}">Główna</a></li>
                    <li><a href="{{ url('/') }}#about_us">O nas</a></li>
                    <li><a class="navjump" href="{{ url('/shop') }}">Sklep</a></li>
                    <li><a href="{{ url('/') }}#CTA">Kontakt</a></li>
                    @auth
                        <li><a href="{{ route('user_data.index') }}">Moje Dane</a></li>
                        <li><a href="{{ route('orders.index') }}">Moje Zamówienia</a></li>
                        <li><a href="{{ route('documents.create') }}">Lista Dokumentów</a></li>
                        @if (Auth::user()->hasRole('Admin'))
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard Admina</a></li>
                            <li><a href="{{ route('admin.roles.index') }}">Role</a></li>
                            <li><a href="{{ route('admin.permissions.index') }}">Uprawnienia</a></li>
                        @endif
                        <li><a id="logout-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Wyloguj</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                    @guest
                        <li><a href="{{ route('login') }}">Logowanie</a></li>
                        <li><a href="{{ route('register') }}">Rejestracja</a></li>
                    @endguest
                </ul>
            </div>
            <i class="fa-solid fa-bars" onclick="showMenu()"></i>
        </nav>
    </div>
    @yield('content')
    <footer>
        @yield('footer')
    </footer>
</section>

<script src="{{ asset('js/menutoggle.js') }}"></script>
<script>
    document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault();
        localStorage.clear();
        sessionStorage.clear();
        document.getElementById('logout-form').submit();
    });
</script>

@stack('custom-scripts')

</body>
</html>
