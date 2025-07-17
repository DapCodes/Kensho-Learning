<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Scholar - Online School HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/templatemo-scholar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css')}}" />
    <!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">
                            <h1>Kenshō</h1>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Serach Start ***** -->

                        <!-- ***** Serach Start ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Beranda</a></li>
                            <li class="scroll-to-section"><a href="#services">Layanan</a></li>
                            <li class="scroll-to-section"><a href="#about">Tentang</a></li>
                            <li class="scroll-to-section"><a href="#team">Testimoni</a></li>

                            @guest
                                @if (Route::has('login'))
                                    <li class="scroll-to-section">
                                        <a href="{{ route('login') }}">Mulai Sekarang</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="scroll-to-section-toggle" href="{{ route('dasbor') }}" role="button"
                                        aria-expanded="false">
                                        Dasbor
                                    </a>
                                </li>
                            @endguest
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        <div class="item item-1">
                            <div class="header-text">
                                <span class="category">Belajar dengan kami</span>
                                <h2>Belajar lebih praktis dan efektif bersama Kenshō.</h2>
                                <p>Dengan Kenshō, proses belajar menjadi lebih mudah, menyenangkan, dan efektif untuk
                                    siapa saja, kapan pun, di mana pun.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        @guest
                                            @if (Route::has('login'))
                                                <a href="{{ route('login') }}">Mulai Sekarang</a>
                                            @endif
                                        @else
                                            <a href="{{ route('dasbor') }}">Lanjut ke Dashbor?</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item item-2">
                            <div class="header-text">
                                <span class="category">Hasil Terbaik</span>
                                <h2>Raih hasil terbaik dari setiap usaha yang kamu lakukan.</h2>
                                <p>Usaha yang kamu lakukan tidak akan sia-sia, karena bersama Kenshō kamu bisa meraih
                                    hasil terbaik setiap saat. Dimanapun dan kapanpun.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        @guest
                                            @if (Route::has('login'))
                                                <a href="{{ route('login') }}">Mulai Sekarang</a>
                                            @endif
                                        @else
                                            <a href="{{ route('dasbor') }}">Lanjut ke Dashbor?</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item item-3">
                            <div class="header-text">
                                <span class="category">Pembelajaran Online</span>
                                <h2>Pembelajaran online membantumu menghemat waktu."</h2>
                                <p>Dengan pembelajaran online, kamu bisa menghemat waktu, belajar lebih fleksibel, dan
                                    menyesuaikan materi sesuai kebutuhanmu sendiri.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        @guest
                                            @if (Route::has('login'))
                                                <a href="{{ route('login') }}">Mulai Sekarang</a>
                                            @endif
                                        @else
                                            <a href="{{ route('dasbor') }}">Lanjut ke Dashbor?</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="services section" id="services">
        <div class="container">
            <div class="row">
                <!-- Pembelajaran Mudah -->
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('assets/frontend/images/service-01.png') }}" alt="pembelajaran mudah">
                        </div>
                        <div class="main-content">
                            <h4>Pembelajaran</h4>
                            <p>Kenshō menghadirkan tes yang mudah diakses dan dipahami, agar proses belajar menjadi
                                lebih ringan dan menyenangkan.</p>
                            <div class="main-button">
                                @guest
                                    @if (Route::has('login'))
                                        <a href="{{ route('login') }}">Mulai Sekarang</a>
                                    @endif
                                @else
                                    <a href="{{ route('dasbor') }}">Lanjut ke Dashbor?</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Raih Keinginanmu -->
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('assets/frontend/images/service-02.png') }}" alt="raih keinginanmu">
                        </div>
                        <div class="main-content">
                            <h4>Raih Goals</h4>
                            <p>Raih tujuan dan cita-citamu bersama Kenshō, melalui pembelajaran yang terarah, efektif,
                                dan sesuai kebutuhanmu.</p>
                            <div class="main-button">
                                <a href="#">Ayo Mulai</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pelajari Hal Baru -->
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('assets/frontend/images/service-03.png') }}" alt="pelajari hal baru">
                        </div>
                        <div class="main-content">
                            <h4>Pelajari Hal Baru</h4>
                            <p>Kembangkan dirimu dengan mempelajari hal-hal baru bersama Kenshō, agar lebih siap
                                menghadapi tantangan masa depan.</p>
                            <div class="main-button">
                                <a href="#">Eksplor Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section about-us" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-1">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Bagaimana memulai belajar di Kenshō?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Anda cukup mendaftar akun secara gratis, lalu pilih kursus yang Anda minati di
                                    platform Kenshō. Semua materi dirancang interaktif untuk membantu Anda belajar
                                    secara mandiri.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Bagaimana sistem pembelajaran di Kenshō?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Kenshō menyediakan video pembelajaran, kuis, dan proyek praktis. Anda dapat belajar
                                    kapan saja dan di mana saja sesuai kecepatan Anda sendiri.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    Kenapa memilih Kenshō?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Kenshō menghadirkan pengajar profesional, kurikulum terstruktur, serta komunitas
                                    belajar yang mendukung. Semua untuk membantu Anda mencapai tujuan belajar Anda.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    Apakah tersedia dukungan mentor?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Ya, setiap kursus dilengkapi forum diskusi dan sesi tanya jawab dengan mentor
                                    sehingga Anda tidak belajar sendirian.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="section-heading">
                        <h6>Tentang Kenshō</h6>
                        <h2>Kenapa Kenshō menjadi platform belajar online terbaik?</h2>
                        <p>Kenshō hadir untuk membantu Anda menguasai skill baru melalui kursus online berkualitas
                            dengan harga terjangkau. Didesain untuk pelajar Indonesia, materi kami dapat diakses di mana
                            saja dan kapan saja.</p>
                        <div class="main-button">
                            <a href="#">Mulai Belajar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section testimonials cbt-theme" id="team">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="owl-carousel owl-testimonials">
                    @foreach ($pesans as $pesan)
                    <div class="item">
                        <p>“{{ $pesan->pesan }}”</p>
                        <div class="author">
                            <img src="{{ asset('assets/frontend/images/testimonial-author.jpg') }}" alt="">
                            <span class="category">Peserta</span>
                            <h4>{{ $pesan->nama_pengirim }}</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 align-self-center">
                <div class="section-heading">
                    <h6>SISTEM CBT</h6>
                    <h2>Apa kata mereka tentang platform CBT kami?</h2>
                    <p>Platform Computer‑Based Test (CBT) kami memudahkan penyelenggaraan ujian online yang aman, cepat, dan interaktif bagi peserta di mana saja.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-us section cbt-theme" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="section-heading">
                    <h6>Dukungan</h6>
                    <h2>Ingin kesan untuk aplikasi kami?</h2>
                    <p>Kami terbuka dengan kritik, saran maupun pujian dari anda, kenyamanan anda adalah tanggung jawab kami! Jangan ragu untuk menyampaikan semuanya</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-us-content">
                    <form id="contact-form" action="{{ route('pesan.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="text" name="nama_pengirim" id="name" placeholder="Nama Anda..." autocomplete="on" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="email" name="email_pengirim" id="email" placeholder="Email Anda..." required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="pesan" id="message" placeholder="Pesan Anda"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="orange-button">Kirim Pesan Sekarang</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    <footer>
        <div class="container">
            <div class="col-lg-12">
                <p>Copyright © 2036 Scholar Organization. All rights reserved. &nbsp;&nbsp;&nbsp; Design: <a
                        href="https://templatemo.com" rel="nofollow" target="_blank">TemplateMo</a> Distribution: <a
                        href="https://themewagon.com" rel="nofollow" target="_blank">ThemeWagon</a></p>
            </div>
        </div>
    </footer>

<!-- Toast Notification (Success & Error) -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    @if (session('success'))
        <div class="toast align-items-center text-white bg-success border-0 show mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="ti ti-check-circle me-2" style="font-size: 1.2rem;"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="toast align-items-center text-white bg-danger border-0 show mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="ti ti-alert-triangle me-2" style="font-size: 1.2rem;"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.map(function (toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                delay: 4000
            })
            toast.show()
        })
    });
</script>



    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/frontend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/counter.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
