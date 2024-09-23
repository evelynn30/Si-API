<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="shortcut icon" type="image/api-icon" href="{{ asset('assets/img/logo-api.png') }}" />
    <title>Si-API</title>

    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Si-API</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="https://diskominfo.sultengprov.go.id/" target="_blank"
                            style="font-weight: bold;">Diskominfo Provinsi</a></li>
                    <li><a href="https://sandikami.diskominfo.sultengprov.go.id/" target="_blank"
                            style="font-weight: bold;">Sandi Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <img src="assets/img/hero-bg-2.jpg" alt="" class="hero-bg">

            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <img src="assets/img/hero-api.png" class="img-fluid animated" alt="">
                    </div>

                    <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
                        <h1>Agregasi Pelaporan Insiden <br><span>Si-API</span></h1>
                        <div class="d-flex">
                            @if (Auth::check())
                                <a href="{{ route('dashboard.index') }}" class="btn-get-started">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-get-started">Login</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                    </path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container footer-top">
                <div class="row gy-4">
                    <a href="index.html" class="logo d-flex align-items-center">
                    </a>
                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>Sosial Media</h4>
                        <div class="social-links d-flex mt-4">
                            <a href="https://www.facebook.com/diskominfo.sultengprov" target="_blank"
                                style="font-size: 24px; margin-left: 10px;"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/diskominfo.sultengprov/" target="_blank"
                                style="font-size: 24px; margin-left: 10px;"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-about">
                        <h4 class="sitename">Dinas Komunikasi, Informatika, Persandian dan Statistik Provinsi Sulawesi
                            Tengah</h4>
                        <div class="footer-contact pt-3">
                            <p><strong>Alamat:</strong><span> Jl. Kartini No. 106 Palu – 94112</span></p>
                            <p><strong>Telp:</strong><span> (0451) 452909</span></p>
                            <p><strong>Email:</strong><span> info@diskominfo.sultengprov.go.id</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /About Section -->

        <footer id="contact" class="footer dark-background">
            <div class="container copyright text-center mt-4">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">Bootslander</strong> <span>All Rights
                        Reserved</span></p>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you've purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </footer>

        <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- Preloader -->
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

        <!-- Main JS File -->
        <script src="assets/js/main.js"></script>

</body>

</html>
