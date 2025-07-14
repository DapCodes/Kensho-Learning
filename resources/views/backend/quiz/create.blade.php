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

                const title = document.getElementById('quiz-title').value.trim();
                const numQuestions = parseInt(document.getElementById('num-questions').value);
                const duration = document.getElementById('duration').value;
                const description = document.getElementById('quiz-description').value.trim();
                const visibility = document.getElementById('visibility').value;
                const categories = document.getElementById('categories').value;
                const mapel = document.getElementById('mapel').value;
                const aktivasi = document.getElementById('aktivasi').value;
                const pengulangan = document.getElementById('pengulangan').value; // Tambahkan ini

                // Validation
                if (!title || !numQuestions || !duration || !visibility || !categories || !mapel || !
                    aktivasi || !pengulangan) {
                    alert('Harap isi semua field yang wajib diisi.');
                    return;
                }

                if (numQuestions < 1 || numQuestions > 50) {
                    alert('Jumlah soal harus antara 1 sampai 50.');
                    return;
                }

                if (parseInt(duration) < 1 || parseInt(duration) > 300) {
                    alert('Durasi harus antara 1 sampai 300 menit.');
                    return;
                }

                // Get option text from selected values
                const categorySelect = document.getElementById('categories');
                const selectedCategoryName = categorySelect.options[categorySelect.selectedIndex].text;

                const aktivasiSelect = document.getElementById('aktivasi');
                const selectedAktivasiName = aktivasiSelect.options[aktivasiSelect.selectedIndex].text;

                const mapelSelect = document.getElementById('mapel');
                const selectedMapelName = mapelSelect.options[mapelSelect.selectedIndex].text;

                const pengulanganSelect = document.getElementById('pengulangan');
                const selectedPengulanganName = pengulanganSelect.options[pengulanganSelect.selectedIndex]
                    .text;

                // Update display information
                document.getElementById('display-title').textContent = title;
                document.getElementById('display-questions').textContent = numQuestions;
                document.getElementById('display-duration').textContent = duration;
                document.getElementById('display-description').textContent = description ||
                    'Tidak ada deskripsi';
                document.getElementById('display-visibility').textContent = visibility;
                document.getElementById('display-categories').textContent = selectedCategoryName;
                document.getElementById('display-mapel').textContent = selectedMapelName;
                document.getElementById('display-aktivasi').textContent = selectedAktivasiName;
                document.getElementById('display-pengulangan').textContent =
                    selectedPengulanganName; // Tambahkan ini

                // Update hidden fields
                document.getElementById('hidden-title').value = title;
                document.getElementById('hidden-questions').value = numQuestions;
                document.getElementById('hidden-duration').value = duration;
                document.getElementById('hidden-description').value = description;
                document.getElementById('hidden-visibility').value = visibility;
                document.getElementById('hidden-aktivasi').value = aktivasi;
                document.getElementById('hidden-categories').value = categories;
                document.getElementById('hidden-mapel').value = mapel;
                document.getElementById('hidden-pengulangan').value = pengulangan; // Tambahkan ini

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
                            <label for="question-type-${questionNumber}" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                            <select class="form-select" id="question-type-${questionNumber}" name="questions[${questionNumber}][type]" required onchange="handleQuestionTypeChange(${questionNumber})">
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
                            <label for="question-weight-${questionNumber}" class="form-label">Bobot Soal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="question-weight-${questionNumber}" name="questions[${questionNumber}][weight]" min="1" max="100" required placeholder="1-100">
                        </div>
                    </div>
                </div>
                
                <div id="question-options-${questionNumber}">
                    <!-- Dynamic options will be inserted here -->
                </div>
            </div>
        `;

                return card;
            }

            // Handle question type change
            window.handleQuestionTypeChange = function(questionNumber) {
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
            };

            // Create multiple choice options
            function createMultipleChoiceOptions(questionNumber) {
                return `
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
        `;
            }

            // Create essay options
            function createEssayOptions(questionNumber) {
                return `
            <div class="mb-3">
                <label for="essay-answer-${questionNumber}" class="form-label">Jawaban Model (Opsional)</label>
                <textarea class="form-control" id="essay-answer-${questionNumber}" name="questions[${questionNumber}][correct_answer]" rows="3" placeholder="Masukkan jawaban model untuk referensi penilaian (opsional)"></textarea>
                <small class="form-text text-muted">Jawaban model ini akan digunakan sebagai referensi untuk penilaian manual.</small>
            </div>
        `;
            }

            // Create true/false options
            function createTrueFalseOptions(questionNumber) {
                return `
            <div class="mb-3">
                <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-true-${questionNumber}" value="Benar" required>
                        <label class="form-check-label" for="correct-true-${questionNumber}">Benar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-false-${questionNumber}" value="Salah" required>
                        <label class="form-check-label" for="correct-false-${questionNumber}">Salah</label>
                    </div>
                </div>
            </div>
        `;
            }




            // Modifikasi fungsi createCheckboxOptions untuk membuat struktur yang konsisten
            function createCheckboxOptions(questionNumber) {
                return `
        <div class="mb-3">
            <label class="form-label">Opsi Pilihan <span class="text-danger">*</span></label>
            <div id="checkbox-options-${questionNumber}">
                <div class="row mb-2">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi 1" required>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="0" id="checkbox-correct-${questionNumber}-0">
                            <label class="form-check-label" for="checkbox-correct-${questionNumber}-0">Benar</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="questions[${questionNumber}][checkbox_options][]" placeholder="Masukkan opsi 2" required>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="questions[${questionNumber}][checkbox_correct][]" value="1" id="checkbox-correct-${questionNumber}-1">
                            <label class="form-check-label" for="checkbox-correct-${questionNumber}-1">Benar</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCheckboxOption(${questionNumber})">
                <i class="ti ti-plus me-1"></i>Tambah Opsi
            </button>
        </div>
    `;
            }




            // Perbaikan fungsi addCheckboxOption - pastikan value checkbox sesuai dengan index yang benar
            window.addCheckboxOption = function(questionNumber) {
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
            };





            // Form validation before submission
            document.getElementById('final-quiz-form').addEventListener('submit', function(e) {
                const questions = document.querySelectorAll('[name*="[text]"]');
                let isValid = true;
                let errorMessage = '';

                // Validate each question
                questions.forEach((question, index) => {
                    const questionNumber = index + 1;
                    const typeSelect = document.getElementById(`question-type-${questionNumber}`);
                    const weightInput = document.getElementById(
                        `question-weight-${questionNumber}`);

                    if (!question.value.trim()) {
                        isValid = false;
                        errorMessage = `Harap isi teks untuk Soal ${questionNumber}.`;
                        return;
                    }

                    if (!typeSelect.value) {
                        isValid = false;
                        errorMessage = `Harap pilih tipe soal untuk Soal ${questionNumber}.`;
                        return;
                    }

                    if (!weightInput.value || weightInput.value < 1 || weightInput.value > 100) {
                        isValid = false;
                        errorMessage = `Harap isi bobot soal (1-100) untuk Soal ${questionNumber}.`;
                        return;
                    }

                    // Validate based on question type
                    const questionType = typeSelect.value;

                    if (questionType === 'pilihan_ganda') {
                        const options = [
                            document.getElementById(`option-a-${questionNumber}`),
                            document.getElementById(`option-b-${questionNumber}`),
                            document.getElementById(`option-c-${questionNumber}`),
                            document.getElementById(`option-d-${questionNumber}`)
                        ];

                        options.forEach((option, optIndex) => {
                            if (!option.value.trim()) {
                                isValid = false;
                                errorMessage =
                                    `Harap isi Pilihan ${String.fromCharCode(65 + optIndex)} untuk Soal ${questionNumber}.`;
                                return;
                            }
                        });

                        const correctAnswer = document.querySelector(
                            `input[name="questions[${questionNumber}][correct_answer]"]:checked`
                        );
                        if (!correctAnswer) {
                            isValid = false;
                            errorMessage =
                                `Harap pilih jawaban benar untuk Soal ${questionNumber}.`;
                            return;
                        }
                    } else if (questionType === 'checkbox') {
                        const checkboxOptions = document.querySelectorAll(
                            `input[name="questions[${questionNumber}][checkbox_options][]"]`);
                        const correctAnswers = document.querySelectorAll(
                            `input[name="questions[${questionNumber}][checkbox_correct][]"]:checked`
                        );

                        // Validasi bahwa minimal ada 2 opsi
                        if (checkboxOptions.length < 2) {
                            isValid = false;
                            errorMessage = `Soal ${questionNumber} harus memiliki minimal 2 opsi.`;
                            return;
                        }

                        // Validasi bahwa semua opsi yang ada harus terisi
                        let hasEmptyOption = false;
                        checkboxOptions.forEach((option, index) => {
                            if (!option.value.trim()) {
                                hasEmptyOption = true;
                            }
                        });

                        if (hasEmptyOption) {
                            isValid = false;
                            errorMessage = `Harap isi semua opsi untuk Soal ${questionNumber}.`;
                            return;
                        }

                        // Validasi bahwa minimal 1 jawaban benar dipilih
                        if (correctAnswers.length === 0) {
                            isValid = false;
                            errorMessage =
                                `Harap pilih minimal 1 jawaban benar untuk Soal ${questionNumber}.`;
                            return;
                        }

                        // Debug: tampilkan berapa opsi yang akan dikirim
                        console.log(
                            `Soal ${questionNumber}: ${checkboxOptions.length} opsi akan dikirim`
                        );
                        console.log(`Jawaban benar: ${correctAnswers.length} dipilih`);
                    }

                    const allQuestions = document.querySelectorAll('[name*="[text]"]');
                    allQuestions.forEach((question, index) => {
                        const questionNumber = index + 1;
                        const typeSelect = document.getElementById(
                            `question-type-${questionNumber}`);

                        if (typeSelect && typeSelect.value === 'checkbox') {
                            debugCheckboxData(questionNumber);
                        }
                    });

                    if (isValid) {
                        console.log('Form akan disubmit dengan semua data checkbox');
                    }


                });

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }
            });

            function debugCheckboxData(questionNumber) {
                const checkboxOptions = document.querySelectorAll(
                    `input[name="questions[${questionNumber}][checkbox_options][]"]`);
                const correctAnswers = document.querySelectorAll(
                    `input[name="questions[${questionNumber}][checkbox_correct][]"]:checked`);

                console.log(`=== DEBUG Soal ${questionNumber} ===`);
                console.log(`Total opsi: ${checkboxOptions.length}`);

                checkboxOptions.forEach((option, index) => {
                    console.log(`Opsi ${index}: "${option.value}"`);
                });

                console.log(
                    `Jawaban benar (index): [${Array.from(correctAnswers).map(cb => cb.value).join(', ')}]`);
                console.log(`=====================================`);
            }
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
