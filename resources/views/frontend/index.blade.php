@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Quiz Terbaru!!</h3>
                        <p class="text-white-75 mb-3">Kerjakan quiz dengan jujur dan bersungguh-sungguh</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Dasbor
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="quiz-dashboard"
                                class="img-fluid" style="max-height: 120px; filter: brightness(1.1);" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative elements -->
            <div class="position-absolute top-0 end-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
            </div>
            <div class="position-absolute bottom-0 start-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-0">Quiz yang anda cari tidak di temukan??</h5>
                        <small class="text-muted">Masukan kode quiz pada kolom sebelah kanan!!</small>
                    </div>
                    <div class="col-md-4 text-end">
                        <form action="{{ route('quiz.checkKode') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="text" name="kode_quiz" class="form-control me-2"
                                placeholder="Masukkan kode quiz..." required>
                            <button type="submit" class="btn btn-primary">Cek</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Kiri: Teks -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        Pilih kategori quiz yang anda inginkan !! <br>
                        <small>terdapat {{ $mataPelajaran->count() }} Mata Pelajaran</small>
                    </div>

                    <!-- Kanan: Tombol Kategori -->
                    <div class="col-md-8">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <!-- Tombol Semua -->
                            <button
                                class="btn btn-outline-primary kategori-btn {{ request('mata_pelajaran_id') ? '' : 'active' }}"
                                data-id="">
                                Semua
                            </button>

                            <!-- Tombol dari setiap kategori -->
                            @foreach ($mataPelajaran as $kat)
                                <button
                                    class="btn btn-outline-primary kategori-btn {{ request('mata_pelajaran_id') == $kat->id ? 'active' : '' }}"
                                    data-id="{{ $kat->id }}">
                                    {{ $kat->nama_mapel }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-0">
                            <i class="ti ti-search me-2"></i>Cari Quiz
                        </h5>
                        <small class="text-muted">Temukan quiz berdasarkan judul yang anda inginkan</small>
                    </div>
                    <div class="col-md-4">
                        <div class="search-container position-relative">
                            <input type="text" id="searchInput" class="form-control ps-5" 
                                placeholder="Cari berdasarkan judul quiz...">
                            <div class="search-icon position-absolute top-50 start-0 translate-middle-y ms-3">
                                <i class="ti ti-search text-muted"></i>
                            </div>
                            <button type="button" id="clearSearch" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" style="display: flex;">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Search Results Info -->
                <div id="searchInfo" class="mt-3" style="display: none;">
                    <div class="alert alert-info py-2 px-3 mb-0">
                        <i class="ti ti-info-circle me-2"></i>
                        <span id="searchResultText"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Cards -->
        <div class="row" id="quizContainer">
            @php
                $recentQuizzes = $quizzes->where('created_at', '>=', now()->subDays(7));
            @endphp

           @forelse($quizzes as $index => $quiz)
   @php
       $attempted = $quiz->hasilUjian->where('user_id', auth()->id())->isNotEmpty();
       $canRetake = $quiz->pengulangan_pekerjaan !== 'Tidak';
       $isDisabled = $attempted && !$canRetake;
   @endphp
   
   <div class="col-lg-4 col-md-6 col-sm-12 mb-4 quiz-item" data-quiz-title="{{ strtolower($quiz->judul_quiz) }}">
       <div class="card quiz-card h-100 position-relative {{ $isDisabled ? 'opacity-50' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
           @if($attempted)
               <div class="position-absolute top-0 end-0 m-2 bg-success text-white px-2 py-1 rounded-pill small fw-bold" style="z-index: 10;">
                   ✔ Completed
               </div>
           @endif
           
           <div class="card-body pb-0">
               <h5 class="card-title fw-bold mb-2 quiz-title" title="{{ $quiz->judul_quiz }}">
                   {{ Str::limit($quiz->judul_quiz, 45) }}
               </h5>

               <p class="card-text text-muted small mb-3">
                   {{ $quiz->deskripsi ? Str::limit($quiz->deskripsi, 80) : 'Tidak ada deskripsi' }}
               </p>

               @if ($quiz->kode_quiz)
                   <div class="mb-3">
                       <div class="d-flex align-items-center justify-content-between bg-light rounded p-2">
                           <div class="d-flex align-items-center">
                               <i class="ti ti-key text-primary me-2"></i>
                               <span class="fw-semibold">{{ $quiz->kode_quiz }}</span>
                           </div>
                           <button class="btn btn-sm btn-outline-primary copy-btn" data-quiz-code="{{ $quiz->kode_quiz }}" title="Salin Kode Quiz">
                               <i class="ti ti-copy"></i>
                           </button>
                       </div>
                   </div>
               @endif

               <div class="row text-center mb-3">
                   <div class="col-4">
                       <div class="stats-item">
                           <i class="ti ti-file-text text-primary d-block mb-1"></i>
                           <span class="fw-bold d-block">{{ $quiz->soals->count() }}</span>
                           <small class="text-muted">Soal</small>
                       </div>
                   </div>
                   <div class="col-4">
                       <div class="stats-item">
                           <i class="ti ti-clock text-warning d-block mb-1"></i>
                           <span class="fw-bold d-block">{{ $quiz->waktu_menit }}</span>
                           <small class="text-muted">Menit</small>
                       </div>
                   </div>
                   <div class="col-4">
                       <div class="stats-item">
                           <i class="ti ti-calendar text-info d-block mb-1"></i>
                           <span class="fw-bold d-block">{{ \Carbon\Carbon::parse($quiz->tanggal_buat)->format('d/m') }}</span>
                           <small class="text-muted">Dibuat</small>
                       </div>
                   </div>
               </div>

               @php
                   \Carbon\Carbon::setLocale('id');
               @endphp
               <div class="mb-3">
                   <small class="text-muted">
                       <i class="ti ti-calendar me-1"></i>
                       Dibuat {{ \Carbon\Carbon::parse($quiz->tanggal_buat)->diffForHumans() }}
                   </small>
               </div>
           </div>

           <div class="card-footer bg-transparent border-0 pt-0">
               <div class="row g-2">
                   <div class="col-12">
                       @if($isDisabled)
                           <button class="btn btn-secondary w-100 btn-action disabled" disabled>
                               Tidak Dapat Diulang
                           </button>
                       @else
                           <a href="{{ route('quiz.detail', $quiz->id) }}" class="btn btn-primary w-100 btn-action">
                               {{ $attempted ? 'Kerjakan Lagi' : 'Kerjakan Sekarang!' }}
                           </a>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>
@empty
   <div class="col-12" id="emptyState">
       <div class="card text-center py-5">
           <div class="card-body">
               <div class="mb-4">
                   <i class="ti ti-file-text display-1 text-muted"></i>
               </div>
               <h3 class="mb-3">Tidak Ada Quiz Terbaru</h3>
               <p class="text-muted mb-4">
                   Belum ada quiz yang dibuat dalam 7 hari terakhir.
               </p>
           </div>
       </div>
   </div>
@endforelse
        </div>

        <!-- No Results State -->
        <div class="row" id="noResultsState" style="display: none;">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="ti ti-search display-1 text-muted"></i>
                        </div>
                        <h3 class="mb-3">Tidak Ada Quiz Ditemukan</h3>
                        <p class="text-muted mb-4">
                            Tidak ada quiz yang sesuai dengan pencarian "<span id="searchTerm" class="fw-bold"></span>"
                        </p>
                        <button class="btn btn-primary" onclick="clearSearch()">
                            <i class="ti ti-refresh me-2"></i>Tampilkan Semua Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show All Quizzes Button -->
        @if ($recentQuizzes->count() > 0 && $quizzes->count() > $recentQuizzes->count())
            <div class="text-center mt-4">
                <button class="btn btn-outline-primary" id="showAllQuizzes">
                    <i class="ti ti-eye me-2"></i>Lihat Semua Quiz ({{ $quizzes->count() - $recentQuizzes->count() }}
                    lainnya)
                </button>
            </div>
        @endif
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="position-fixed top-0 end-0 p-4" style="z-index: 1050;"></div>

    <!-- Enhanced Toast Messages -->
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 20px; height: 20px;">
                        <i class="ti ti-check text-success" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">Berhasil</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 20px; height: 20px;">
                        <i class="ti ti-x text-danger" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif


    <style>
        :root {
            --primary-color: #5d87ff;
            --success-color: #13deb9;
            --warning-color: #ffae1f;
            --info-color: #539bff;
            --danger-color: #fa896b;
        }

        .modern-card {
            border-radius: 15px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .quiz-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .quiz-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .delete-btn {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .new-badge {
            border-radius: 15px;
            font-size: 0.75rem;
            padding: 5px 10px;
            box-shadow: 0 2px 10px rgba(19, 222, 185, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .copy-btn {
            border-radius: 8px;
            padding: 4px 8px;
            transition: all 0.2s ease;
        }

        .copy-btn:hover {
            transform: scale(1.1);
        }

        .stats-item {
            padding: 10px 5px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .stats-item:hover {
            background: rgba(93, 135, 255, 0.1);
        }

        .btn-action {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .toast {
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            min-width: 300px;
        }

        /* Search Styles */
        .search-container {
            position: relative;
        }

        .search-container .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding-left: 2.5rem;
        }

        .search-container .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(93, 135, 255, 0.25);
        }

        .search-icon {
            z-index: 10;
        }

        .quiz-item {
            transition: all 0.3s ease;
        }

        .quiz-item.fade-out {
            opacity: 0;
            transform: scale(0.9);
        }

        .quiz-item.fade-in {
            opacity: 1;
            transform: scale(1);
        }

        /* Highlight search matches */
        .search-highlight {
            background-color: rgba(255, 193, 7, 0.3);
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .quiz-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .quiz-card {
                margin-bottom: 20px;
            }

            .modern-card {
                margin-bottom: 15px;
            }

            .btn-action {
                font-size: 0.875rem;
                padding: 8px 12px;
            }

            .search-container .form-control {
                font-size: 0.875rem;
            }
        }
    </style>

    <script>
        // Search functionality
        class QuizSearchFilter {
            constructor() {
                this.searchInput = document.getElementById('searchInput');
                this.clearButton = document.getElementById('clearSearch');
                this.searchInfo = document.getElementById('searchInfo');
                this.searchResultText = document.getElementById('searchResultText');
                this.quizContainer = document.getElementById('quizContainer');
                this.noResultsState = document.getElementById('noResultsState');
                this.quizItems = document.querySelectorAll('.quiz-item');
                this.searchTerm = document.getElementById('searchTerm');
                
                this.init();
            }

            init() {
                // Real-time search
                this.searchInput.addEventListener('input', (e) => {
                    this.performSearch(e.target.value);
                });

                // Clear search
                this.clearButton.addEventListener('click', () => {
                    this.clearSearch();
                });

                // Clear on escape key
                this.searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.clearSearch();
                    }
                });
            }

            performSearch(query) {
                const searchTerm = query.toLowerCase().trim();
                
                if (searchTerm === '') {
                    this.showAllQuizzes();
                    this.hideSearchInfo();
                    this.hideClearButton();
                    return;
                }

                this.showClearButton();
                this.filterQuizzes(searchTerm);
            }

            filterQuizzes(searchTerm) {
                let visibleCount = 0;
                let totalCount = this.quizItems.length;

                this.quizItems.forEach((item) => {
                    const title = item.getAttribute('data-quiz-title');
                    const titleElement = item.querySelector('.quiz-title');
                    
                    if (title.includes(searchTerm)) {
                        this.showQuizItem(item);
                        this.highlightSearchTerm(titleElement, searchTerm);
                        visibleCount++;
                    } else {
                        this.hideQuizItem(item);
                        this.removeHighlight(titleElement);
                    }
                });

                this.updateSearchInfo(visibleCount, totalCount, searchTerm);
                this.toggleNoResultsState(visibleCount === 0, searchTerm);
            }

            showQuizItem(item) {
                item.style.display = 'block';
                item.classList.remove('fade-out');
                item.classList.add('fade-in');
            }

            hideQuizItem(item) {
                item.classList.remove('fade-in');
                item.classList.add('fade-out');
                
                setTimeout(() => {
                    if (item.classList.contains('fade-out')) {
                        item.style.display = 'none';
                    }
                }, 300);
            }

            highlightSearchTerm(element, searchTerm) {
                const originalText = element.getAttribute('title') || element.textContent;
                const regex = new RegExp(`(${this.escapeRegExp(searchTerm)})`, 'gi');
                const highlightedText = originalText.replace(regex, '<span class="search-highlight">$1</span>');
                element.innerHTML = highlightedText;
            }

            removeHighlight(element) {
                const originalText = element.getAttribute('title') || element.textContent;
                element.innerHTML = originalText;
            }

            escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            showAllQuizzes() {
                this.quizItems.forEach((item) => {
                    this.showQuizItem(item);
                    const titleElement = item.querySelector('.quiz-title');
                    this.removeHighlight(titleElement);
                });
                this.toggleNoResultsState(false);
            }

            updateSearchInfo(visibleCount, totalCount, searchTerm) {
                if (visibleCount === 0) {
                    this.hideSearchInfo();
                    return;
                }

                const message = `Menampilkan ${visibleCount} dari ${totalCount} quiz untuk pencarian "${searchTerm}"`;
                this.searchResultText.textContent = message;
                this.showSearchInfo();
            }

            showSearchInfo() {
                this.searchInfo.style.display = 'block';
            }

            hideSearchInfo() {
                this.searchInfo.style.display = 'none';
            }

            toggleNoResultsState(show, searchTerm = '') {
                if (show) {
                    this.searchTerm.textContent = searchTerm;
                    this.noResultsState.classList.remove('d-none');
                    this.quizContainer.classList.add('d-none');   // sembunyikan grid
                } else {
                    this.noResultsState.classList.add('d-none');
                    this.quizContainer.classList.remove('d-none'); // tampilkan grid
                }
            }

            showClearButton() {
                this.clearButton.style.display = 'block';
            }

            hideClearButton() {
                this.clearButton.style.display = 'none';
            }

            clearSearch() {
                this.searchInput.value = '';
                this.showAllQuizzes();
                this.hideSearchInfo();
                this.hideClearButton();
                this.searchInput.focus();
            }
        }

        // Global function for clear search button in no results state
        function clearSearch() {
            const searchFilter = window.quizSearchFilter;
            if (searchFilter) {
                searchFilter.clearSearch();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize search filter
            window.quizSearchFilter = new QuizSearchFilter();

            // Original category filter functionality
            const buttons = document.querySelectorAll('.kategori-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const mataPelajaranId = this.getAttribute('data-id');
                    const url = new URL(window.location.href);
                    if (mataPelajaranId) {
                        url.searchParams.set('mata_pelajaran_id', mataPelajaranId);
                    } else {
                        url.searchParams.delete('mata_pelajaran_id');
                    }
                    window.location.href = url.toString();
                });
            });

            // Handle copy buttons
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const quizCode = this.getAttribute('data-quiz-code');

                    if (copyToClipboard(quizCode)) {
                        showToast(`Kode quiz <strong>${quizCode}</strong> berhasil disalin!`, 'success');

                        // Visual feedback
                        const originalHTML = this.innerHTML;
                        this.innerHTML = '<i class="ti ti-check"></i>';
                        this.classList.add('btn-success');
                        this.classList.remove('btn-outline-primary');

                        setTimeout(() => {
                            this.innerHTML = originalHTML;
                            this.classList.remove('btn-success');
                            this.classList.add('btn-outline-primary');
                        }, 1000);
                    } else {
                        showToast(`Gagal menyalin kode. Kode quiz: ${quizCode}`, 'error');
                    }
                });
            });

            // Show all quizzes functionality
            const showAllBtn = document.getElementById('showAllQuizzes');
            if (showAllBtn) {
                showAllBtn.addEventListener('click', function() {
                    window.location.href = '{{ route('quiz.index') }}?show_all=true';
                });
            }
        });

        // Simple and reliable copy function
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            textarea.style.top = '0';
            textarea.style.left = '0';

            document.body.appendChild(textarea);
            textarea.select();
            textarea.setSelectionRange(0, 99999);

            let success = false;
            try {
                success = document.execCommand('copy');
            } catch (err) {
                console.error('Copy failed:', err);
            }

            document.body.removeChild(textarea);
            return success;
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            toastContainer.innerHTML = '';

            const toast = document.createElement('div');
            toast.className = `toast show`;
            toast.setAttribute('role', 'alert');

            const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
            const icon = type === 'success' ? 'ti-check' : type === 'error' ? 'ti-x' : 'ti-info-circle';

            toast.innerHTML = `
                <div class="toast-header ${bgColor} text-white border-0">
                    <i class="ti ${icon} me-2"></i>
                    <strong class="me-auto">${type === 'success' ? 'Berhasil' : type === 'error' ? 'Error' : 'Info'}</strong>
                    <button type="button" class="btn-close btn-close-white ms-2" onclick="this.closest('.toast').remove()"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 4000);
        }
    </script>
@endsection