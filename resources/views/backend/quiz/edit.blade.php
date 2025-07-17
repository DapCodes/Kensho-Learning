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
                                <label for="judul-quiz" class="form-label">Judul Quiz<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul_quiz') is-invalid @enderror"
                                    id="judul-quiz" name="judul_quiz" value="{{ old('judul_quiz', $quiz->judul_quiz) }}"
                                    required>
                                @error('judul_quiz')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="waktu-menit" class="form-label">Durasi (menit) <span
                                        class="text-danger">*</span></label>
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
                                <label for="categories" class="form-label">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('categories') is-invalid @enderror" id="categories"
                                    name="categories" required>
                                    <option value="" disabled selected>Pilih Kategori Quiz</option>
                                    @foreach ($categories as $items)
                                        <option value="{{ $items->id }}"
                                            {{ $items->id == $quiz->kategori_id ? 'selected' : '' }}>
                                            {{ $items->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('categories')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mapel" class="form-label">Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('mapel') is-invalid @enderror" id="mapel"
                                    name="mapel" required>
                                    <option value="" disabled selected>Pilih Mata Pelajaran Quiz</option>
                                    @foreach ($mataPelajaran as $items)
                                        <option value="{{ $items->id }}"
                                            {{ $items->id == $quiz->mata_pelajaran_id ? 'selected' : '' }}>
                                            {{ $items->nama_mapel }}</option>
                                    @endforeach
                                </select>
                                @error('mapel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="Privat"
                                        {{ old('status', $quiz->status) == 'Privat' ? 'selected' : '' }}>Privat</option>
                                    <option value="Umum" {{ old('status', $quiz->status) == 'Umum' ? 'selected' : '' }}>
                                        Umum</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="pengulangan" class="form-label">pengulangan <span class="text-danger">*</span></label>
                                <select class="form-select @error('pengulangan') is-invalid @enderror" id="pengulangan"
                                    name="pengulangan" required>
                                    <option value="" disabled>Pilih pengulangan</option>
                                    <option value="Boleh"
                                        {{ old('pengulangan_pekerjaan', $quiz->pengulangan_pekerjaan) == 'Boleh' ? 'selected' : '' }}>Boleh</option>
                                    <option value="Tidak" {{ old('pengulangan_pekerjaan', $quiz->pengulangan_pekerjaan) == 'Tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                                @error('pengulangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Quiz</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                rows="4" placeholder="Tambahkan keterangan atau instruksi untuk quiz...">{{ old('deskripsi', $quiz->deskripsi) }}</textarea>
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
                        @foreach ($quiz->soals as $index => $soal)
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
                                        <label for="question-{{ $index }}" class="form-label">Teks Soal <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('questions.' . $index . '.pertanyaan') is-invalid @enderror"
                                            id="question-{{ $index }}" name="questions[{{ $index }}][pertanyaan]" rows="3" required
                                            placeholder="Masukkan soal di sini...">{{ old('questions.' . $index . '.pertanyaan', $soal->pertanyaan) }}</textarea>
                                        @error('questions.' . $index . '.pertanyaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="question-type-{{ $index }}" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                                                <select class="form-select" id="question-type-{{ $index }}" name="questions[{{ $index }}][type]" required onchange="handleQuestionTypeChange({{ $index }})">
                                                    <option value="">Pilih Tipe Soal</option>
                                                    <option value="pilihan_ganda" {{ old('questions.' . $index . '.type', $soal->tipe ?? 'pilihan_ganda') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                                    <option value="essay" {{ old('questions.' . $index . '.type', $soal->tipe ?? '') == 'essay' ? 'selected' : '' }}>Essay</option>
                                                    <option value="benar_salah" {{ old('questions.' . $index . '.type', $soal->tipe ?? '') == 'benar_salah' ? 'selected' : '' }}>Benar/Salah</option>
                                                    <option value="checkbox" {{ old('questions.' . $index . '.type', $soal->tipe ?? '') == 'checkbox' ? 'selected' : '' }}>Checkbox (Multiple Answer)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="question-weight-{{ $index }}" class="form-label">Bobot Soal <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="question-weight-{{ $index }}" name="questions[{{ $index }}][weight]" min="1" max="100" value="{{ old('questions.' . $index . '.weight', $soal->bobot ?? 1) }}" required placeholder="1-100">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="question-options-{{ $index }}">
                                        <!-- Options will be populated by JavaScript -->
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
        let questionIndex = {{ count($quiz->soals) }};
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize existing questions
            @foreach ($quiz->soals as $index => $soal)
                handleQuestionTypeChange({{ $index }});
            @endforeach

            // Add new question
            document.getElementById('add-question').addEventListener('click', function() {
                addNewQuestion();
            });

            // Remove question
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-question') || e.target.closest('.remove-question')) {
                    const questionItem = e.target.closest('.question-item');
                    questionItem.remove();
                    updateQuestionNumbers();
                }
            });
        });

        function addNewQuestion() {
            const container = document.getElementById('questions-container');
            const questionCard = createQuestionCard(questionIndex);
            container.appendChild(questionCard);
            questionIndex++;
            updateQuestionNumbers();
        }

        function createQuestionCard(index) {
            const card = document.createElement('div');
            card.className = 'question-item card mb-4';
            card.setAttribute('data-question-index', index);
            
            card.innerHTML = `
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
                                <label for="question-type-${index}" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                                <select class="form-select" id="question-type-${index}" name="questions[${index}][type]" required onchange="handleQuestionTypeChange(${index})">
                                    <option value="">Pilih Tipe Soal</option>
                                    <option value="pilihan_ganda">Pilihan Ganda</option>
                                    <option value="essay">Essay</option>
                                    <option value="benar_salah">Benar/Salah</option>
                                    <option value="checkbox">Checkbox (Multiple Answer)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="question-weight-${index}" class="form-label">Bobot Soal <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="question-weight-${index}" name="questions[${index}][weight]" min="1" max="100" value="1" required placeholder="1-100">
                            </div>
                        </div>
                    </div>
                    
                    <div id="question-options-${index}">
                        <!-- Options will be populated by JavaScript -->
                    </div>
                </div>
            `;
            
            return card;
        }

        function updateQuestionNumbers() {
            const questions = document.querySelectorAll('.question-item');
            questions.forEach((question, index) => {
                const title = question.querySelector('.card-title');
                title.textContent = `Soal ${index + 1}`;
                question.setAttribute('data-question-index', index);
            });
        }

        function handleQuestionTypeChange(questionNumber) {
            const typeSelect = document.getElementById(`question-type-${questionNumber}`);
            const optionsContainer = document.getElementById(`question-options-${questionNumber}`);
            const selectedType = typeSelect.value;

            optionsContainer.innerHTML = '';

            switch (selectedType) {
                case 'pilihan_ganda':
                    optionsContainer.innerHTML = createMultipleChoiceOptions(questionNumber);
                    break;
                case 'essay':
                    optionsContainer.innerHTML = createEssayOptions(questionNumber);
                    break;
                case 'benar_salah':
                    optionsContainer.innerHTML = createTrueFalseOptions(questionNumber);
                    break;
                case 'checkbox':
                    optionsContainer.innerHTML = createCheckboxOptions(questionNumber);
                    break;
            }
        }

        function createMultipleChoiceOptions(questionNumber) {
            const existingData = getExistingQuestionData(questionNumber);
            
            return `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-a-${questionNumber}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-a-${questionNumber}" name="questions[${questionNumber}][pilihan_a]" value="${existingData.pilihan_a || ''}" required placeholder="Masukkan pilihan A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-b-${questionNumber}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-b-${questionNumber}" name="questions[${questionNumber}][pilihan_b]" value="${existingData.pilihan_b || ''}" required placeholder="Masukkan pilihan B">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-c-${questionNumber}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-c-${questionNumber}" name="questions[${questionNumber}][pilihan_c]" value="${existingData.pilihan_c || ''}" required placeholder="Masukkan pilihan C">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-d-${questionNumber}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-d-${questionNumber}" name="questions[${questionNumber}][pilihan_d]" value="${existingData.pilihan_d || ''}" required placeholder="Masukkan pilihan D">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][jawaban_benar]" id="correct-a-${questionNumber}" value="A" ${existingData.jawaban_benar === 'A' ? 'checked' : ''} required>
                            <label class="form-check-label" for="correct-a-${questionNumber}">A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][jawaban_benar]" id="correct-b-${questionNumber}" value="B" ${existingData.jawaban_benar === 'B' ? 'checked' : ''} required>
                            <label class="form-check-label" for="correct-b-${questionNumber}">B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][jawaban_benar]" id="correct-c-${questionNumber}" value="C" ${existingData.jawaban_benar === 'C' ? 'checked' : ''} required>
                            <label class="form-check-label" for="correct-c-${questionNumber}">C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][jawaban_benar]" id="correct-d-${questionNumber}" value="D" ${existingData.jawaban_benar === 'D' ? 'checked' : ''} required>
                            <label class="form-check-label" for="correct-d-${questionNumber}">D</label>
                        </div>
                    </div>
                </div>
            `;
        }

        function createEssayOptions(questionNumber) {
            const existingData = getExistingQuestionData(questionNumber);
            
            return `
                <div class="mb-3">
                    <label for="essay-answer-${questionNumber}" class="form-label">Jawaban Model (Opsional)</label>
                    <textarea class="form-control" id="essay-answer-${questionNumber}" name="questions[${questionNumber}][jawaban_benar]" rows="3" placeholder="Masukkan jawaban model untuk referensi penilaian (opsional)">${existingData.jawaban_benar || ''}</textarea>
                    <small class="form-text text-muted">Jawaban model ini akan digunakan sebagai referensi untuk penilaian manual.</small>
                </div>
            `;
        }

        function createTrueFalseOptions(questionNumber) {
            const existingData = getExistingQuestionData(questionNumber);
            
            return `
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][jawaban_benar]" id="correct-true-${questionNumber}" value="Benar" ${existingData.jawaban_benar === 'Benar' ? 'checked' : ''} required>
                            <label class="form-check-label" for="correct-true-${questionNumber}">Benar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][jawaban_benar]" id="correct-false-${questionNumber}" value="Salah" ${existingData.jawaban_benar === 'Salah' ? 'checked' : ''} required>
                            <label class="form-check-label" for="correct-false-${questionNumber}">Salah</label>
                        </div>
                    </div>
                </div>
            `;
        }

        function createCheckboxOptions(questionNumber) {
            const existingData = getExistingQuestionData(questionNumber);
            let checkboxOptionsHtml = '';
            
            // If there's existing checkbox data, use it; otherwise create 2 default options
            if (existingData.checkbox_options && existingData.checkbox_options.length > 0) {
                existingData.checkbox_options.forEach((option, index) => {
                    const isCorrect = existingData.checkbox_correct && existingData.checkbox_correct.includes(index.toString());
                    checkboxOptionsHtml += `
                        <div class="row mb-2">
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" value="${option}" placeholder="Masukkan opsi ${index + 1}" required>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="${index}" id="checkbox-correct-${questionNumber}-${index}" ${isCorrect ? 'checked' : ''}>
                                    <label class="form-check-label" for="checkbox-correct-${questionNumber}-${index}">Benar</label>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                // Create 2 default options for new questions
                for (let i = 0; i < 2; i++) {
                    checkboxOptionsHtml += `
                        <div class="row mb-2">
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi ${i + 1}" required>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="${i}" id="checkbox-correct-${questionNumber}-${i}">
                                    <label class="form-check-label" for="checkbox-correct-${questionNumber}-${i}">Benar</label>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }
            
            return `
                <div class="mb-3">
                    <label class="form-label">Opsi Pilihan <span class="text-danger">*</span></label>
                    <div id="checkbox-options-${questionNumber}">
                        ${checkboxOptionsHtml}
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCheckboxOption(${questionNumber})">
                        <i class="ti ti-plus me-1"></i>Tambah Opsi
                    </button>
                </div>
            `;
        }

        function addCheckboxOption(questionNumber) {
            const container = document.getElementById(`checkbox-options-${questionNumber}`);
            const optionCount = container.children.length;

            if (optionCount >= 10) {
                alert('Maksimal 10 opsi untuk setiap soal checkbox.');
                return;
            }

            const newOption = document.createElement('div');
            newOption.className = 'row mb-2';
            newOption.innerHTML = `
                <div class="col-md-10">
                    <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi ${optionCount + 1}" required>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="${optionCount}" id="checkbox-correct-${questionNumber}-${optionCount}">
                        <label class="form-check-label" for="checkbox-correct-${questionNumber}-${optionCount}">Benar</label>
                    </div>
                </div>
            `;

            container.appendChild(newOption);
        }


function getExistingQuestionData(questionNumber) {
    const existingQuestions = window.existingQuestions = @json($processedSoals);
    if (!existingQuestions || !existingQuestions[questionNumber]) {
        return {};        // fallback kosong
    }

    const question = existingQuestions[questionNumber];

    // ------ hanya untuk soal tipe checkbox ------
    const letters = 'abcdefghij'.split('');
    const checkbox_options = letters
        .map(l => question['pilihan_' + l])
        .filter(Boolean);                     // buang null / ''

    const checkbox_correct = (question.checkbox_correct ?? question.jawaban_benar ?? '')
        .toString()
        .split(',')
        .map(s => s.trim())
        .filter(Boolean);
    // --------------------------------------------

    // gabungkan semuanya
    return {
        ...question,            // pilihan_a, pilihan_b, … bobot, dll.
        checkbox_options,
        checkbox_correct
    };
}





        // Form validation (lanjutan dari kode yang terpotong)
        document.getElementById('quiz-edit-form').addEventListener('submit', function(e) {
            const questions = document.querySelectorAll('[name*="[pertanyaan]"]');
            let isValid = true;
            let errorMessage = '';

            questions.forEach((question, index) => {
                const questionNumber = index;
                const typeSelect = document.getElementById(`question-type-${questionNumber}`);
                const weightInput = document.getElementById(`question-weight-${questionNumber}`);

                if (!question.value.trim()) {
                    isValid = false;
                    errorMessage = `Harap isi teks untuk Soal ${questionNumber + 1}.`;
                    return;
                }

                if (!typeSelect.value) {
                    isValid = false;
                    errorMessage = `Harap pilih tipe soal untuk Soal ${questionNumber + 1}.`;
                    return;
                }

                if (!weightInput.value || weightInput.value < 1 || weightInput.value > 100) {
                    isValid = false;
                    errorMessage = `Bobot soal harus antara 1-100 untuk Soal ${questionNumber + 1}.`;
                    return;
                }

                // Validasi berdasarkan tipe soal
                const questionType = typeSelect.value;
                
                if (questionType === 'pilihan_ganda') {
                    const optionA = document.getElementById(`option-a-${questionNumber}`);
                    const optionB = document.getElementById(`option-b-${questionNumber}`);
                    const optionC = document.getElementById(`option-c-${questionNumber}`);
                    const optionD = document.getElementById(`option-d-${questionNumber}`);
                    const correctAnswer = document.querySelector(`input[name="questions[${questionNumber}][jawaban_benar]"]:checked`);

                    if (!optionA.value.trim() || !optionB.value.trim() || !optionC.value.trim() || !optionD.value.trim()) {
                        isValid = false;
                        errorMessage = `Semua pilihan (A, B, C, D) wajib diisi untuk Soal ${questionNumber + 1}.`;
                        return;
                    }

                    if (!correctAnswer) {
                        isValid = false;
                        errorMessage = `Pilih jawaban yang benar untuk Soal ${questionNumber + 1}.`;
                        return;
                    }
                } else if (questionType === 'benar_salah') {
                    const correctAnswer = document.querySelector(`input[name="questions[${questionNumber}][jawaban_benar]"]:checked`);
                    
                    if (!correctAnswer) {
                        isValid = false;
                        errorMessage = `Pilih jawaban yang benar untuk Soal ${questionNumber + 1}.`;
                        return;
                    }
                } else if (questionType === 'checkbox') {
                    const checkboxOptions = document.querySelectorAll(`input[name="questions[${questionNumber}][checkbox_options][]"]`);
                    const checkboxCorrect = document.querySelectorAll(`input[name="questions[${questionNumber}][checkbox_correct][]"]:checked`);

                    // Validasi minimal 2 opsi
                    let validOptions = 0;
                    checkboxOptions.forEach(option => {
                        if (option.value.trim()) {
                            validOptions++;
                        }
                    });

                    if (validOptions < 2) {
                        isValid = false;
                        errorMessage = `Minimal 2 opsi wajib diisi untuk Soal ${questionNumber + 1}.`;
                        return;
                    }

                    // Validasi minimal 1 jawaban benar
                    if (checkboxCorrect.length < 1) {
                        isValid = false;
                        errorMessage = `Minimal 1 jawaban benar wajib dipilih untuk Soal ${questionNumber + 1}.`;
                        return;
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
                return false;
            }

            // Validasi form quiz dasar
            const quizTitle = document.getElementById('judul-quiz');
            const duration = document.getElementById('waktu-menit');
            const categories = document.getElementById('categories');
            const mapel = document.getElementById('mapel');
            const status = document.getElementById('status');

            if (!quizTitle.value.trim()) {
                e.preventDefault();
                alert('Judul quiz wajib diisi.');
                quizTitle.focus();
                return false;
            }

            if (!duration.value || duration.value < 1 || duration.value > 300) {
                e.preventDefault();
                alert('Durasi quiz harus antara 1-300 menit.');
                duration.focus();
                return false;
            }

            if (!categories.value) {
                e.preventDefault();
                alert('Kategori quiz wajib dipilih.');
                categories.focus();
                return false;
            }

            if (!mapel.value) {
                e.preventDefault();
                alert('Mata pelajaran quiz wajib dipilih.');
                mapel.focus();
                return false;
            }

            if (!status.value) {
                e.preventDefault();
                alert('Status quiz wajib dipilih.');
                status.focus();
                return false;
            }

            // Validasi jumlah soal
            if (questions.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 soal.');
                return false;
            }

            return true;
        });

        // Helper function untuk menghapus opsi checkbox
        function removeCheckboxOption(questionNumber, optionIndex) {
            const container = document.getElementById(`checkbox-options-${questionNumber}`);
            const options = container.children;
            
            if (options.length > 2) {
                options[optionIndex].remove();
                updateCheckboxIndexes(questionNumber);
            } else {
                alert('Minimal 2 opsi harus tersedia.');
            }
        }

        // Update checkbox indexes setelah menghapus opsi
        function updateCheckboxIndexes(questionNumber) {
            const container = document.getElementById(`checkbox-options-${questionNumber}`);
            const options = container.children;
            
            Array.from(options).forEach((option, index) => {
                const input = option.querySelector('input[type="text"]');
                const checkbox = option.querySelector('input[type="checkbox"]');
                const label = option.querySelector('label');
                
                if (input) {
                    input.placeholder = `Masukkan opsi ${index + 1}`;
                }
                
                if (checkbox) {
                    checkbox.value = index;
                    checkbox.id = `checkbox-correct-${questionNumber}-${index}`;
                }
                
                if (label) {
                    label.setAttribute('for', `checkbox-correct-${questionNumber}-${index}`);
                }
            });
        }

        // Tambahkan button hapus untuk setiap opsi checkbox yang sudah ada
        function addRemoveButtonToCheckboxOptions(questionNumber) {
            const container = document.getElementById(`checkbox-options-${questionNumber}`);
            const options = container.children;
            
            Array.from(options).forEach((option, index) => {
                if (!option.querySelector('.remove-checkbox-option')) {
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-outline-danger btn-sm remove-checkbox-option';
                    removeBtn.innerHTML = '<i class="ti ti-trash"></i>';
                    removeBtn.onclick = () => removeCheckboxOption(questionNumber, index);
                    
                    const col = option.querySelector('.col-md-2');
                    if (col && options.length > 2) {
                        col.appendChild(removeBtn);
                    }
                }
            });
        }

        // Update fungsi createCheckboxOptions untuk menambahkan button hapus
        function updateCreateCheckboxOptions(questionNumber) {
            setTimeout(() => {
                addRemoveButtonToCheckboxOptions(questionNumber);
            }, 100);
        }

        // Auto-save draft (opsional)
        function saveDraft() {
            const formData = new FormData(document.getElementById('quiz-edit-form'));
            const draftData = {};
            
            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }
            
            // Simpan ke localStorage sebagai draft
            localStorage.setItem(`quiz_draft_${window.location.pathname}`, JSON.stringify(draftData));
        }

        // Load draft (opsional)
        function loadDraft() {
            const draftData = localStorage.getItem(`quiz_draft_${window.location.pathname}`);
            if (draftData) {
                const data = JSON.parse(draftData);
                // Implementasi load draft sesuai kebutuhan
                console.log('Draft loaded:', data);
            }
        }

        // Periodic auto-save setiap 30 detik
        setInterval(saveDraft, 30000);

        // Konfirmasi sebelum meninggalkan halaman jika ada perubahan
        let formChanged = false;
        document.getElementById('quiz-edit-form').addEventListener('change', function() {
            formChanged = true;
        });

        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Reset form changed flag setelah submit
        document.getElementById('quiz-edit-form').addEventListener('submit', function() {
            formChanged = false;
        });

        // Tambahkan fitur preview soal
        function previewQuestion(questionNumber) {
            const question = document.getElementById(`question-${questionNumber}`).value;
            const type = document.getElementById(`question-type-${questionNumber}`).value;
            const weight = document.getElementById(`question-weight-${questionNumber}`).value;
            
            let previewContent = `
                <div class="modal fade" id="preview-modal-${questionNumber}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Preview Soal ${questionNumber + 1}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <strong>Tipe:</strong> ${type.replace('_', ' ').toUpperCase()}
                                </div>
                                <div class="mb-3">
                                    <strong>Bobot:</strong> ${weight} poin
                                </div>
                                <div class="mb-3">
                                    <strong>Soal:</strong><br>
                                    ${question}
                                </div>
            `;
            
            if (type === 'pilihan_ganda') {
                const optionA = document.getElementById(`option-a-${questionNumber}`).value;
                const optionB = document.getElementById(`option-b-${questionNumber}`).value;
                const optionC = document.getElementById(`option-c-${questionNumber}`).value;
                const optionD = document.getElementById(`option-d-${questionNumber}`).value;
                
                previewContent += `
                    <div class="mb-3">
                        <strong>Pilihan:</strong><br>
                        A. ${optionA}<br>
                        B. ${optionB}<br>
                        C. ${optionC}<br>
                        D. ${optionD}
                    </div>
                `;
            } else if (type === 'benar_salah') {
                previewContent += `
                    <div class="mb-3">
                        <strong>Pilihan:</strong><br>
                        • Benar<br>
                        • Salah
                    </div>
                `;
            } else if (type === 'checkbox') {
                const checkboxOptions = document.querySelectorAll(`input[name="questions[${questionNumber}][checkbox_options][]"]`);
                previewContent += `<div class="mb-3"><strong>Pilihan:</strong><br>`;
                checkboxOptions.forEach((option, index) => {
                    if (option.value.trim()) {
                        previewContent += `☐ ${option.value}<br>`;
                    }
                });
                previewContent += `</div>`;
            }
            
            previewContent += `
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById(`preview-modal-${questionNumber}`);
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add new modal
            document.body.insertAdjacentHTML('beforeend', previewContent);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById(`preview-modal-${questionNumber}`));
            modal.show();
        }

        // Tambahkan tombol preview ke setiap soal
        function addPreviewButton(questionNumber) {
            const cardHeader = document.querySelector(`[data-question-index="${questionNumber}"] .card-header`);
            if (cardHeader && !cardHeader.querySelector('.preview-question')) {
                const previewBtn = document.createElement('button');
                previewBtn.type = 'button';
                previewBtn.className = 'btn btn-outline-info btn-sm me-2 preview-question';
                previewBtn.innerHTML = '<i class="ti ti-eye me-1"></i>Preview';
                previewBtn.onclick = () => previewQuestion(questionNumber);
                
                const removeBtn = cardHeader.querySelector('.remove-question');
                if (removeBtn) {
                    cardHeader.insertBefore(previewBtn, removeBtn);
                }
            }
        }

        // Tambahkan preview button untuk semua soal yang sudah ada
        document.querySelectorAll('.question-item').forEach((item, index) => {
            addPreviewButton(index);
        });
    </script>
@endsection