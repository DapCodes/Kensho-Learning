@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Selamat datang kembali <strong>{{ Auth::user()->name }}!</strong></h3>
                        <p class="text-white-75 mb-3">Pantau semua data dari aplikasi anda!</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Beranda
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="user-dashboard"
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

        <!-- Enhanced Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm stats-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-file-text text-primary" style="font-size: 24px;"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1">{{ $stats['totalQuizzes'] }}</h3>
                        <p class="text-muted mb-0">Total Quiz</p>
                        <small class="text-success">
                            <i class="ti ti-arrow-up"></i>
                            {{ $stats['activeQuizzes'] }} aktif bulan ini
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm stats-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-users text-success" style="font-size: 24px;"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1">{{ $stats['totalPeserta'] }}</h3>
                        <p class="text-muted mb-0">Total Peserta</p>
                        <small class="text-info">
                            <i class="ti ti-check"></i>
                            {{ $stats['totalSubmissions'] }} submissions
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm stats-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-chart-line text-warning" style="font-size: 24px;"></i>
                        </div>
                        <h3 class="fw-bold text-warning mb-1">{{ $stats['averageScore'] }}%</h3>
                        <p class="text-muted mb-0">Rata-rata Skor</p>
                        <small class="text-primary">
                            {{ $stats['completionRate'] }}% completion rate
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm stats-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-info-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-file-description text-info" style="font-size: 24px;"></i>
                        </div>
                        <h3 class="fw-bold text-info mb-1">{{ $stats['totalSoal'] }}</h3>
                        <p class="text-muted mb-0">Total Soal</p>
                        @if($pendingEssaysCount > 0)
                            <small class="text-danger">
                                <i class="ti ti-alert-circle"></i>
                                {{ $pendingEssaysCount }} essay pending
                            </small>
                        @else
                            <small class="text-success">
                                <i class="ti ti-check"></i>
                                Semua terkoreksi
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">
                            <i class="ti ti-bolt me-2"></i>Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('quiz.create') }}" class="btn btn-primary w-100 p-3 action-card">
                                    <i class="ti ti-plus d-block mb-2" style="font-size: 28px;"></i>
                                    <strong>Buat Quiz Baru</strong>
                                    <small class="d-block text-white-75 mt-1">Tambah quiz untuk peserta</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('quiz.index') }}" class="btn btn-outline-primary w-100 p-3 action-card">
                                    <i class="ti ti-list d-block mb-2" style="font-size: 28px;"></i>
                                    <strong>Kelola Quiz</strong>
                                    <small class="d-block text-muted mt-1">Edit & hapus quiz</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-outline-success w-100 p-3 action-card">
                                    <i class="ti ti-chart-bar d-block mb-2" style="font-size: 28px;"></i>
                                    <strong>Lihat Hasil</strong>
                                    <small class="d-block text-muted mt-1">Analisis performa</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                @if($pendingEssaysCount > 0)
                                    <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-outline-warning w-100 p-3 action-card position-relative">
                                        <i class="ti ti-edit d-block mb-2" style="font-size: 28px;"></i>
                                        <strong>Koreksi Essay</strong>
                                        <small class="d-block text-muted mt-1">{{ $pendingEssaysCount }} perlu dikoreksi</small>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $pendingEssaysCount }}
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-outline-secondary w-100 p-3 action-card">
                                        <i class="ti ti-edit d-block mb-2" style="font-size: 28px;"></i>
                                        <strong>Koreksi Essay</strong>
                                        <small class="d-block text-muted mt-1">Semua terkoreksi</small>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Performance Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent d-flex justify-content-between">
                        <h5 class="mb-0">
                            <i class="ti ti-trophy me-2"></i>Quiz Terpopuler
                        </h5>
                        <a href="{{ route('quiz.index') }}">
                            Tampilkan semua quiz?
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($quizPerformance as $index => $performance)
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <div class="position-relative mb-3">
                                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center text-white fw-bold" 
                                                     style="width: 40px; height: 40px;">
                                                    {{ $loop->iteration }}
                                                </div>
                                                @if($index == 1)
                                                    <i class="ti ti-crown text-warning position-absolute" style="top: -5px; right: -5px; font-size: 20px;"></i>
                                                @endif
                                            </div>
                                            <h6 class="mb-2">{{ Str::limit($performance['judul'], 25) }}</h6>
                                            <div class="d-flex justify-content-between text-muted small mb-2">
                                                <span><i class="ti ti-users me-1"></i>{{ $performance['total_peserta'] }}</span>
                                                <span class="badge bg-primary">{{ number_format($performance['rata_rata_skor'], 1) }}%</span>
                                            </div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $performance['rata_rata_skor'] }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-4 text-muted">
                                        <i class="ti ti-file-text display-4"></i>
                                        <p class="mt-2">Belum ada data performa quiz</p>
                                        <a href="{{ route('quiz.create') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-1"></i>Buat Quiz Pertama
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-message me-2"></i>Pesan Masuk
                            @if($recentMessages->count() > 0)
                                <span class="badge bg-primary ms-2">{{ $recentMessages->count() }}</span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($recentMessages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 20%">Nama Pengirim</th>
                                            <th style="width: 20%">Email</th>
                                            <th style="width: 35%">Pesan</th>
                                            <th style="width: 10%">Tanggal</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentMessages as $index => $pesan)
                                            <tr id="message-{{ $pesan->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            <i class="ti ti-user text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $pesan->nama_pengirim }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="mailto:{{ $pesan->email_pengirim }}" class="text-decoration-none">
                                                        {{ $pesan->email_pengirim }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="message-content">
                                                        {{ Str::limit($pesan->pesan, 50) }}
                                                        @if(strlen($pesan->pesan) > 50)
                                                            <button class="btn btn-sm btn-link p-0 text-decoration-none" 
                                                                    onclick="toggleMessage({{ $pesan->id }})">
                                                                <small>Lihat selengkapnya</small>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div id="full-message-{{ $pesan->id }}" class="full-message d-none">
                                                        {{ $pesan->pesan }}
                                                        <button class="btn btn-sm btn-link p-0 text-decoration-none" 
                                                                onclick="toggleMessage({{ $pesan->id }})">
                                                            <small>Tutup</small>
                                                        </button>
                                                    </div>
                                                </td>
                                                @php
                                                    \Carbon\Carbon::setLocale('id');
                                                @endphp
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $pesan->created_at->diffForHumans() }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <form action="{{ route('pesan.destroy', $pesan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="ti ti-message-circle display-4"></i>
                                <p class="mt-2">Belum ada pesan masuk</p>
                                <small>Pesan dari pengguna akan muncul di sini</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Styles -->
    <style>
        .stats-card {
            border-radius: 15px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .action-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 2px solid;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 15px;
            border: none;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .avatar-sm {
            width: 35px;
            height: 35px;
        }

        .message-content {
            max-width: 300px;
            word-wrap: break-word;
        }

        .full-message {
            max-width: 300px;
            word-wrap: break-word;
        }

        .table th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Animation for stats cards */
        .stats-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }

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

        /* Responsive improvements */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }
            
            .stats-card .card-body {
                padding: 1.5rem;
            }

            .action-card {
                margin-bottom: 1rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing animations and functionality
            const cards = document.querySelectorAll('.stats-card, .action-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Check for pending essays and show notification
            const pendingEssaysCount = {{ $pendingEssaysCount ?? 0 }};
            if (pendingEssaysCount > 0) {
                showNotification(`Anda memiliki ${pendingEssaysCount} essay yang perlu dikoreksi`, 'warning');
            }

            // Notification system
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }
        });

        // Toggle message content
        function toggleMessage(messageId) {
            const shortMessage = document.querySelector(`#message-${messageId} .message-content`);
            const fullMessage = document.getElementById(`full-message-${messageId}`);
            
            if (fullMessage.classList.contains('d-none')) {
                shortMessage.classList.add('d-none');
                fullMessage.classList.remove('d-none');
            } else {
                shortMessage.classList.remove('d-none');
                fullMessage.classList.add('d-none');
            }
        }

        // View message detail
        function viewMessage(messageId) {
            fetch(`/admin/pesan/${messageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = document.getElementById('messageModal');
                        const modalBody = document.getElementById('messageModalBody');
                        
                        modalBody.innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Nama Pengirim:</h6>
                                    <p>${data.pesan.nama_pengirim}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Email:</h6>
                                    <p><a href="mailto:${data.pesan.email_pengirim}">${data.pesan.email_pengirim}</a></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Pesan:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        ${data.pesan.pesan}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <small class="text-muted">Dikirim pada: ${data.pesan.created_at}</small>
                                </div>
                            </div>
                        `;
                        
                        const bootstrapModal = new bootstrap.Modal(modal);
                        bootstrapModal.show();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat memuat pesan', 'danger');
                });
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
    </script>
    @include('layouts.components-backend.css')
@endsection