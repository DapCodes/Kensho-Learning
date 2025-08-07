@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">

        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5 border-0">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Buat Quiz baru</h3>
                        <p class="text-white-75 mb-3">Buat dan kelola quiz anda dengan mudah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white-75" aria-current="page">Quiz</li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Buat</li>
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

        <!-- Quiz Setup Form -->
        <div class="card border-0" id="quiz-setup-card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pengaturan Quiz</h5>
            </div>
            <div class="card-body">
                <form id="quiz-setup-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quiz-title" class="form-label">Judul Quiz<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('quiz_title') is-invalid @enderror"
                                    id="quiz-title" name="quiz_title" value="{{ old('quiz_title') }}" required>
                                @error('quiz_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="num-questions" class="form-label">Banyak Soal<span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('num_questions') is-invalid @enderror"
                                    id="num-questions" name="num_questions" min="1" max="50"
                                    value="{{ old('num_questions') }}" required>
                                @error('num_questions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Durasi (menit) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                    id="duration" name="duration" min="1" max="300"
                                    value="{{ old('duration') }}" required>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mapel" class="form-label">Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('mapel') is-invalid @enderror" id="mapel"
                                    name="mapel" required>
                                    <option value="" disabled selected>Pilih Mata Pelajaran Quiz</option>
                                    @foreach ($mataPelajaran as $items)
                                        <option value="{{ $items->id }}"
                                            {{ old('mapel') == $items->id ? 'selected' : '' }}>
                                            {{ $items->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mapel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categories" class="form-label">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('categories') is-invalid @enderror" id="categories"
                                    name="categories" required>
                                    <option value="" disabled selected>Pilih Kategori Quiz</option>
                                    @foreach ($categories as $items)
                                        <option value="{{ $items->id }}"
                                            {{ old('categories') == $items->id ? 'selected' : '' }}>
                                            {{ $items->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categories')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pengulangan" class="form-label">Pengulangan Pekerjaan<span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('pengulangan') is-invalid @enderror" id="pengulangan"
                                    name="pengulangan" required>
                                    <option value="" disabled selected>Boleh / Tidak</option>
                                    <option value="Boleh">Boleh</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                                @error('pengulangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="aktivasi" class="form-label">Status Aktivasi <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('aktivasi') is-invalid @enderror" id="aktivasi"
                                    name="aktivasi" required>
                                    <option value="" disabled selected>Aktif / Nonaktif</option>
                                    <option value="aktif" {{ old('aktivasi') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="non aktif" {{ old('aktivasi') == 'non aktif' ? 'selected' : '' }}>Non
                                        Aktif</option>
                                </select>
                                @error('aktivasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="visibility" class="form-label">Status Visibilitas <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('visibility') is-invalid @enderror" id="visibility"
                                    name="visibility" required>
                                    <option value="" disabled selected>Umum / Privat</option>
                                    <option value="Privat" {{ old('visibility') == 'Privat' ? 'selected' : '' }}>Privat
                                    </option>
                                    <option value="Umum" {{ old('visibility') == 'Umum' ? 'selected' : '' }}>Umum
                                    </option>
                                </select>
                                @error('visibility')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="quiz-description" class="form-label">Deskripsi Quiz</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="quiz-description"
                                rows="4" placeholder="Tambahkan keterangan atau instruksi untuk quiz...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i>Buat Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Questions Form Container (Initially Hidden) -->
        <div class="card" id="questions-container" style="display: none;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Soal Quiz</h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="back-to-setup">
                    <i class="ti ti-arrow-left me-1"></i>Kembali ke Pengaturan
                </button>
            </div>
            <div class="card-body">
                <!-- Quiz Info Display -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h6 class="mb-2">Informasi Quiz:</h6>
                            <p class="mb-1"><strong>Judul:</strong> <span id="display-title"></span></p>
                            <p class="mb-1"><strong>Jumlah Soal:</strong> <span id="display-questions"></span></p>
                            <p class="mb-1"><strong>Durasi:</strong> <span id="display-duration"></span> menit</p>
                            <p class="mb-1"><strong>Status:</strong> <span id="display-visibility"></span></p>
                            <p class="mb-1"><strong>Kategori:</strong> <span id="display-categories"></span></p>
                            <p class="mb-1"><strong>Status Aktivasi:</strong> <span id="display-aktivasi"></span></p>
                            <p class="mb-1"><strong>Pengulangan Pekerjaan:</strong> <span
                                    id="display-pengulangan"></span></p>
                            <p class="mb-1"><strong>Mata Pelajaran:</strong> <span id="display-mapel"></span></p>
                            <p class="mb-0"><strong>Deskripsi:</strong> <span id="display-description"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Final Quiz Form -->
                <form id="final-quiz-form" action="{{ route('quiz.store') }}" method="POST">
                    @csrf
                    <!-- Hidden fields for quiz info -->
                    <input type="hidden" name="quiz_title" id="hidden-title">
                    <input type="hidden" name="num_questions" id="hidden-questions">
                    <input type="hidden" name="duration" id="hidden-duration">
                    <input type="hidden" name="description" id="hidden-description">
                    <input type="hidden" name="visibility" id="hidden-visibility">
                    <input type="hidden" name="categories" id="hidden-categories">
                    <input type="hidden" name="aktivasi" id="hidden-aktivasi">
                    <input type="hidden" name="mapel" id="hidden-mapel">
                    <input type="hidden" name="pengulangan" id="hidden-pengulangan">

                    <!-- Dynamic Questions Container -->
                    <div id="questions-list"></div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4 gap-1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="ti ti-check me-2"></i>Simpan Quiz
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" id="add-question">
                            <i class="ti ti-plus me-1"></i>Tambah Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('/assets/backend/js/main/quiz/script-quiz-create.js')}}"></script>

    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #b8daff;
            color: #0c5460;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
    </style>
@endsection
