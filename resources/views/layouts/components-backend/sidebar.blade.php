<aside class="left-sidebar with-vertical">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./main/index.html" class="text-nowrap logo-img">
                <img src="{{ asset('/assets/backend/images/logos/dark-logo.svg') }}" class="dark-logo m-1"
                    alt="Logo-Dark" />
                <img src="{{ asset('/assets/backend/images/logos/light-logo.svg') }}" class="light-logo m-1"
                    alt="Logo-light" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" style="height: 100vh" data-simplebar>
            @if (Auth::user()->isAdmin == '1' || Auth::user()->isAdmin == '2')
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Dasbor</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.quiz-terbaru') ? 'active' : '' }}">
                        <a class="sidebar-link justify-content-between" href="{{ route('admin.quiz-terbaru') }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex"><i class="ti ti-home"></i></span>
                                <span class="hide-menu">Beranda</span>
                            </div>
                            <span
                                class="hide-menu badge rounded-pill border border-primary text-primary fs-2 py-1 px-2">★</span>
                        </a>
                    </li>

                    @if ($essaySoalBelumDinilai)
                        <li class="sidebar-item {{ request()->routeIs('penilaian.dataNilai') ? 'active' : '' }}">
                            <a class="sidebar-link justify-content-between" href="{{ route('penilaian.dataNilai') }}">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-flex"><i class="ti ti-star"></i></span>
                                    <span class="hide-menu">Data Nilai</span>
                                </div>
                            </a>
                        </li>
                    @endif

                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Kelola</span>
                    </li>
                    @if (Auth::user()->isAdmin == '2')
                        <li class="sidebar-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('users.index') }}">
                                <span class="d-flex"><i class="ti ti-users"></i></span>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-item {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('kelas.index') }}">
                            <span class="d-flex"><i class="ti ti-school"></i></span>
                            <span class="hide-menu">Kelas</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('kategori.index') }}">
                            <span class="d-flex"><i class="ti ti-tags"></i></span>
                            <span class="hide-menu">Kategori</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('matapelajaran.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('matapelajaran.index') }}">
                            <span class="d-flex"><i class="ti ti-book"></i></span>
                            <span class="hide-menu">Mata Pelajaran</span>
                        </a>
                    </li>

                    <li class="sidebar-item has-arrow {{ request()->is('quiz*') ? 'active' : '' }}">
                        <a class="sidebar-link has-arrow" href="#quizSubmenu" data-bs-toggle="collapse"
                            data-bs-target="#quizSubmenu"
                            aria-expanded="{{ request()->is('quiz*') ? 'true' : 'false' }}"
                            aria-controls="quizSubmenu">
                            <span class="d-flex"><i class="ti ti-chart-donut-3"></i></span>
                            <span class="hide-menu">Quiz</span>
                        </a>
                        <ul id="quizSubmenu" class="collapse first-level {{ request()->is('quiz*') ? 'show' : '' }}">
                            <li class="sidebar-item {{ request()->routeIs('quiz.index') ? 'active' : '' }}">
                                <a href="{{ route('quiz.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Lihat Quiz</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('quiz.create') ? 'active' : '' }}">
                                <a href="{{ route('quiz.create') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Buat Quiz</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Dasbor</span>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('dasbor') ? 'active' : '' }}">
                        <a class="sidebar-link justify-content-between" href="{{ route('dasbor') }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex"><i class="ti ti-home"></i></span>
                                <span class="hide-menu">Quiz Terbaru</span>
                            </div>
                            <span
                                class="hide-menu badge rounded-pill border border-primary text-primary fs-2 py-1 px-2">★</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('histori-pengerjaan') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('histori-pengerjaan') }}">
                            <span class="d-flex"><i class="ti ti-user"></i></span>
                            <span class="hide-menu">Riwayat Pengerjaan</span>
                        </a>
                    </li>
                </ul>
            @endif
        </nav>
    </div>
</aside>
<style>
    .sidebar-item.active>.sidebar-link {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #0d6efd;
        border-radius: 0.375rem;
    }

    .sidebar-item.active i {
        color: #0d6efd;
    }
</style>
