@extends('layouts.backend')
@section('content')
@include('layouts.components-backend.css')
<div class="container-fluid">
    
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5 border-0">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Edit Quiz</h3>
                    <p class="text-white-75 mb-3">Perbarui dan kelola quiz anda dengan mudah</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="">
                                    <i class="ti ti-home me-1"></i>Kelola
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white-75" aria-current="page">Quiz</li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
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

    <!-- Quiz Edit Form -->
    <form id="quiz-edit-form" action="{{ route('quiz.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Quiz Basic Information -->
        <div class="card border-0 mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Quiz</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul-quiz" class="form-label">Judul Quiz<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul_quiz') is-invalid @enderror" 
                                   id="judul-quiz" name="judul_quiz" 
                                   value="{{ old('judul_quiz', $quiz->judul_quiz) }}" required>
                            @error('judul_quiz')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="waktu-menit" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('waktu_menit') is-invalid @enderror" 
                                   id="waktu-menit" name="waktu_menit" min="1" max="300" 
                                   value="{{ old('waktu_menit', $quiz->waktu_menit) }}" required>
                            @error('waktu_menit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="categories" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('categories') is-invalid @enderror" id="categories" name="categories" required>
                                <option value="" disabled selected>Pilih Kategori Quiz</option>
                                @foreach ($categories as $items)
                                    <option value="{{ $items->id }}" {{ $items->id == $quiz->kategori_id ? 'selected' : '' }}>{{ $items->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mapel" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('mapel') is-invalid @enderror" id="mapel" name="mapel" required>
                                <option value="" disabled selected>Pilih Mata Pelajaran Quiz</option>
                                @foreach ($mataPelajaran as $items)
                                    <option value="{{ $items->id }}" {{ $items->id == $quiz->mata_pelajaran_id ? 'selected' : '' }}>{{ $items->nama_mapel }}</option>
                                @endforeach
                            </select>
                            @error('mapel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="" disabled>Pilih Status</option>
                                <option value="Privat" {{ old('status', $quiz->status) == 'Privat' ? 'selected' : '' }}>Privat</option>
                                <option value="Umum" {{ old('status', $quiz->status) == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Quiz</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  name="deskripsi" id="deskripsi" rows="4" 
                                  placeholder="Tambahkan keterangan atau instruksi untuk quiz...">{{ old('deskripsi', $quiz->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Soal Quiz</h5>
                <button type="button" class="btn btn-primary btn-sm" id="add-question">
                    <i class="ti ti-plus me-1"></i>Tambah Soal
                </button>
            </div>
            <div class="card-body">
                <div id="questions-container">
                    @foreach($quiz->soals as $index => $soal)
                        <div class="question-item card mb-4" data-question-index="{{ $index }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">Soal {{ $index + 1 }}</h6>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-question">
                                    <i class="ti ti-trash me-1"></i>Hapus
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- Hidden field for existing question ID -->
                                <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $soal->id }}">
                                
                                <div class="mb-3">
                                    <label for="question-{{ $index }}" class="form-label">Teks Soal <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('questions.' . $index . '.pertanyaan') is-invalid @enderror" 
                                              id="question-{{ $index }}" name="questions[{{ $index }}][pertanyaan]" 
                                              rows="3" required placeholder="Masukkan soal di sini...">{{ old('questions.' . $index . '.pertanyaan', $soal->pertanyaan) }}</textarea>
                                    @error('questions.' . $index . '.pertanyaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="option-a-{{ $index }}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('questions.' . $index . '.pilihan_a') is-invalid @enderror" 
                                                   id="option-a-{{ $index }}" name="questions[{{ $index }}][pilihan_a]" 
                                                   value="{{ old('questions.' . $index . '.pilihan_a', $soal->pilihan_a) }}" 
                                                   required placeholder="Masukkan pilihan A">
                                            @error('questions.' . $index . '.pilihan_a')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="option-b-{{ $index }}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('questions.' . $index . '.pilihan_b') is-invalid @enderror" 
                                                   id="option-b-{{ $index }}" name="questions[{{ $index }}][pilihan_b]" 
                                                   value="{{ old('questions.' . $index . '.pilihan_b', $soal->pilihan_b) }}" 
                                                   required placeholder="Masukkan pilihan B">
                                            @error('questions.' . $index . '.pilihan_b')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="option-c-{{ $index }}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('questions.' . $index . '.pilihan_c') is-invalid @enderror" 
                                                   id="option-c-{{ $index }}" name="questions[{{ $index }}][pilihan_c]" 
                                                   value="{{ old('questions.' . $index . '.pilihan_c', $soal->pilihan_c) }}" 
                                                   required placeholder="Masukkan pilihan C">
                                            @error('questions.' . $index . '.pilihan_c')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="option-d-{{ $index }}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('questions.' . $index . '.pilihan_d') is-invalid @enderror" 
                                                   id="option-d-{{ $index }}" name="questions[{{ $index }}][pilihan_d]" 
                                                   value="{{ old('questions.' . $index . '.pilihan_d', $soal->pilihan_d) }}" 
                                                   required placeholder="Masukkan pilihan D">
                                            @error('questions.' . $index . '.pilihan_d')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="questions[{{ $index }}][jawaban_benar]" 
                                                   id="correct-a-{{ $index }}" value="A" 
                                                   {{ old('questions.' . $index . '.jawaban_benar', $soal->jawaban_benar) == 'A' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="correct-a-{{ $index }}">A</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="questions[{{ $index }}][jawaban_benar]" 
                                                   id="correct-b-{{ $index }}" value="B" 
                                                   {{ old('questions.' . $index . '.jawaban_benar', $soal->jawaban_benar) == 'B' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="correct-b-{{ $index }}">B</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="questions[{{ $index }}][jawaban_benar]" 
                                                   id="correct-c-{{ $index }}" value="C" 
                                                   {{ old('questions.' . $index . '.jawaban_benar', $soal->jawaban_benar) == 'C' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="correct-c-{{ $index }}">C</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="questions[{{ $index }}][jawaban_benar]" 
                                                   id="correct-d-{{ $index }}" value="D" 
                                                   {{ old('questions.' . $index . '.jawaban_benar', $soal->jawaban_benar) == 'D' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="correct-d-{{ $index }}">D</label>
                                        </div>
                                    </div>
                                    @error('questions.' . $index . '.jawaban_benar')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionIndex = {{ count($quiz->soals) }};
    
    // Add new question
    document.getElementById('add-question').addEventListener('click', function() {
        const questionsContainer = document.getElementById('questions-container');
        const newQuestion = createQuestionForm(questionIndex);
        questionsContainer.appendChild(newQuestion);
        questionIndex++;
        updateQuestionNumbers();
    });
    
    // Remove question functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-question') || e.target.closest('.remove-question')) {
            const questionItem = e.target.closest('.question-item');
            const questionsContainer = document.getElementById('questions-container');
            
            // Don't allow removing if it's the last question
            if (questionsContainer.children.length <= 1) {
                alert('Quiz harus memiliki minimal satu soal.');
                return;
            }
            
            if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                questionItem.remove();
                updateQuestionNumbers();
            }
        }
    });
    
    // Create new question form
    function createQuestionForm(index) {
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item card mb-4';
        questionDiv.setAttribute('data-question-index', index);
        
        questionDiv.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Soal ${index + 1}</h6>
                <button type="button" class="btn btn-outline-danger btn-sm remove-question">
                    <i class="ti ti-trash me-1"></i>Hapus
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="question-${index}" class="form-label">Teks Soal <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="question-${index}" name="questions[${index}][pertanyaan]" rows="3" required placeholder="Masukkan soal di sini..."></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-a-${index}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-a-${index}" name="questions[${index}][pilihan_a]" required placeholder="Masukkan pilihan A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-b-${index}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-b-${index}" name="questions[${index}][pilihan_b]" required placeholder="Masukkan pilihan B">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-c-${index}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-c-${index}" name="questions[${index}][pilihan_c]" required placeholder="Masukkan pilihan C">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-d-${index}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-d-${index}" name="questions[${index}][pilihan_d]" required placeholder="Masukkan pilihan D">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${index}][jawaban_benar]" id="correct-a-${index}" value="A" required>
                            <label class="form-check-label" for="correct-a-${index}">A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${index}][jawaban_benar]" id="correct-b-${index}" value="B" required>
                            <label class="form-check-label" for="correct-b-${index}">B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${index}][jawaban_benar]" id="correct-c-${index}" value="C" required>
                            <label class="form-check-label" for="correct-c-${index}">C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${index}][jawaban_benar]" id="correct-d-${index}" value="D" required>
                            <label class="form-check-label" for="correct-d-${index}">D</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        return questionDiv;
    }
    
    // Update question numbers after add/remove
    function updateQuestionNumbers() {
        const questionItems = document.querySelectorAll('.question-item');
        questionItems.forEach((item, index) => {
            const titleElement = item.querySelector('.card-title');
            titleElement.textContent = `Soal ${index + 1}`;
            item.setAttribute('data-question-index', index);
        });
    }
    
    // Form validation before submission
    document.getElementById('quiz-edit-form').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('[name*="[pertanyaan]"]');
        const options = document.querySelectorAll('[name*="[pilihan_"]');
        const correctAnswers = document.querySelectorAll('[name*="[jawaban_benar]"]:checked');
        
        let isValid = true;
        let errorMessage = '';
        
        // Check if there's at least one question
        if (questions.length === 0) {
            isValid = false;
            errorMessage = 'Quiz harus memiliki minimal satu soal.';
        }
        
        // Check if all questions have text
        if (isValid) {
            questions.forEach((question, index) => {
                if (!question.value.trim()) {
                    isValid = false;
                    errorMessage = `Harap isi teks untuk Soal ${index + 1}.`;
                    return;
                }
            });
        }
        
        // Check if all options are filled
        if (isValid) {
            options.forEach((option, index) => {
                if (!option.value.trim()) {
                    isValid = false;
                    const questionNum = Math.floor(index / 4) + 1;
                    const optionLetter = String.fromCharCode(65 + (index % 4));
                    errorMessage = `Harap isi Pilihan ${optionLetter} untuk Soal ${questionNum}.`;
                    return;
                }
            });
        }
        
        // Check if all questions have correct answers selected
        if (isValid && correctAnswers.length !== questions.length) {
            isValid = false;
            errorMessage = 'Harap pilih jawaban benar untuk semua soal.';
        }
        
        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
            return false;
        }
    });
});
</script>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
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

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
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

.question-item {
    transition: all 0.3s ease;
}

.question-item:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endsection