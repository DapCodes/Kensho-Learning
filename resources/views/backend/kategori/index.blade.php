@extends('layouts.backend')
@section('content')
<div class="container-fluid">
    <!-- Enhanced Header Section -->
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Semua kategori Anda!!</h3>
                    <p class="text-white-75 mb-3">Kelola dan pantau semua kategori Anda dengan mudah</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="">
                                    <i class="ti ti-home me-1"></i>Kelola
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">kategori</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <img src="{{asset('assets/backend/images/breadcrumb/ChatBc.png')}}" 
                             alt="kategori-dashboard" 
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

    <!-- Enhanced Action Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="ti ti-list text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">Daftar kategori Anda</h5>
                            <p class="text-muted mb-0">
                                @if($kategori->count() > 0)
                                    Menampilkan {{ $kategori->count() }} kategori dari total koleksi Anda
                                @else
                                    Belum ada kategori yang dibuat - mulai dengan membuat kategori pertama!
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="ti ti-plus me-2"></i>Buat kategori Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced kategori Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="ti ti-table me-2 text-primary"></i>Tabel kategori
                </h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                        {{ $kategori->count() }} kategori
                    </span>
                </div>
            </div>
        </div>
        
        @if($kategori->count() > 0)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover kategori-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                    <i class="ti ti-hash me-1"></i>No
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                    <i class="ti ti-tag me-1"></i>Nama Kategori
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center pe-4">
                                    <i class="ti ti-settings me-1"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori as $index => $item)
                                <tr class="kategori-row" data-kategori-id="{{ $item->id }}">
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
                                            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="ti ti-tag text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark" title="{{ $item->nama_kategori }}">
                                                    {{ $item->nama_kategori }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="ti ti-calendar me-1"></i>{{ $item->created_at->format('d M Y, H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-warning btn-sm" 
                                                    title="Edit kategori"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editCategoryModal"
                                                    onclick="editCategory({{ $item->id }}, '{{ $item->nama_kategori }}')">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Hapus kategori"
                                                    onclick="deleteKategori({{ $item->id }}, '{{ $item->nama_kategori }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Hidden delete form -->
                                        <form id="delete-form-{{ $item->id }}" 
                                              action="{{ route('kategori.destroy', $item->id) }}" 
                                              method="POST" 
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
                        <i class="ti ti-tag text-primary" style="font-size: 48px;"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-3">Belum Ada kategori</h3>
                <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                    Mulai dengan membuat kategori pertama untuk mengorganisir konten Anda dengan lebih baik!
                </p>
                <button class="btn btn-primary btn-lg px-5" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="ti ti-plus me-2"></i>Buat kategori Pertama
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="ti ti-plus me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label fw-bold">
                            <i class="ti ti-tag me-1"></i>Nama Kategori
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" 
                               name="nama_kategori" 
                               placeholder="Masukkan nama kategori..."
                               value="{{ old('nama_kategori') }}" 
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ti ti-info-circle me-1"></i>Contoh: Teknologi, Olahraga, Pendidikan, dll.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editCategoryModalLabel">
                    <i class="ti ti-edit me-2"></i>Edit Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_kategori" class="form-label fw-bold">
                            <i class="ti ti-tag me-1"></i>Nama Kategori
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="edit_nama_kategori" 
                               name="nama_kategori" 
                               placeholder="Masukkan nama kategori..."
                               required>
                        <div class="form-text">
                            <i class="ti ti-info-circle me-1"></i>Contoh: Teknologi, Olahraga, Pendidikan, dll.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-check me-1"></i>Update Kategori
                    </button>
                </div>
            </form>
        </div>
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
    // Delete confirmation function
    function deleteKategori(kategoriId, kategoriName) {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${kategoriName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            document.getElementById('delete-form-' + kategoriId).submit();
        }
    }

    // Edit category function
    function editCategory(id, nama) {
        document.getElementById('editCategoryForm').action = `/kategori/${id}`;
        document.getElementById('edit_nama_kategori').value = nama;
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
    });
</script>
@include('layouts.components-backend.css')
@endsection