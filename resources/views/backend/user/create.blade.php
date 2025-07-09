@extends('layouts.backend')
@section('content')
<div class="container-fluid">
    <!-- Enhanced Header Section -->
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Buat data user sekarang!!</h3>
                    <p class="text-white-75 mb-3">Buat data user dengan mengisi beberapa form di bawah.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="">
                                    <i class="ti ti-home me-1"></i>Kelola
                                </a>
                            </li>
                            <li class="breadcrumb-item text-white-75" aria-current="page">User</li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Tambah</li>
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

    <!-- Simple Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-user-plus me-2 text-primary"></i>
                        Form Tambah User
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">
                                <i class="ti ti-user me-1"></i>Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">
                                <i class="ti ti-mail me-1"></i>Email
                            </label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" 
                                   placeholder="Contoh: user@email.com" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Row untuk Kelas dan Role -->
                        <div class="row">
                            <!-- Kelas -->
                            <div class="col-md-6 mb-3">
                                <label for="kelas_id" class="form-label fw-medium">
                                    <i class="ti ti-school me-1"></i>Kelas
                                </label>
                                <select name="kelas_id" id="kelas_id"
                                        class="form-select @error('kelas_id') is-invalid @enderror" 
                                        required>
                                    <option value="" disabled selected>Pilih Kelas...</option>
                                    @foreach ($kelass as $kelas)
                                        <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="isAdmin" class="form-label fw-medium">
                                    <i class="ti ti-shield me-1"></i>Role
                                </label>
                                <select name="isAdmin" id="isAdmin"
                                        class="form-select @error('isAdmin') is-invalid @enderror" 
                                        required>
                                    <option value="" disabled selected>Pilih Role...</option>
                                    <option value="1" {{ old('isAdmin') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="0" {{ old('isAdmin') == '0' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('isAdmin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row untuk Password -->
                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-medium">
                                    <i class="ti ti-lock me-1"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Minimal 8 karakter" 
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="ti ti-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-medium">
                                    <i class="ti ti-lock-check me-1"></i>Konfirmasi Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control"
                                           placeholder="Ulangi password" 
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="ti ti-eye" id="eyeIconConfirm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ti ti-user-plus me-1"></i>Tambah User
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-light px-4">
                                <i class="ti ti-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Password Toggle -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('ti-eye');
            eyeIcon.classList.toggle('ti-eye-off');
        });
    }

    // Toggle Password Confirmation
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');

    if (togglePasswordConfirm) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            eyeIconConfirm.classList.toggle('ti-eye');
            eyeIconConfirm.classList.toggle('ti-eye-off');
        });
    }

    // Password match validation
    if (passwordConfirmInput) {
        passwordConfirmInput.addEventListener('keyup', function() {
            if (passwordInput.value !== passwordConfirmInput.value) {
                passwordConfirmInput.setCustomValidity('Password tidak cocok');
            } else {
                passwordConfirmInput.setCustomValidity('');
            }
        });
    }
});
</script>

@include('layouts.components-backend.css')
@endsection