@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Quiz Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $quiz->judul_quiz }}</h4>
                            <small class="text-light">{{ $quiz->deskripsi }}</small>
                        </div>
                        <div class="text-center">
                            <div class="timer-container">
                                <span id="timer" class="h5 mb-0">{{ $quiz->waktu_menit }}:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted">Progress Quiz</span>
                        <span class="small text-muted"><span id="answered-count">0</span>/{{ $quiz->soals->count() }} Soal</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progress-bar"></div>
                    </div>
                </div>
            </div>

            <!-- Quiz Form -->
            <form id="quiz-form" action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                @csrf
                
                @foreach($quiz->soals as $soal)
                <div class="card shadow-sm mb-4 question-card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                Pertanyaan {{ $loop->iteration }}
                            </h5>
                            <small class="text-muted">{{ $loop->iteration }}/{{ $quiz->soals->count() }}</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="question-text mb-4">
                            <strong class="h6">{{ $soal->pertanyaan }}</strong>
                        </div>
                        
                        <div class="options-container">
                            @php
                                $options = ['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d];
                            @endphp
                            
                            @foreach($options as $key => $option)
                            <div class="form-check option-item p-3 mb-2 border rounded">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="jawaban_{{ $soal->id }}" 
                                       id="option_{{ $soal->id }}_{{ $key }}"
                                       value="{{ $key }}" 
                                       {{ $loop->parent->first && $key == 'A' ? 'required' : '' }}
                                       onchange="updateProgress()">
                                <label class="form-check-label w-100 cursor-pointer" for="option_{{ $soal->id }}_{{ $key }}">
                                    <span class="option-letter badge bg-secondary me-2">{{ $key }}</span>
                                    {{ $option }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Submit Button -->
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-success btn-lg px-5" id="submit-btn">
                            <i class="fas fa-check-circle me-2"></i>
                            Selesai & Submit Quiz
                        </button>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Pastikan semua jawaban sudah terisi sebelum submit
                            </small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="start_time" id="start_time_input">
            </form>
        </div>
    </div>
</div>

<!-- Auto Submit Modal -->
<div class="modal fade" id="timeUpModal" tabindex="-1" aria-labelledby="timeUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="timeUpModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Waktu Habis!
                </h5>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-hourglass-end fa-3x text-warning mb-3"></i>
                <p class="h6">Waktu quiz telah habis.</p>
                <p>Quiz akan otomatis disubmit dalam <span id="countdown">5</span> detik.</p>
            </div>
        </div>
    </div>
</div>

<style>
.timer-container {
    background: rgba(255,255,255,0.1);
    padding: 8px 20px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.2);
}

.option-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.option-item:hover {
    background-color: #f8f9fa;
    border-color: #007bff !important;
}

.option-item input[type="radio"]:checked + label {
    color: #007bff;
    font-weight: 500;
}

.option-item:has(input[type="radio"]:checked) {
    background-color: #e3f2fd;
    border-color: #007bff !important;
}

.question-card {
    transition: all 0.3s ease;
}

.cursor-pointer {
    cursor: pointer;
}

.option-letter {
    min-width: 30px;
    display: inline-block;
    text-align: center;
}

#timer {
    font-family: 'Courier New', monospace;
    font-weight: bold;
}

.timer-warning {
    color: #ff6b6b !important;
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>

<script>
const startTime = Date.now(); // milidetik
document.getElementById('start_time_input').value = Math.floor(startTime / 1000); // DETIK!

document.addEventListener('DOMContentLoaded', function() {
    const userId = {{ auth()->user()->id }};
    const quizId = {{ $quiz->id }};
    const storageKey = `quiz_${quizId}_user_${userId}_progress`;
    const startTimeKey = `quiz_${quizId}_user_${userId}_start_time`;
    const totalMinutes = {{ $quiz->waktu_menit }};
    const form = document.getElementById('quiz-form');
    const timerElement = document.getElementById('timer');
    const totalQuestions = {{ $quiz->soals->count() }};
    let isSubmitting = false;

    // === TIMER HANDLING ===
    let startTime = localStorage.getItem(startTimeKey);
    const now = Date.now();

    if (!startTime) {
        startTime = now;
        localStorage.setItem(startTimeKey, startTime);
    } else {
        startTime = parseInt(startTime);
    }

    const quizDuration = totalMinutes * 60 * 1000;
    const timePassed = now - startTime;
    let timeLeft = Math.floor((quizDuration - timePassed) / 1000);

    if (timeLeft <= 0) {
        timeLeft = 0;
        showTimeUpModal();
    }

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 300) {
            timerElement.classList.add('timer-warning');
        }

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            showTimeUpModal();
        }

        timeLeft--;
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer();

    // === AUTO SUBMIT MODAL ===
    function showTimeUpModal() {
        const modal = new bootstrap.Modal(document.getElementById('timeUpModal'));
        modal.show();

        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                isSubmitting = true;
                localStorage.removeItem(storageKey);
                localStorage.removeItem(startTimeKey);
                form.submit();
            }
        }, 1000);
    }

    // === PROGRESS BAR ===
    function updateProgress() {
        const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
        const progressPercentage = (answeredQuestions / totalQuestions) * 100;

        document.getElementById('answered-count').textContent = answeredQuestions;
        document.getElementById('progress-bar').style.width = progressPercentage + '%';

        const submitBtn = document.getElementById('submit-btn');
        if (answeredQuestions === totalQuestions) {
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-primary');
            submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Semua Soal Terjawab - Submit Quiz';
        }
    }

    // === SAVE & LOAD PROGRESS ===
    function saveProgress() {
        const answers = {};
        document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
            const soalId = input.name.split('_')[1];
            answers[soalId] = input.value;
        });
        localStorage.setItem(storageKey, JSON.stringify(answers));
    }

    const savedAnswers = JSON.parse(localStorage.getItem(storageKey));
    if (savedAnswers) {
        Object.keys(savedAnswers).forEach(soalId => {
            const selectedOption = savedAnswers[soalId];
            const radio = document.querySelector(`input[name="jawaban_${soalId}"][value="${selectedOption}"]`);
            if (radio) {
                radio.checked = true;
            }
        });
        updateProgress();
    }

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', () => {
            updateProgress();
            saveProgress();
        });
    });

    // === FORM SUBMIT HANDLING ===
    form.addEventListener('submit', function(e) {
        const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;

        if (answeredQuestions < totalQuestions) {
            if (!confirm(`Anda baru menjawab ${answeredQuestions} dari ${totalQuestions} soal.\n\nYakin ingin submit?`)) {
                e.preventDefault();
                return;
            }
        } else {
            if (!confirm("Apakah Anda yakin ingin mengakhiri dan mengirimkan jawaban quiz ini?")) {
                e.preventDefault();
                return;
            }
        }

        isSubmitting = true;
        localStorage.removeItem(storageKey);
        localStorage.removeItem(startTimeKey);
    });
});

// === PREVENT RELOAD ACCIDENT ===
window.addEventListener('beforeunload', function(e) {
    if (!isSubmitting) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>


@endsection