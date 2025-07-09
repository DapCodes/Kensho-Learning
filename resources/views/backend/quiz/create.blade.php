@extends('layouts.backend')
@section('content')
@include('layouts.components-backend.css')
<div class="container-fluid">
    
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5 border-0">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Buat Quiz baru??</h3>
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
                            <label for="quiz-title" class="form-label">Judul Quiz<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('quiz_title') is-invalid @enderror" id="quiz-title" name="quiz_title" value="{{ old('quiz_title') }}" required>
                            @error('quiz_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="num-questions" class="form-label">Banyak Soal<span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('num_questions') is-invalid @enderror" id="num-questions" name="num_questions" min="1" max="50" value="{{ old('num_questions') }}" required>
                            @error('num_questions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" min="1" max="300" value="{{ old('duration') }}" required>
                            @error('duration')
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
                                    <option value="{{ $items->id }}">{{ $items->nama_kategori }}</option>
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
                                    <option value="{{ $items->id }}">{{ $items->nama_mapel }}</option>
                                @endforeach
                            </select>
                            @error('mataPelajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label for="visibility" class="form-label">Status Visibilitas <span class="text-danger">*</span></label>
                            <select class="form-select @error('visibility') is-invalid @enderror" id="visibility" name="visibility" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Privat">Privat</option>
                                <option value="Umum">Umum</option>
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
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="quiz-description" rows="4" placeholder="Tambahkan keterangan atau instruksi untuk quiz...">{{ old('description') }}</textarea>
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
                <input type="hidden" name="mapel" id="hidden-mapel">

                <!-- Dynamic Questions Container -->
                <div id="questions-list"></div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="ti ti-check me-2"></i>Simpan Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const setupForm = document.getElementById('quiz-setup-form');
    const setupCard = document.getElementById('quiz-setup-card');
    const questionsContainer = document.getElementById('questions-container');
    const questionsList = document.getElementById('questions-list');
    const backButton = document.getElementById('back-to-setup');
    
    // Handle quiz setup form submission
    setupForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = document.getElementById('quiz-title').value;
        const numQuestions = parseInt(document.getElementById('num-questions').value);
        const duration = document.getElementById('duration').value;
        const description = document.getElementById('quiz-description').value;
        const visibility = document.getElementById('visibility').value;
        const categories = document.getElementById('categories').value;
        const mapel = document.getElementById('mapel').value;
        
        if (!title || !numQuestions || !duration || !visibility || !categories || !mapel) {
            alert('Harap isi semua field yang wajib diisi.');
            return;
        }
        
        if (numQuestions < 1 || numQuestions > 50) {
            alert('Jumlah soal harus antara 1 sampai 50.');
            return;
        }
        
        // Get category name from selected option
        const categorySelect = document.getElementById('categories');
        const selectedCategoryName = categorySelect.options[categorySelect.selectedIndex].text;
        
        // Get mata pelajaran name from selected option
        const mapelSelect = document.getElementById('mapel');
        const selectedMapelName = mapelSelect.options[mapelSelect.selectedIndex].text;
        
        // Update display information
        document.getElementById('display-title').textContent = title;
        document.getElementById('display-questions').textContent = numQuestions;
        document.getElementById('display-duration').textContent = duration;
        document.getElementById('display-description').textContent = description || 'Tidak ada deskripsi';
        document.getElementById('display-visibility').textContent = visibility;
        document.getElementById('display-categories').textContent = selectedCategoryName;
        document.getElementById('display-mapel').textContent = selectedMapelName;
        
        // Update hidden fields
        document.getElementById('hidden-title').value = title;
        document.getElementById('hidden-questions').value = numQuestions;
        document.getElementById('hidden-duration').value = duration;
        document.getElementById('hidden-description').value = description;
        document.getElementById('hidden-visibility').value = visibility;
        document.getElementById('hidden-categories').value = categories;
        document.getElementById('hidden-mapel').value = mapel;
        
        // Generate question forms
        generateQuestionForms(numQuestions);
        
        // Show questions container and hide setup
        setupCard.style.display = 'none';
        questionsContainer.style.display = 'block';
        
        // Scroll to top
        window.scrollTo(0, 0);
    });
    
    // Handle back to setup button
    backButton.addEventListener('click', function() {
        setupCard.style.display = 'block';
        questionsContainer.style.display = 'none';
        window.scrollTo(0, 0);
    });
    
    // Generate question forms dynamically
    function generateQuestionForms(numQuestions) {
        questionsList.innerHTML = '';
        
        for (let i = 1; i <= numQuestions; i++) {
            const questionCard = createQuestionForm(i);
            questionsList.appendChild(questionCard);
        }
    }
    
    // Create individual question form
    function createQuestionForm(questionNumber) {
        const card = document.createElement('div');
        card.className = 'card mb-4';
        card.innerHTML = `
            <div class="card-header">
                <h6 class="card-title mb-0">Soal ${questionNumber}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="question-${questionNumber}" class="form-label">Teks Soal <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="question-${questionNumber}" name="questions[${questionNumber}][text]" rows="3" required placeholder="Masukkan soal di sini..."></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-a-${questionNumber}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-a-${questionNumber}" name="questions[${questionNumber}][option_a]" required placeholder="Masukkan pilihan A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-b-${questionNumber}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-b-${questionNumber}" name="questions[${questionNumber}][option_b]" required placeholder="Masukkan pilihan B">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-c-${questionNumber}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-c-${questionNumber}" name="questions[${questionNumber}][option_c]" required placeholder="Masukkan pilihan C">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-d-${questionNumber}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-d-${questionNumber}" name="questions[${questionNumber}][option_d]" required placeholder="Masukkan pilihan D">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-a-${questionNumber}" value="A" required>
                            <label class="form-check-label" for="correct-a-${questionNumber}">A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-b-${questionNumber}" value="B" required>
                            <label class="form-check-label" for="correct-b-${questionNumber}">B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-c-${questionNumber}" value="C" required>
                            <label class="form-check-label" for="correct-c-${questionNumber}">C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-d-${questionNumber}" value="D" required>
                            <label class="form-check-label" for="correct-d-${questionNumber}">D</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        return card;
    }
    
    // Form validation before submission
    document.getElementById('final-quiz-form').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('[name*="[text]"]');
        const options = document.querySelectorAll('[name*="[option_"]');
        const correctAnswers = document.querySelectorAll('[name*="[correct_answer]"]:checked');
        
        let isValid = true;
        let errorMessage = '';
        
        // Check if all questions have text
        questions.forEach((question, index) => {
            if (!question.value.trim()) {
                isValid = false;
                errorMessage = `Harap isi teks untuk Soal ${index + 1}.`;
                return;
            }
        });
        
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