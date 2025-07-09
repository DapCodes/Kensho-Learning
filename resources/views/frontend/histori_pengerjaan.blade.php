@extends('layouts.backend')
@section('content')
<div class="container-fluid">
    <!-- Enhanced Header Section -->
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Histori Pengerjaan Quiz</h3>
                    <p class="text-white-75 mb-3">Pantau semua hasil quiz yang telah Anda kerjakan</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="">
                                    <i class="ti ti-home me-1"></i>Dasbor
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Histori Quiz</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <img src="{{asset('assets/backend/images/breadcrumb/ChatBc.png')}}" 
                             alt="quiz-dashboard" 
                             class="img-fluid" 
                             style="max-height: 120px; filter: brightness(1.1);" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="position-absolute top-0 end-0 opacity-25">
            <div class="bg-white rounded-circle" style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
        </div>
        <div class="position-absolute bottom-0 start-0 opacity-25">
            <div class="bg-white rounded-circle" style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="ti ti-file-text text-primary" style="font-size: 24px;"></i>
                    </div>
                    <h4 class="fw-bold text-primary mb-1">{{ $histori->count() ?? 0 }}</h4>
                    <p class="text-muted mb-0">Total Quiz</p>
                </div>
            </div>
        </div>
        @php
    $totalBenar = $histori->sum('jumlah_benar');
    $totalSalah = $histori->sum('jumlah_salah');
@endphp

<div class="col-md-3">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
            <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-3" 
                 style="width: 60px; height: 60px;">
                <i class="ti ti-check text-success" style="font-size: 24px;"></i>
            </div>
            <h4 class="fw-bold text-success mb-1">{{ $totalBenar }}</h4>
            <p class="text-muted mb-0">Jawaban Benar</p>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
            <div class="rounded-circle bg-danger-subtle d-inline-flex align-items-center justify-content-center mb-3" 
                 style="width: 60px; height: 60px;">
                <i class="ti ti-x text-danger" style="font-size: 24px;"></i>
            </div>
            <h4 class="fw-bold text-danger mb-1">{{ $totalSalah }}</h4>
            <p class="text-muted mb-0">Jawaban Salah</p>
        </div>
    </div>
</div>

        <div class="col-md-3">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
            <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center mb-3" 
                 style="width: 60px; height: 60px;">
                <i class="ti ti-star text-warning" style="font-size: 24px;"></i>
            </div>

            @php
                $rataRata = $histori->avg('skor');
            @endphp
            <h4 class="fw-bold text-warning mb-1">{{ number_format($rataRata ?? 0, 1) }}</h4>
            <p class="text-muted mb-0">Rata-rata skor</p>
        </div>
    </div>
