<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Add this to your layouts/backend.blade.php in the <head> section -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/backend/images/logos/favicon.png') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/backend/css/styles.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('/assets/backend/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />

    <title>Modernize Bootstrap Admin</title>

    @yield('styles')
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('../assets/backend/images/logos/favicon.png') }}" alt="loader"
            class="lds-ripple img-fluid" />
    </div>

    <div id="main-wrapper">
        <!-- Sidebar Start -->
        @include('layouts.components-backend.sidebar')
        <!-- Sidebar End -->

        <div class="page-wrapper">
            <!-- Header Start -->
            @include('layouts.components-backend.navbar')
            <!-- Header End -->

            <div class="body-wrapper">
                <!-- CONTENT -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Sidebarmenu Overlay -->
    <div class="dark-transparent sidebartoggler"></div>

    <!-- JS Scripts -->
    <script src="{{ asset('/assets/backend/js/vendor.min.js') }}"></script>
    <script src="{{ asset('/assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/backend/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('/assets/backend/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('/assets/backend/js/theme/theme.js') }}"></script>
    <script src="{{ asset('/assets/backend/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('/assets/backend/js/theme/sidebarmenu.js') }}"></script>

    <!-- Iconify -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <!-- Carousel & Chart -->
    <script src="{{ asset('/assets/backend/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/assets/backend/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/assets/backend/js/dashboards/dashboard.js') }}"></script>

    <!-- Color Theme Switcher -->
    <script>
        function handleColorTheme(e) {
            document.documentElement.setAttribute("data-color-theme", e);
        }
    </script>

    @yield('js')
</body>

</html>
