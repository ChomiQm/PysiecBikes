<html lang="pl-PL">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Pysiec Bikes!</title>
</head>
<body>
<section class="header">
    <!-- 1920x1080 -->
    <!-- ---------------------------HEADER--------------------------- -->
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
{{--                    @if (Auth::check())--}}
{{--                        <!-- Użytkownik jest zalogowany -->--}}
{{--                        <li><a href="logouthandler.php">Logout</a></li>--}}
{{--                    @else--}}
{{--                        <!-- Użytkownik nie jest zalogowany -->--}}
{{--                        <li><a href="login.php">Login</a></li>--}}
{{--                    @endif--}}
                </ul>
            </div>
            <i class="fa-solid fa-bars" onclick="showMenu()"> </i>
        </nav>
    </div>
    <header>
        <div class="text-box">
            <h1>Pysiec_bikes</h1>
            <p>
                Firma tworzona dla rowerzystów przez rowerzystów<br />
            </p>
            <a href="{{ url('/shop') }}" class="hero-btn">Zobacz więcej!</a>
        </div>
    </header>
</section>

<!-- ---------------------------description--------------------------- -->
<a id="about_us"> </a>
    <section id="main">
        <section class="description">

            <h1>Krótki opis</h1>
            <p> Od ponad 20 lat w rodzinnym gronie zajmujemy się projektowaniem oraz produkcją rowerów i kół rowerowych. <br />
                Nasi odbiorcy wiedzą, że stawiamy zawsze na jakość, nie na ilość. Stąd wzięło się zaufanie, którym obdarzają nas i nasze produkty. <br />
                Zaufało nam wielu europejskich dealerów rowerowych, nasze produkty dostępne są w każdym zakątku w Polsce a także w  szeregu krajów europejskich. <br />
                Połowa naszej produkcji to rowery wytwarzane na eksport.
            </p>

            <div class="row">

                <div class="description-column">
                    <h3> Nasza firma </h3>
                    <p> Pysiec_bikes to profesjonalny producent rowerów z wieloletnim doświadczeniem w branży. <br />
                        Korzystając z najwyższej jakości części rowerowych jesteśmy pewni, że proponujemy swoim klientom jedynie bezpieczne i sprawdzone rozwiązania. <br />
                    </p>
                </div>

                <div class="description-column">
                    <h3> Kim jesteśmy </h3>
                    <p> Jesteśmy rowerzystami - jak Wy, a ten fakt motywował każdą podjętą przez nas decyzję od 1995. <br />
                        Kiedy na rynku brakowało dobrych opon - stworzyliśmy je. <br />
                        Kiedy ludzie zapragnęli zjechać z drogi do lasu - zbudowaliśmy pierwszy produkowany seryjnie rower górski. <br />
                    </p>
                </div>

            </div>

        </section>

        <!-- ---------------------------bikes--------------------------- -->

        <section class="bikes">

            <h1> Znajdź swój rower w Pysiec_bikes!</h1>
            <p> Zanim kupisz: <br />
                Przede wszystkim powinieneś sobie odpowiedzieć na pytanie - po co Ci rower i jak będziesz z niego korzystać. Od tego zależy, czy ostatecznie powinieneś kupić rower szosowy czy MTB. <br />
                Nie bez znaczenia jest też Twoje doświadczenie. Dla profesjonalistów duże znaczenie mają poszczególne części. Wybrany model musi on umożliwiać im osiąganie najlepszych wyników. <br />
                Takie modele są jednak droższe, ale na pewno pozwalają na więcej. <br />
            </p>
            <div class="row">
                <div class="bikes-column">
                    <img src="{{ asset('images/mtb.jpg') }}" alt="mtb"/>
                    <a href="{{ url('/shop') }}l">
                        <div class="bikes-layer">
                            <h3> MTB </h3>
                            <p> Rower MTB (Mountain Terrain Bike) zwany popularnie po prostu “góralem”, to jeden z najchętniej kupowanych w Polsce rowerów. <br />
                                Z założenia, rower górski jest pojazdem dla sportowców, przeznaczonym do jazdy wyczynowej. <br />

                            </p>
                        </div>
                    </a>
                </div>

                <div class="bikes-column">
                    <img src="{{ asset('images/bmx.jpg') }}" alt="bmx"/>
                    <a href="{{ url('/shop') }}">
                        <div class="bikes-layer">
                            <h3> BMX </h3>
                            <p> Prawdopodobnie żaden inny rodzaj roweru nie daje takiego pola do popisu stylistyce i kreatywności jazdy jak BMX. <br />
                                To, co profesjonaliści potrafią zrobić ze swoimi BMX-ami w dyscyplinach takich jak freestyle, zakrawa o magię. <br />
                            </p>
                        </div>
                    </a>
                </div>

                <div class="bikes-column">
                    <img src="{{ asset('images/cross.jpg') }}" alt="cross"/>
                    <a href="{{ url('/shop') }}">
                        <div class="bikes-layer">
                            <h3> CROSS </h3>
                            <p> Rower crossowy to swego rodzaju kompromis pomiędzy rowerem trekkingowym, a górskim. <br />
                                W przeciwieństwie do roweru trekkingowego brak mu dodatkowych akcesoriów i ma bardziej sportowy wygląd, oraz agresywniejszą geometrię. <br />
                            </p>
                        </div>
                    </a>
                </div>

            </div>

        </section>
    </section>

    <!-- ---------------------------factories--------------------------- -->

    <section id="main2">
        <section class="factories">

            <h1> Działaności </h1>
            <p> Posiadamy jedną z największym firm w całej europie. Nasze sklepy rozsiane są po całej Polsce. <br />
            </p>

            <div class="row">

                <div class="factories-column">

                    <img src="{{ asset('images/fact1.jpg') }}" alt="fact1"/>
                    <h3> Fabryka Wieluń </h3>
                    <p> W Wieluńskiej fabryce znajduje się nasza największa hala produkcyjna rowerów MTB i BMX. <br />
                        Posiadamy też cztery sklepy i dwa serwisy w obrębie Wielunia <br />
                    </p>
                </div>

                <div class="factories-column">
                    <img src="{{ asset('images/fact2.jpg') }}" alt="fact2"/>
                    <h3> Fabryka Wrocław </h3>
                    <p> We Wrocławiu powstają najlepszej jakości rowery CROSS. <br />
                        Tutaj produkujemy też silniki elektryczne dla naszych klientów biznesowych <br />
                    </p>
                </div>

                <div class="factories-column">
                    <img src="{{ asset('images/fact3.jpg') }}" alt="fact3"/>
                    <h3> Sklepy w całej Polsce! </h3>
                    <p> Posiadamy sieć sklepów w całej polsce! <br />
                        Nasze produkty możesz kupić nawet na suwałkach! <br />

                    </p>
                </div>
            </div>

        </section>

        <!-- ---------------------------testimonials--------------------------- -->

        <section class="testimonials">
            <h1> Opinie </h1>
            <p> Staramy się przekładać jakość ponad ilość - zaufało nam wielu europejskich dealerów rowerowych a klienci są bardzo zadowoleni z naszych produktów. <br />
                Nasza firma ma bardzo dobrą renomę wśród zagranicznych klientów, a nasi klienci oceniają nas bardzo wysoko. <br />
                Zostaliśmy wielokrotnie nagrodzeni medalami i wyróżnieniami w konkursach organizowanych zarówno podczas branżowych targów i wystaw jak również organizowanych przez instytucje pozabranżowe.
            </p>

            <div class="row">

                <div class="testimonials-column">
                    <img src="..\images\user.jpg" alt="user">
                    <div>
                        <p>
                            Najlepsza marka, rowery mega wytrzymałe, zero minusów!!! Bardzo szybka wysyłka i przemiła obsługa!!
                        </p>
                        <h3>ChomiQm</h3>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>

                <div class="testimonials-column">
                    <img src="images\user1.jpg" alt="user">
                    <div>
                        <p>
                            Rowery całkiem w porządku, szybka dostawa.
                        </p>
                        <h3>Freezer</h3>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>

            </div>

        </section>

    </section>
    <section id="main3">

        <!-- ---------------------------Call To Action--------------------------- -->

        <section id="CTA" class="CTA">

            <h1> Kontakt </h1>
            <p>ul. Zmyślona XX <br />
                XX-XXX Miejscowość, Polska<br />
                tel. +XX XXX XXX XXX<br />
                mateusz.urbanek@student.po.edu.pl <br />
                <br />
                Lub skontaktuj się z nami poprzez formularz!<br />
            </p>

            <a href="{{ url('/form') }}" class="hero-btn">Wypełnij formularz</a>

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
