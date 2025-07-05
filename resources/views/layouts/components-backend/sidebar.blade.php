<aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./main/index.html" class="text-nowrap logo-img">
            <img src="{{asset('/assets/backend/images/logos/dark-logo.svg')}}" class="dark-logo m-1" alt="Logo-Dark"  />
            <img src="{{asset('/assets/backend/images/logos/light-logo.svg')}}" class="light-logo m-1" alt="Logo-light" />
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          @if(Auth::user()->isAdmin == 1)
          <ul id="sidebarnav">
            <!-- ---------------------------------- -->
            <!-- Home -->
            <!-- ---------------------------------- -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Dasbor</span>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between" href="{{ route('admin.quiz-terbaru') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-home"></i>
                  </span>
                  <span class="hide-menu">Beranda</span>
                </div>
                <span class="hide-menu badge rounded-pill border border-primary text-primary fs-2 py-1 px-2">★</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Kelola</span>
            </li> 
            <li class="sidebar-item">
              <a class="sidebar-link" href="https://google.com" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">User</span>
              </a>
            </li>
                        
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('kategori.index') }}" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-box"></i>
                </span>
                <span class="hide-menu">Kategori</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow" 
                href="#quizSubmenu" 
                data-bs-toggle="collapse" 
                data-bs-target="#quizSubmenu"
                aria-expanded="false" 
                aria-controls="quizSubmenu">
                <span class="d-flex">
                  <i class="ti ti-chart-donut-3"></i>
                </span>
                <span class="hide-menu">Quiz</span>
              </a>
              <ul id="quizSubmenu" class="collapse first-level">
                <li class="sidebar-item" >
                  <a href="{{ route('quiz.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Lihat Quiz</span>
                  </a>
                </li>
                <li class="sidebar-item">
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
            <!-- ---------------------------------- -->
            <!-- Home -->
            <!-- ---------------------------------- -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Dasbor</span>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between" href="{{ route('dasbor') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-home"></i>
                  </span>
                  <span class="hide-menu">Quiz Terbaru</span>
                </div>
                <span class="hide-menu badge rounded-pill border border-primary text-primary fs-2 py-1 px-2">★</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('histori-pengerjaan') }}" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Riwayat Pengerjaan</span>
              </a>
            </li>
          </ul>

          @endif
        </nav>
        <div class="fixed-profile p-3 mx-4 mb-3 bg-secondary-subtle rounded">
          <div class="hstack gap-3">
            <div class="john-img">
              <img src="{{asset('/assets/backend/images/profile/user-1.jpg')}}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
            </div>
            <div class="john-title">
              <h6 class="mb-0 fs-4 fw-semibold">{{Auth::user()->name}}</h6>
              <span class="fs-2">{{Auth::user()->isAdmin == 1 ? 'admin' : 'user'}}</span>
            </div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()" class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="a" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
              <i class="ti ti-power fs-6"></i>
            </a>
          </div>
        </div>

        <form action="{{route('logout')}}" method="post" id="logout-form">
          @csrf
        </form>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
      </div>
    </aside>