</div>


    <!-- Enhanced Action Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="ti ti-history text-success"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">Riwayat Pengerjaan Quiz</h5>
                            <p class="text-muted mb-0">
                                @if($histori)
                                    Menampilkan semua hasil quiz yang telah Anda kerjakan
                                @else
                                    Belum ada riwayat pengerjaan quiz
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success btn-lg px-4" onclick="exportToExcel()">
                            <i class="ti ti-file-spreadsheet me-2"></i>Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-lg px-4" onclick="exportToPDF()">
                            <i class="ti ti-file-type-pdf me-2"></i>Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Histori Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="ti ti-table me-2 text-success"></i>Tabel Histori Pengerjaan
                </h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success-subtle text-success px-3 py-2">
                        {{ $histori->count() }} Hasil Tersedia
                    </span>
                </div>
            </div>
        </div>
        
        @if($histori)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover histori-table mb-0" id="historiTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                    <i class="ti ti-hash me-1"></i>No
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                    <i class="ti ti-file-text me-1"></i>Judul Quiz
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-calendar me-1"></i>Tanggal
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-star me-1"></i>Skor
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-check-circle me-1"></i>Benar
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-x-circle me-1"></i>Salah
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-clock me-1"></i>Waktu
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-award me-1"></i>Status
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-point me-1"></i>Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach ($histori as $index => $item)
        <tr class="histori-row">
            <td class="py-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" 
                         style="width: 35px; height: 35px;">
                        <span class="text-success fw-bold">{{ $index + 1 }}</span>
                    </div>
                </div>
            </td>

            <td class="py-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3" 
                         style="width: 40px; height: 40px;">
                        <i class="ti ti-file-text text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">
                            {{ $item->quiz->judul_quiz ?? 'Quiz Title' }}
                        </h6>
                        <small class="text-muted">
                            {{ $item->quiz->kategori->nama_kategori ?? 'Kategori Umum' }}
                        </small>
                    </div>
                </div>
            </td>

            <td class="py-4 text-center">
                <div class="d-flex flex-column align-items-center">
                    <span class="fw-bold text-dark">
                        {{ $item->tanggal_ujian ? \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y') : date('d M Y') }}
                    </span>
                    <small class="text-muted">
                        {{ $item->created_at ? $item->created_at->format('H:i') : date('H:i') }}
                    </small>
                </div>
            </td>

            <td class="py-4 text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-2" 
                         style="width: 30px; height: 30px;">
                        <i class="ti ti-star text-warning" style="font-size: 14px;"></i>
                    </div>
                    <span class="fw-bold text-warning">{{ $item->skor }}</span>
                </div>
            </td>

            <td class="py-4 text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-2" 
                         style="width: 30px; height: 30px;">
                        <i class="ti ti-check text-success" style="font-size: 14px;"></i>
                    </div>
                    <span class="fw-bold text-success">{{ $item->jumlah_benar }}</span>
                </div>
            </td>

            <td class="py-4 text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center me-2" 
                         style="width: 30px; height: 30px;">
                        <i class="ti ti-x text-danger" style="font-size: 14px;"></i>
                    </div>
                    <span class="fw-bold text-danger">{{ $item->jumlah_salah }}</span>
                </div>
            </td>

            <td class="py-4 text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-2" 
                         style="width: 30px; height: 30px;">
                        <i class="ti ti-clock text-info" style="font-size: 14px;"></i>
                    </div>

                                @php
                                    $totalDetik = round($item->waktu_pengerjaan * 60);
                                    $menit = floor($totalDetik / 60);
                                    $detik = $totalDetik % 60;
                                @endphp

                                {{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}

                </div>
            </td>

            @php
                $totalSoal = $item->jumlah_benar + $item->jumlah_salah;
                $persentase = $totalSoal > 0 ? round(($item->jumlah_benar / $totalSoal) * 100, 1) : 0;
                $status = $persentase >= 75 ? 'Lulus' : ($persentase >= 50 ? 'Cukup' : 'Tidak Lulus');
                $statusColor = $persentase >= 75 ? 'success' : ($persentase >= 50 ? 'warning' : 'danger');
                $statusIcon = $persentase >= 75 ? 'check-circle' : ($persentase >= 50 ? 'clock' : 'x-circle');
            @endphp

            <td class="py-4 text-center">
                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} px-3 py-2">
                    <i class="ti ti-{{ $statusIcon }} me-1"></i>
                    {{ $status }}
                </span>
            </td>
            <td class="py-4 text-center pe-4">
                <div class="btn-group" role="group">
                    <a href="{{ route('quiz.hasil', $item->id) }}" 
                        class="btn btn-info btn-sm" 
                        title="Lihat Detail">
                                    <i class="ti ti-eye"></i>
                                    Lihat
                                            </a>
                                        </div>
                                    </td>
        </tr>
    @endforeach
</tbody>

                    </table>
                </div>
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 100px; height: 100px;">
                        <i class="ti ti-history text-success" style="font-size: 48px;"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-3">Belum Ada Riwayat Quiz</h3>
                <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                    Anda belum mengerjakan quiz apapun. Mulai kerjakan quiz untuk melihat 
                    riwayat dan hasil pencapaian Anda di sini.
                </p>
                <a href="{{ route('quiz.index') }}" class="btn btn-success btn-lg px-5">
                    <i class="ti ti-play me-2"></i>Mulai Quiz Sekarang
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Enhanced Toast Messages -->
@if(session('success'))
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

@if(session('error'))
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

<script>
    // Export to Excel Function
    function exportToExcel() {
        // Simple table to Excel export
        const table = document.getElementById('historiTable');
        if (!table) {
            alert('Tidak ada data untuk diekspor');
            return;
        }

        let csvContent = '';
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            const rowData = [];
            
            cells.forEach(cell => {
                // Clean text content
                let cellText = cell.textContent.trim();
                // Remove extra whitespace and newlines
                cellText = cellText.replace(/\s+/g, ' ');
                rowData.push('"' + cellText + '"');
            });
            
            csvContent += rowData.join(',') + '\n';
        });

        // Create download link
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        link.setAttribute('download', 'histori_quiz_' + new Date().toISOString().split('T')[0] + '.csv');
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message
        showToast('success', 'Data berhasil diekspor ke Excel!');
    }

    // Export to PDF Function
    function exportToPDF() {
        // For PDF export, you would typically use a library like jsPDF
        // or send the data to a server endpoint that generates PDF
        
        // For now, we'll show a simple implementation
        window.print();
        
        // Show success message
        showToast('success', 'Halaman siap untuk dicetak sebagai PDF!');
    }

    // Toast notification function
    function showToast(type, message) {
        const toastContainer = document.createElement('div');
        toastContainer.className = 'position-fixed top-0 end-0 p-4';
        toastContainer.style.zIndex = '1050';
        
        const toastColor = type === 'success' ? 'success' : 'danger';
        const toastIcon = type === 'success' ? 'check' : 'x';
        
        toastContainer.innerHTML = `
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-${toastColor} text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2" 
                         style="width: 20px; height: 20px;">
                        <i class="ti ti-${toastIcon} text-${toastColor}" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">${type === 'success' ? 'Berhasil' : 'Error'}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    ${message}
                </div>
            </div>
        `;
        
        document.body.appendChild(toastContainer);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }

    // Print styles for PDF export
    const printStyles = `
        <style>
            @media print {
                .card-header, .btn-group, .breadcrumb, .position-fixed { display: none !important; }
                .card { border: none !important; box-shadow: none !important; }
                .table { font-size: 12px; }
                .badge { color: #000 !important; background-color: #f8f9fa !important; }
            }
        </style>
    `;
    
    document.head.insertAdjacentHTML('beforeend', printStyles);
</script>


@include('layouts.components-backend.css')
@endsection