@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Semua Mata Pelajaran Anda!!</h3>
                        <p class="text-white-75 mb-3">Kelola dan pantau semua mata pelajaran Anda dengan mudah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Mata Pelajaran</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}"
                                alt="matapelajaran-dashboard" class="img-fluid"
                                style="max-height: 120px; filter: brightness(1.1);" />
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

        <!-- Enhanced Action Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-book text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Daftar Mata Pelajaran Anda</h5>
                                <p class="text-muted mb-0">
                                    @if ($mataPelajaran->count() > 0)
                                        Menampilkan {{ $mataPelajaran->count() }} mata pelajaran dari total koleksi Anda
                                    @else
                                        Belum ada mata pelajaran yang dibuat - mulai dengan membuat mata pelajaran pertama!
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal"
                            data-bs-target="#addMataPelajaranModal">
                            <i class="ti ti-plus me-2"></i>Buat Mata Pelajaran Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Mata Pelajaran Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-table me-2 text-primary"></i>Tabel Mata Pelajaran
                    </h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                            {{ $mataPelajaran->count() }} Mata Pelajaran
                        </span>
                    </div>
                </div>
            </div>

            @if ($mataPelajaran->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover matapelajaran-table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-hash me-1"></i>No
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-book me-1"></i>Nama Mata Pelajaran
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-file-text me-1"></i>Deskripsi
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center pe-4">
                                        <i class="ti ti-settings me-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mataPelajaran as $index => $item)
                                    <tr class="matapelajaran-row" data-matapelajaran-id="{{ $item->id }}">
                                        <td class="py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="fw-bold text-primary">{{ $index + 1 }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="ti ti-book text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark" title="{{ $item->nama_mapel }}">
                                                        {{ $item->nama_mapel }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i
                                                            class="ti ti-calendar me-1"></i>{{ $item->created_at->format('d M Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div style="max-width: 300px;">
                                                @if ($item->deskripsi)
                                                    <p class="mb-0 text-muted"
                                                        style="max-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ Str::limit($item->deskripsi, 100) }}
                                                    </p>
                                                @else
                                                    <span class="text-muted fst-italic">Tidak ada deskripsi</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 text-center pe-4">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    title="Edit Mata Pelajaran" data-bs-toggle="modal"
                                                    data-bs-target="#editMataPelajaranModal"
                                                    onclick="editMataPelajaran({{ $item->id }}, '{{ addslashes($item->nama_mapel) }}', '{{ addslashes($item->deskripsi) }}')">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    title="Hapus Mata Pelajaran"
                                                    onclick="deleteMataPelajaran({{ $item->id }}, '{{ addslashes($item->nama_mapel) }}')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Hidden delete form -->
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('matapelajaran.destroy', $item->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="ti ti-book text-primary" style="font-size: 48px;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Belum Ada Mata Pelajaran</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        Mulai dengan membuat mata pelajaran pertama untuk mengorganisir konten pembelajaran Anda dengan
                        lebih baik!
                    </p>
                    <button class="btn btn-primary btn-lg px-5" data-bs-toggle="modal"
                        data-bs-target="#addMataPelajaranModal">
                        <i class="ti ti-plus me-2"></i>Buat Mata Pelajaran Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Mata Pelajaran Modal -->
    <div class="modal fade" id="addMataPelajaranModal" tabindex="-1" aria-labelledby="addMataPelajaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addMataPelajaranModalLabel">
                        <i class="ti ti-plus me-2"></i>Tambah Mata Pelajaran Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('matapelajaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_mapel" class="form-label fw-bold">
                                <i class="ti ti-book me-1"></i>Nama Mata Pelajaran
                            </label>
                            <input type="text" class="form-control @error('nama_mapel') is-invalid @enderror"
                                id="nama_mapel" name="nama_mapel" placeholder="Masukkan nama mata pelajaran..."
                                value="{{ old('nama_mapel') }}" autofocus required>
                            @error('nama_mapel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Contoh: Matematika, Bahasa Indonesia, IPA, dll.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">
                                <i class="ti ti-file-text me-1"></i>Deskripsi <span class="text-muted">(Opsional)</span>
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                rows="3" placeholder="Masukkan deskripsi mata pelajaran...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Deskripsi singkat tentang mata pelajaran ini.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Simpan Mata Pelajaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Mata Pelajaran Modal -->
    <div class="modal fade" id="editMataPelajaranModal" tabindex="-1" aria-labelledby="editMataPelajaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editMataPelajaranModalLabel">
                        <i class="ti ti-edit me-2"></i>Edit Mata Pelajaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editMataPelajaranForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_mapel" class="form-label fw-bold">
                                <i class="ti ti-book me-1"></i>Nama Mata Pelajaran
                            </label>
                            <input type="text" class="form-control @error('nama_mapel') is-invalid @enderror"
                                id="edit_nama_mapel" name="nama_mapel" placeholder="Masukkan nama mata pelajaran..."
                                required>
                            @error('nama_mapel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Contoh: Matematika, Bahasa Indonesia, IPA, dll.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label fw-bold">
                                <i class="ti ti-file-text me-1"></i>Deskripsi <span class="text-muted">(Opsional)</span>
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="edit_deskripsi" name="deskripsi"
                                rows="3" placeholder="Masukkan deskripsi mata pelajaran..."></textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Deskripsi singkat tentang mata pelajaran ini.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-check me-1"></i>Update Mata Pelajaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <script>
        // URL base untuk mata pelajaran
        const mataPelajaranBaseUrl = "{{ route('matapelajaran.index') }}";

        // Delete confirmation function
        function deleteMataPelajaran(mataPelajaranId, mataPelajaranName) {
            if (confirm(
                    `Apakah Anda yakin ingin menghapus mata pelajaran "${mataPelajaranName}"?\n\nTindakan ini tidak dapat dibatalkan.`
                )) {
                document.getElementById('delete-form-' + mataPelajaranId).submit();
            }
        }

        // Edit mata pelajaran function
        function editMataPelajaran(id, nama, deskripsi) {
            // Set form action untuk update
            const actionUrl = `${mataPelajaranBaseUrl}/${id}`;
            document.getElementById('editMataPelajaranForm').action = actionUrl;

            // Debug: log URL yang akan digunakan
            console.log('Edit form action URL:', actionUrl);

            // Set value input nama mata pelajaran dan deskripsi
            document.getElementById('edit_nama_mapel').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi || '';

            // Clear any previous validation errors
            const namaElement = document.getElementById('edit_nama_mapel');
            const deskripsiElement = document.getElementById('edit_deskripsi');

            namaElement.classList.remove('is-invalid');
            deskripsiElement.classList.remove('is-invalid');

            // Remove any previous error messages
            const errorElements = document.querySelectorAll('#editMataPelajaranModal .invalid-feedback');
            errorElements.forEach(element => element.remove());
        }

        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });

            // Reset form saat modal ditutup
            const editModal = document.getElementById('editMataPelajaranModal');
            if (editModal) {
                editModal.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('editMataPelajaranForm');
                    form.reset();
                    form.action = '';

                    // Clear validation errors
                    const namaElement = document.getElementById('edit_nama_mapel');
                    const deskripsiElement = document.getElementById('edit_deskripsi');

                    namaElement.classList.remove('is-invalid');
                    deskripsiElement.classList.remove('is-invalid');

                    // Remove any error messages
                    const errorElements = document.querySelectorAll(
                        '#editMataPelajaranModal .invalid-feedback');
                    errorElements.forEach(element => element.remove());
                });
            }

            // Reset add modal form saat modal ditutup
            const addModal = document.getElementById('addMataPelajaranModal');
            if (addModal) {
                addModal.addEventListener('hidden.bs.modal', function() {
                    const form = addModal.querySelector('form');
                    form.reset();

                    // Clear validation errors
                    const inputs = form.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid');
                    });

                    // Remove any error messages
                    const errorElements = form.querySelectorAll('.invalid-feedback');
                    errorElements.forEach(element => element.remove());
                });
            }
        });
    </script>
    @include('layouts.components-backend.css')
@endsection
