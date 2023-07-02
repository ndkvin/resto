<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Resto - Single Restaurant Version">
    <meta name="author" content="Ansonika">
    <title>Resto</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
        href="/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
        href="/img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- BASE CSS -->
    <link href="/css/vendors.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="/css/custom.css" rel="stylesheet">


</head>

<body>

    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div><!-- /Page Preload -->

    <header class="header clearfix element_to_stick">
        <div class="layer"></div><!-- Opacity Mask Menu Mobile -->
        <div class="container-fluid">
            <div id="logo">
                <a href="{{ route('home') }}">
                    <div style="font-weight:600;font-size:36px;color:#978667;">
                        Resto
                    </div>
                </a>
            </div>
            <ul id="top_menu">
                <li>
                    <div class="dropdown dropdown-cart">
                        <div class="dropdown-menu">
                            <ul>
                                <li>
                                    <figure><img src="img/item_placeholder_square_small.jpg"
                                            data-src="/img/item_square_small_1.jpg" alt="" width="50"
                                            height="50" class="lazy"></figure>
                                    <strong><span>1x Pizza Napoli</span>$12.00</strong>
                                    <a href="#0" class="action"><i class="icon_trash_alt"></i></a>
                                </li>
                                <li>
                                    <figure><img src="img/item_placeholder_square_small.jpg"
                                            data-src="/img/item_square_small_2.jpg" alt="" width="50"
                                            height="50" class="lazy"></figure>
                                    <strong><span>1x Hamburgher Maxi</span>$10.00</strong>
                                    <a href="#0" class="action"><i class="icon_trash_alt"></i></a>
                                </li>
                                <li>
                                    <figure><img src="img/item_placeholder_square_small.jpg"
                                            data-src="/img/item_square_small_3.jpg" alt="" width="50"
                                            height="50" class="lazy"></figure>
                                    <strong><span>1x Red Wine Bottle</span>$20.00</strong>
                                    <a href="#0" class="action"><i class="icon_trash_alt"></i></a>
                                </li>
                            </ul>
                            <div class="total_drop">
                                <div class="clearfix add_bottom_15"><strong>Total</strong><span>$32.00</span></div>
                                <a href="shop-cart.html" class="btn_1 outline">View Cart</a><a href="shop-checkout.html"
                                    class="btn_1">Checkout</a>
                            </div>
                        </div>
                    </div>
                    <!-- /dropdown-cart-->
                </li>
            </ul>
            <!-- /top_menu -->
            <a href="#0" class="open_close">
                <i class="icon_menu"></i><span>Menu</span>
            </a>
            <nav class="main-menu">
                <div id="header_menu">
                    <a href="#0" class="open_close">
                        <i class="icon_close"></i><span>Menu</span>
                    </a>
                    <a href="index.html"><img src="/img/logo.svg" width="140" height="35" alt=""></a>
                </div>
                <ul>
                    @guest
                        <li><a href="{{ route('login') }}" class="btn_top">Login</a></li>
                    @endguest

                    @if (auth()->user()->role == 'ADMIN')
                        <li><a href="{{ route('admin.category.index') }}" class="btn_top">Dashboard</a></li>
                    @endif

                    @if (auth()->user()->role == 'CASHIER')
                        <li><a href="{{ route('cashier.reservation.index') }}" class="btn_top">Dashboard</a></li>
                    @endif

                    @if (auth()->user()->role == 'MANAGER')
                        <li><a href="{{ route('manager.menu.index') }}" class="btn_top">Dashboard</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>
    <!-- /header -->

    <main>

        <div class="hero_single inner_pages background-image"
            data-background="url(https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80)">
            <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-9 col-lg-10 col-md-8">
                            <h1>About Us</h1>
                            <p>Made by Kelompok 5 Pemrograman Web 2023 Kelas A</p>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
            <div class="frame white"></div>
        </div>
        <!-- /hero_single -->

        <div class="pattern_2">
            <div class="container margin_120_100 home_intro">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-7" data-cue="slideInUp" data-delay="500">
                        <div class="main_title center">
                            <span><em></em></span>
                            <h2>Our Story</h2>
                        </div>
                        <p>Foores Restaurant, menghadirkan pengalaman kuliner yang luar biasa dengan hidangan yang
                            memikat dan cita rasa yang memanjakan lidah Anda. Kami bangga menyajikan hidangan
                            berkualitas tinggi yang terinspirasi oleh bahan-bahan segar dan pilihan terbaik dari seluruh
                            dunia.</p>
                        <p><img src="img/signature.png" width="140" height="50" alt=""
                                class="mt-3"></p>
                    </div>
                </div>
                <!--/row -->
            </div>
            <!--/container -->
        </div>
        <!--/pattern_2 -->

        <div class="bg_gray">
            <div class="container margin_120_100">
                <div class="row flex-lg-row-reverse">
                    <div class="col-lg-5 offset-lg-1 align-self-center mb-4 mb-md-0">
                        <div class="intro_txt" data-cue="slideInUp" data-delay="500">
                            <div class="main_title">
                                <span><em></em></span>
                                <h2>Why Choose Foore</h2>
                            </div>
                            <p class="lead">Foores Restaurant, menghadirkan pengalaman kuliner yang luar biasa dengan
                                hidangan yang memikat dan cita rasa yang memanjakan lidah Anda. Kami bangga menyajikan
                                hidangan berkualitas tinggi yang terinspirasi oleh bahan-bahan segar dan pilihan terbaik
                                dari seluruh dunia.</p>
                            <p><a href="reservations.html" class="btn_1 mt-2">Reserve a table</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_how" data-cue="slideInUp">
                                    <figure><img src="/img/lazy-placeholder-100-100-white.png"
                                            data-src="img/how_1.svg" alt="" width="100" height="110"
                                            class="lazy"></figure>
                                    <h3>For Every Taste</h3>
                                    <p>Perpaduan sempurna antara kreativitas, inovasi, dan tradisi, kami menciptakan
                                        hidangan yang unik dan tak terlupakan. Dari hidangan klasik hingga kreasi baru
                                        yang modern, setiap hidangan kami dirancang untuk memanjakan selera Anda.</p>
                                </div>
                                <div class="box_how" data-cue="slideInUp">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="img/how_2.svg"
                                            alt="" width="100" height="110" class="lazy"></figure>
                                    <h3>Fresh Ingredients</h3>
                                    <p>Kami percaya bahwa kualitas bahan baku adalah kunci dari hidangan yang istimewa.
                                        Oleh karena itu, kami selalu memastikan bahwa setiap bahan yang digunakan di
                                        restoran kami adalah segar, berkualitas, dan bebas dari bahan tambahan yang
                                        tidak diinginkan.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-center">
                                <div class="box_how" data-cue="slideInUp">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="img/how_3.svg"
                                            alt="" width="100" height="110" class="lazy"></figure>
                                    <h3>Experienced Chefs</h3>
                                    <p>Kami bangga memiliki tim chef yang berbakat dan berpengalaman di dapur kami.
                                        Setiap hidangan yang kami sajikan adalah hasil dari keahlian dan dedikasi
                                        chef-chef kami yang telah melalui pelatihan dan pengalaman bertahun-tahun dalam
                                        industri kuliner.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/container -->
        </div>
        <!--/pattern_2 -->


        <!--/pattern_2 -->

    </main>
    <!-- /main -->

    <footer>
        <div class="frame black"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="footer_wp">
                        <i class="icon_pin_alt"></i>
                        <h3>Address</h3>
                        <p>Jl. Ir Sutami No.36, Kentingan<br>Jebres - Surakarta</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="footer_wp">
                        <i class="icon_tag_alt"></i>
                        <h3>Reservations</h3>
                        <p><a href="tel:009442323221">+62 82-123-456-789</a><br><a
                                href="#0">reservations@Foores.com</a></p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="footer_wp">
                        <i class="icon_clock_alt"></i>
                        <h3>Opening Hours</h3>
                        <ul>
                            <li>Mon - Sat: 10am - 11pm</li>
                            <li>Sunday: Closed</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row-->
            <hr>
            <div class="row">
                <div class="col-sm-5">
                    <p class="copy">© Foores Restaurant - All rights reserved</p>
                </div>
                <div class="col-sm-7">
                    <div class="follow_us">
                        <ul>
                            <li><a href="#0"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="img/twitter_icon.svg" alt="" class="lazy"></a></li>
                            <li><a href="#0"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="img/facebook_icon.svg" alt="" class="lazy"></a></li>
                            <li><a href="#0"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="img/instagram_icon.svg" alt="" class="lazy"></a></li>
                            <li><a href="#0"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="img/youtube_icon.svg" alt="" class="lazy"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <p class="text-center"></p>
        </div>
    </footer>
    <!--/footer-->

    <div id="toTop"></div><!-- Back to top button -->

    <!-- COMMON SCRIPTS -->
    <script src="/js/common_scripts.min.js"></script>
    <script src="/js/common_func.js"></script>

</body>

</html>
