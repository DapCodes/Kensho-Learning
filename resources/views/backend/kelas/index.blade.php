@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Semua Kelas Anda!!</h3>
                        <p class="text-white-75 mb-3">Kelola dan pantau semua kelas Anda dengan mudah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Kelas</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="kelas-dashboard"
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

        <!-- Enhanced Action Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-school text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Daftar Kelas Anda</h5>
                                <p class="text-muted mb-0">
                                    @if ($kelas->count() > 0)
                                        Menampilkan {{ $kelas->count() }} kelas dari total koleksi Anda
                                    @else
                                        Belum ada kelas yang dibuat - mulai dengan membuat kelas pertama!
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#addKelasModal">
                            <i class="ti ti-plus me-2"></i>Buat Kelas Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Kelas Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-table me-2 text-primary"></i>Tabel Kelas
                    </h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                            {{ $kelas->count() }} Kelas
                        </span>
                    </div>
                </div>
            </div>

            @if ($kelas->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover kelas-table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-hash me-1"></i>No
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-school me-1"></i>Nama Kelas
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-certificate me-1"></i>Jurusan
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-calendar me-1"></i>Tanggal Dibuat
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center pe-4">
                                        <i class="ti ti-settings me-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $index => $item)
                                    <tr class="kelas-row" data-kelas-id="{{ $item->id }}">
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
                                                    <i class="ti ti-school text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark" title="{{ $item->nama_kelas }}">
                                                        {{ $item->nama_kelas }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="ti ti-certificate text-info"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark" title="{{ $item->jurusan }}">
                                                        {{ $item->jurusan }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <small class="text-muted">
                                                <i
                                                    class="ti ti-calendar me-1"></i>{{ $item->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </td>
                                        <td class="py-4 text-center pe-4">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-warning btn-sm" title="Edit Kelas"
                                                    data-bs-toggle="modal" data-bs-target="#editKelasModal"
                                                    onclick="editKelas({{ $item->id }}, '{{ addslashes($item->nama_kelas) }}', '{{ addslashes($item->jurusan) }}')">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus Kelas"
                                                    onclick="deleteKelas({{ $item->id }}, '{{ addslashes($item->nama_kelas) }}')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Hidden delete form -->
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('kelas.destroy', $item->id) }}" method="POST"
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
                            <i class="ti ti-school text-primary" style="font-size: 48px;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Belum Ada Kelas</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        Mulai dengan membuat kelas pertama untuk mengorganisir siswa Anda dengan lebih baik!
                    </p>
                    <button class="btn btn-primary btn-lg px-5" data-bs-toggle="modal" data-bs-target="#addKelasModal">
                        <i class="ti ti-plus me-2"></i>Buat Kelas Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Kelas Modal -->
    <div class="modal fade" id="addKelasModal" tabindex="-1" aria-labelledby="addKelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addKelasModalLabel">
                        <i class="ti ti-plus me-2"></i>Tambah Kelas Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label fw-bold">
                                <i class="ti ti-school me-1"></i>Nama Kelas
                            </label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                                id="nama_kelas" name="nama_kelas" placeholder="Masukkan nama kelas..."
                                value="{{ old('nama_kelas') }}" autofocus required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Contoh: X-1, XI IPA 1, XII IPS 2, dll.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jurusan" class="form-label fw-bold">
                                <i class="ti ti-certificate me-1"></i>Jurusan
                            </label>
                            <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan"
                                name="jurusan" required>
                                <option value="">Pilih Jurusan...</option>
                                <option value="IPA" {{ old('jurusan') == 'IPA' ? 'selected' : '' }}>IPA (Ilmu
                                    Pengetahuan Alam)</option>
                                <option value="IPS" {{ old('jurusan') == 'IPS' ? 'selected' : '' }}>IPS (Ilmu
                                    Pengetahuan Sosial)</option>
                                <option value="Bahasa" {{ old('jurusan') == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                                <option value="Teknik Informatika"
                                    {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika
                                </option>
                                <option value="Akuntansi" {{ old('jurusan') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi
                                </option>
                                <option value="Pemasaran" {{ old('jurusan') == 'Pemasaran' ? 'selected' : '' }}>Pemasaran
                                </option>
                                <option value="Administrasi Perkantoran"
                                    {{ old('jurusan') == 'Administrasi Perkantoran' ? 'selected' : '' }}>Administrasi
                                    Perkantoran</option>
                                <option value="Lainnya" {{ old('jurusan') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Pilih jurusan yang sesuai dengan kelas.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Simpan Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Kelas Modal -->
    <div class="modal fade" id="editKelasModal" tabindex="-1" aria-labelledby="editKelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editKelasModalLabel">
                        <i class="ti ti-edit me-2"></i>Edit Kelas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editKelasForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_kelas" class="form-label fw-bold">
                                <i class="ti ti-school me-1"></i>Nama Kelas
                            </label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                                id="edit_nama_kelas" name="nama_kelas" placeholder="Masukkan nama kelas..." required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Contoh: X-1, XI IPA 1, XII IPS 2, dll.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_jurusan" class="form-label fw-bold">
                                <i class="ti ti-certificate me-1"></i>Jurusan
                            </label>
                            <select class="form-select @error('jurusan') is-invalid @enderror" id="edit_jurusan"
                                name="jurusan" required>
                                <option value="">Pilih Jurusan...</option>
                                <option value="IPA">IPA (Ilmu Pengetahuan Alam)</option>
                                <option value="IPS">IPS (Ilmu Pengetahuan Sosial)</option>
                                <option value="Bahasa">Bahasa</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Akuntansi">Akuntansi</option>
                                <option value="Pemasaran">Pemasaran</option>
                                <option value="Administrasi Perkantoran">Administrasi Perkantoran</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="ti ti-info-circle me-1"></i>Pilih jurusan yang sesuai dengan kelas.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-check me-1"></i>Update Kelas
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
        // URL base untuk kelas
        const kelasBaseUrl = "{{ route('kelas.index') }}";

        // Delete confirmation function
        function deleteKelas(kelasId, kelasName) {
            if (confirm(
                    `Apakah Anda yakin ingin menghapus kelas "${kelasName}"?\n\nTindakan ini tidak dapat dibatalkan.`
                )) {
                document.getElementById('delete-form-' + kelasId).submit();
            }
        }

        // Edit kelas function
        function editKelas(id, namaKelas, jurusan) {
            // Set form action untuk update
            const actionUrl = `${kelasBaseUrl}/${id}`;
            document.getElementById('editKelasForm').action = actionUrl;

            // Debug: log URL yang akan digunakan
            console.log('Edit form action URL:', actionUrl);

            // Set value input nama kelas dan jurusan
            document.getElementById('edit_nama_kelas').value = namaKelas;
            document.getElementById('edit_jurusan').value = jurusan;

            // Clear any previous validation errors
            const namaElement = document.getElementById('edit_nama_kelas');
            const jurusanElement = document.getElementById('edit_jurusan');

            namaElement.classList.remove('is-invalid');
            jurusanElement.classList.remove('is-invalid');

            // Remove any previous error messages
            const errorElements = document.querySelectorAll('#editKelasModal .invalid-feedback');
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
            const editModal = document.getElementById('editKelasModal');
            if (editModal) {
                editModal.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('editKelasForm');
                    form.reset();
                    form.action = '';

                    // Clear validation errors
                    const namaElement = document.getElementById('edit_nama_kelas');
                    const jurusanElement = document.getElementById('edit_jurusan');

                    namaElement.classList.remove('is-invalid');
                    jurusanElement.classList.remove('is-invalid');

                    // Remove any error messages
                    const errorElements = document.querySelectorAll('#editKelasModal .invalid-feedback');
                    errorElements.forEach(element => element.remove());
                });
            }

            // Reset add modal form saat modal ditutup
            const addModal = document.getElementById('addKelasModal');
            if (addModal) {
                addModal.addEventListener('hidden.bs.modal', function() {
                    const form = addModal.querySelector('form');
                    form.reset();

                    // Clear validation errors
                    const inputs = form.querySelectorAll('.form-control, .form-select');
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
