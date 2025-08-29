<header class="topbar" style="z-index: 999;">
    <div class="with-vertical"><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-lg-flex align-items-center">
                @if (Auth::user()->isAdmin === 0)
                    <li class="nav-item dropdown-hover d-none d-lg-block">
                        <a class="nav-link" href="{{ route('home') }}">
                            Beranda
                        </a>
                    </li>
                @endif
            </ul>
            <div class="d-block d-lg-none py-4">
                <a href="#" class="text-nowrap logo-img">
                    <img src="{{ asset('assets/backend/images/logos/Logo-uk-kecil.png') }}" class="dark-logo"
                        alt="Logo-Dark" />
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">

                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{ asset('assets/backend/images/profile/user-7.png') }}"
                                            class="rounded-circle" width="35" height="35" alt="modernize-img" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">Profil Kamu</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="{{ asset('assets/backend/images/profile/user-7.png') }}"
                                            class="rounded-circle" width="80" height="80" alt="modernize-img" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                            <span
                                                class="mb-1 d-block">{{ Auth::user()->isAdmin == '1' ? 'admin' : '' }}</span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">


                                        <!--  -->
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                                            class="btn btn-outline-primary">
                                            Keluar
                                        </a>

                                        {{-- @if (session()->has('impersonated_by'))
                                            <a href="{{ route('impersonate.leave') }}" class="btn btn-warning">
                                                Kembali ke Admin
                                            </a>
                                        @endif --}}

                                        <form action="{{ route('logout') }}" method="post" id="logout-form">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- ---------------------------------- -->
        <!-- End Vertical Layout Header -->
        <!-- ---------------------------------- -->

        <!-- ------------------------------- -->
        <!-- apps Dropdown in Small screen -->
        <!-- ------------------------------- -->
        <!--  Mobilenavbar -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <nav class="sidebar-nav scroll-sidebar">
                <div class="offcanvas-header justify-content-between">
                    <img src="{{ asset('assets/backend/images/logos/favicon.png') }}" alt="modernize-img"
                        class="img-fluid" />
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

            </nav>
        </div>
    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <div class="d-block d-xl-none">
                <a href="#" class="text-nowrap nav-link">
                    <img src="{{ asset('assets/backend/images/logos/dark-logo.svg') }}" width="180"
                        alt="modernize-img" />
                </a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">

                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <!-- ------------------------------- -->
                        <!-- start language Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                <i class="ti ti-moon moon"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)">
                                <i class="ti ti-sun sun"></i>
                            </a>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end language Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{ asset('assets/backend/images/profile/user-7.png') }}"
                                            class="rounded-circle" width="35" height="35"
                                            alt="modernize-img" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">Profil Kamu</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="{{ asset('assets/backend/images/profile/user-7.png') }}"
                                            class="rounded-circle" width="80" height="80"
                                            alt="modernize-img" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">Mathew Anderson</h5>
                                            <span class="mb-1 d-block">Designer</span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i> info@modernize.com
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
