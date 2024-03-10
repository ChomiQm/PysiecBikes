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
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<section class="header">
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
                    {{-- Poniższy kod jest przykładem integracji z systemem logowania Laravel --}}
                    {{-- @auth
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Wyloguj</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @else
                    <li><a href="{{ route('login') }}">Logowanie</a></li>
                    @endauth --}}
                </ul>
            </div>
            <i class="fa-solid fa-bars" onclick="showMenu()"></i>
        </nav>
    </div>
    @yield('content')
</section>

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
