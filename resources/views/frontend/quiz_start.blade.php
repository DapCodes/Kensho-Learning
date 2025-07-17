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
                            <span class="small text-muted">
                                <span id="answered-count">0</span>/{{ $quiz->soals->count() }} Soal
                            </span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progress-bar">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quiz Form -->
                <form id="quiz-form" action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                    @csrf
                    @foreach ($quiz->soals as $soal)
                        <div class="card shadow-sm mb-4 question-card">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-primary">
                                        <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                        Pertanyaan {{ $loop->iteration }}
                                        <small
                                            class="text-muted">({{ ucwords(str_replace('_', ' ', $soal->tipe)) }})</small>
                                    </h5>
                                    <div class="text-end">
                                        <small class="text-muted">{{ $loop->iteration }}/{{ $quiz->soals->count() }}</small>
                                        <br>
                                        <small class="text-primary"><strong>Bobot: {{ $soal->bobot }}</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="question-text mb-4">
                                    <strong class="h6">{{ $soal->pertanyaan }}</strong>
                                </div>

                                <div class="options-container">
                                    @if ($soal->tipe === 'pilihan_ganda')
                                        @php
                                            $options = [
                                                'A' => $soal->pilihan_a,
                                                'B' => $soal->pilihan_b,
                                                'C' => $soal->pilihan_c,
                                                'D' => $soal->pilihan_d,
                                            ];
                                        @endphp
                                        @foreach ($options as $key => $option)
                                            @if ($option)
                                                <label class="form-check option-item p-3 mb-2 border rounded w-100 cursor-pointer" for="option_{{ $soal->id }}_{{ $key }}">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="jawaban_{{ $soal->id }}"
                                                        id="option_{{ $soal->id }}_{{ $key }}"
                                                        value="{{ $key }}" onchange="updateProgress()">
                                                    <span class="option-letter badge bg-secondary me-2">{{ $key }}</span>
                                                    {{ $option }}
                                                </label>
                                            @endif
                                        @endforeach
                                    @elseif($soal->tipe === 'benar_salah')
                                        <label class="form-check option-item p-3 mb-2 border rounded w-100 cursor-pointer" for="option_{{ $soal->id }}_benar">
                                            <input class="form-check-input me-2" type="radio"
                                                name="jawaban_{{ $soal->id }}" id="option_{{ $soal->id }}_benar"
                                                value="Benar" onchange="updateProgress()">
                                            <span class="option-letter badge bg-success me-2">✓</span>
                                            Benar
                                        </label>

                                        <label class="form-check option-item p-3 mb-2 border rounded w-100 cursor-pointer" for="option_{{ $soal->id }}_salah">
                                            <input class="form-check-input me-2" type="radio"
                                                name="jawaban_{{ $soal->id }}" id="option_{{ $soal->id }}_salah"
                                                value="Salah" onchange="updateProgress()">
                                            <span class="option-letter badge bg-danger me-2">✗</span>
                                            Salah
                                        </label>

                                    @elseif($soal->tipe === 'checkbox')
                                        @php
                                            $checkboxOptions = [
                                                '0' => $soal->pilihan_a,
                                                '1' => $soal->pilihan_b,
                                                '2' => $soal->pilihan_c,
                                                '3' => $soal->pilihan_d,
                                                '4' => $soal->pilihan_e,
                                                '5' => $soal->pilihan_f,
                                                '6' => $soal->pilihan_g,
                                                '7' => $soal->pilihan_h,
                                                '8' => $soal->pilihan_i,
                                                '9' => $soal->pilihan_j,
                                            ];
                                        @endphp

                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Pilih satu atau lebih jawaban yang benar
                                            </small>
                                        </div>

                                        @foreach ($checkboxOptions as $key => $option)
                                            @if ($option)
                                                <label class="form-check option-item p-3 mb-2 border rounded w-100 cursor-pointer" for="checkbox_{{ $soal->id }}_{{ $key }}">
                                                    <input class="form-check-input me-2" type="checkbox"
                                                        name="jawaban_{{ $soal->id }}[]"
                                                        id="checkbox_{{ $soal->id }}_{{ $key }}"
                                                        value="{{ $key }}" onchange="updateProgress()">
                                                    <span class="option-letter badge bg-secondary me-2">{{ $key }}</span>
                                                    {{ $option }}
                                                </label>
                                            @endif
                                        @endforeach

                                    @elseif($soal->tipe === 'essay')
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-edit me-1"></i>
                                                Tulis jawaban Anda dengan jelas dan lengkap
                                            </small>
                                        </div>
                                        <textarea class="form-control" name="jawaban_{{ $soal->id }}" id="essay_{{ $soal->id }}" rows="6"
                                            placeholder="Tulis jawaban Anda di sini..." onchange="updateProgress()" oninput="updateProgress()"></textarea>
                                    @endif

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
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 20px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .option-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .option-item:hover {
            background-color: #f8f9fa;
            border-color: #007bff !important;
        }

        .option-item input[type="radio"]:checked+label,
        .option-item input[type="checkbox"]:checked+label {
            color: #007bff;
            font-weight: 500;
        }

        .option-item:has(input[type="radio"]:checked),
        .option-item:has(input[type="checkbox"]:checked) {
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
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
    </style>

    <script>
    
    
// Anti-cheating tab switch detection
let tabSwitchCount = 0;
let isWarningActive = false;
let isDisabled = false;
let isFrozen = false;
let freezeInterval = null;
let soundInterval = null;

// Create audio element for alert sound
const alertSound = new Audio('/assets/backend/sounds/alert.mp3');
alertSound.preload = 'auto';
alertSound.volume = 1.0; // Set volume to 100%
alertSound.loop = true; // Loop the sound during freeze

// Track visibility changes (tab switches)
document.addEventListener('visibilitychange', function() {
    if (document.hidden && !isDisabled && !isFrozen) {
        tabSwitchCount++;
        //Debug
        console.log(tabSwitchCount);
        console.log(`Tab switch detected. Count: ${tabSwitchCount}`);
        
        // Show warning after 5 tab switches
        if (tabSwitchCount === 5) {
            showCheatWarning();
        }
        
        // Play sound alert after 8 tab switches
        if (tabSwitchCount === 8) {
            playAlertSound();
        }
        
        // Freeze system for 1 minute after 10 tab switches
        if (tabSwitchCount === 10) {
            freezeSystem();
        }
        
        // Disable interactions after 12 tab switches
        if (tabSwitchCount > 12) {
            disableInteractions();
        }
    }
});

// Show serious warning modal
function showCheatWarning() {
    if (isWarningActive) return;
    
    isWarningActive = true;
    
    // Create warning modal
    const warningModal = document.createElement('div');
    warningModal.id = 'cheat-warning-modal';
    warningModal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    `;
    
    const warningContent = document.createElement('div');
    warningContent.style.cssText = `
        background: white;
        padding: 30px;
        border-radius: 10px;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    `;
    
    warningContent.innerHTML = `
        <div style="color: #dc3545; font-size: 48px; margin-bottom: 20px;">
            ⚠️
        </div>
        <h3 style="color: #dc3545; margin-bottom: 20px;">PERINGATAN SERIUS!</h3>
        <p style="margin-bottom: 20px; font-size: 16px; line-height: 1.5;">
            Sistem telah mendeteksi aktivitas yang mencurigakan.<br>
            Anda telah berganti tab <strong>${tabSwitchCount} kali</strong>.<br><br>
            <strong>Peringatan:</strong> Jika Anda terus melakukan tindakan ini, 
            ujian akan dihentikan secara otomatis dan jawaban Anda akan dikunci.
        </p>
        <button id="understand-btn" style="
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        ">Saya Mengerti</button>
    `;
    
    warningModal.appendChild(warningContent);
    document.body.appendChild(warningModal);
    
    // Handle understand button click
    document.getElementById('understand-btn').addEventListener('click', function() {
        document.body.removeChild(warningModal);
        isWarningActive = false;
    });
}

// Play alert sound
function playAlertSound() {
    alertSound.volume = 1.0; // Force volume to 100%
    alertSound.play().catch(function(error) {
        console.log('Could not play alert sound:', error);
    });
    
    // Prevent volume changes
    alertSound.addEventListener('volumechange', function() {
        if (alertSound.volume !== 1.0) {
            alertSound.volume = 1.0;
        }
    });
}

// Freeze system for 1 minute with continuous alarm
function freezeSystem() {
    if (isFrozen) return;
    
    isFrozen = true;
    let remainingTime = 60; // 1 minute in seconds
    
    // Start continuous alarm
    alertSound.volume = 1.0;
    alertSound.loop = true;
    alertSound.play().catch(function(error) {
        console.log('Could not play freeze alarm:', error);
    });
    
    // Prevent volume changes during freeze
    const volumeHandler = function() {
        if (alertSound.volume !== 1.0) {
            alertSound.volume = 1.0;
        }
    };
    alertSound.addEventListener('volumechange', volumeHandler);
    
    // Create freeze overlay
    const freezeOverlay = document.createElement('div');
    freezeOverlay.id = 'freeze-overlay';
    freezeOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 0, 0, 0.3);
        z-index: 9999;
        pointer-events: all;
    `;
    
    // Create freeze warning
    const freezeWarning = document.createElement('div');
    freezeWarning.id = 'freeze-warning';
    freezeWarning.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #dc3545;
        color: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        z-index: 10000;
        max-width: 500px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: pulse 1s infinite;
    `;
    
    freezeWarning.innerHTML = `
        <div style="font-size: 72px; margin-bottom: 20px;">🔒</div>
        <h2 style="margin-bottom: 20px;">SISTEM DIBEKUKAN!</h2>
        <p style="margin-bottom: 30px; font-size: 18px; line-height: 1.5;">
            Anda telah melanggar aturan dengan berganti tab <strong>${tabSwitchCount} kali</strong>.<br>
            Sistem akan dibekukan selama <strong>1 menit</strong> sebagai sanksi.
        </p>
        <div style="font-size: 48px; margin-bottom: 10px; color: #ffeb3b;">
            <span id="freeze-countdown">${remainingTime}</span>
        </div>
        <div style="font-size: 16px; opacity: 0.9;">
            detik tersisa
        </div>
        <div style="font-size: 12px; margin-top: 20px; opacity: 0.8;">
            Alarm akan terus berbunyi selama pembekuan
        </div>
    `;
    
    document.body.appendChild(freezeOverlay);
    document.body.appendChild(freezeWarning);
    
    // Disable all form inputs during freeze
    const inputs = document.querySelectorAll('input, textarea, button, select');
    inputs.forEach(input => { 
        input.disabled = true;
        input.style.opacity = '0.3';
    });
    
    // Prevent all interactions during freeze
    document.addEventListener('contextmenu', preventEvent);
    document.addEventListener('keydown', preventEvent);
    document.addEventListener('keyup', preventEvent);
    document.addEventListener('keypress', preventEvent);
    document.addEventListener('click', preventEvent);
    
    // Start countdown
    freezeInterval = setInterval(function() {
        remainingTime--;
        document.getElementById('freeze-countdown').textContent = remainingTime;
        
        if (remainingTime <= 0) {
            // End freeze
            clearInterval(freezeInterval);
            alertSound.pause();
            alertSound.currentTime = 0;
            alertSound.loop = false;
            alertSound.removeEventListener('volumechange', volumeHandler);
            
            // Remove freeze elements
            document.body.removeChild(freezeOverlay);
            document.body.removeChild(freezeWarning);
            
            // Re-enable inputs
            inputs.forEach(input => {
                input.disabled = false;
                input.style.opacity = '1';
            });
            
            // Remove event listeners
            document.removeEventListener('contextmenu', preventEvent);
            document.removeEventListener('keydown', preventEvent);
            document.removeEventListener('keyup', preventEvent);
            document.removeEventListener('keypress', preventEvent);
            document.removeEventListener('click', preventEvent);
            
            isFrozen = false;
            
            // Show unfreeze message
            showUnfreezeMessage();
        }
    }, 1000);
}

// Show unfreeze message
function showUnfreezeMessage() {
    const unfreezeMessage = document.createElement('div');
    unfreezeMessage.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 20px;
        border-radius: 10px;
        z-index: 10000;
        max-width: 300px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    `;
    
    unfreezeMessage.innerHTML = `
        <div style="font-size: 24px; margin-bottom: 10px;">✅</div>
        <h4 style="margin-bottom: 10px;">Sistem Aktif Kembali</h4>
        <p style="margin: 0; font-size: 14px;">
            Anda dapat melanjutkan ujian. Berhati-hatilah untuk tidak berganti tab lagi.
        </p>
    `;
    
    document.body.appendChild(unfreezeMessage);
    
    // Auto remove message after 5 seconds
    setTimeout(function() {
        if (document.body.contains(unfreezeMessage)) {
            document.body.removeChild(unfreezeMessage);
        }
    }, 5000);
}

// Disable all interactions
function disableInteractions() {
    if (isDisabled) return;
    
    isDisabled = true;
    
    // Create overlay to block interactions
    const overlay = document.createElement('div');
    overlay.id = 'cheat-disable-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 0, 0, 0.1);
        z-index: 9998;
        pointer-events: all;
    `;
    
    // Show final warning
    const finalWarning = document.createElement('div');
    finalWarning.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #dc3545;
        color: white;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        z-index: 9999;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    `;
    
    finalWarning.innerHTML = `
        <div style="font-size: 48px; margin-bottom: 20px;">🚫</div>
        <h3 style="margin-bottom: 20px;">UJIAN DIKUNCI!</h3>
        <p style="margin-bottom: 20px; line-height: 1.5;">
            Anda telah melanggar aturan ujian dengan berganti tab sebanyak <strong>${tabSwitchCount} kali</strong>.<br><br>
            Interaksi dengan halaman telah dinonaktifkan. Segera hubungi pengawas ujian.
        </p>
        <div style="font-size: 14px; opacity: 0.9;">
            Tab switches: ${tabSwitchCount}/12 (LIMIT EXCEEDED)
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.appendChild(finalWarning);
    
    // Disable form inputs
    const inputs = document.querySelectorAll('input, textarea, button, select');
    inputs.forEach(input => {
        input.disabled = true;
        input.style.opacity = '0.5';
    });
    
    // Prevent right-click and keyboard shortcuts
    document.addEventListener('contextmenu', preventEvent);
    document.addEventListener('keydown', preventEvent);
    document.addEventListener('keyup', preventEvent);
    document.addEventListener('keypress', preventEvent);
}

// Prevent events function
function preventEvent(e) {
    e.preventDefault();
    e.stopPropagation();
    return false;
}

// Optional: Add tab switch counter display
function addTabSwitchCounter() {
    const counter = document.createElement('div');
    counter.id = 'tab-switch-counter';
    counter.style.cssText = `
        position: fixed;
        top: 10px;
        right: 10px;
        background: #fff;
        border: 2px solid #dc3545;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 1000;
        color: #dc3545;
        font-weight: bold;
    `;
    counter.innerHTML = `Tab Switches: <span id="switch-count">0</span>/12`;
    document.body.appendChild(counter);
    
    // Update counter on visibility change
    const originalVisibilityHandler = document.onvisibilitychange;
    document.addEventListener('visibilitychange', function() {
        document.getElementById('switch-count').textContent = tabSwitchCount;
        
        const counterElement = document.getElementById('tab-switch-counter');
        if (tabSwitchCount >= 5) {
            counterElement.style.background = '#dc3545';
            counterElement.style.color = 'white';
            counterElement.style.animation = 'pulse 1s infinite';
        }
    });
}

// Add CSS for pulse animation
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
`;
document.head.appendChild(style);

// Prevent volume control and audio tampering
document.addEventListener('DOMContentLoaded', function() {
    // Monitor and prevent volume changes
    setInterval(function() {
        if (alertSound.volume !== 1.0) {
            alertSound.volume = 1.0;
        }
    }, 100);
    
    // Block audio context manipulation
    if (window.AudioContext || window.webkitAudioContext) {
        const OriginalAudioContext = window.AudioContext || window.webkitAudioContext;
        window.AudioContext = window.webkitAudioContext = function() {
            const context = new OriginalAudioContext();
            const originalCreateGain = context.createGain;
            context.createGain = function() {
                const gain = originalCreateGain.call(context);
                const originalGainSetter = Object.getOwnPropertyDescriptor(gain.gain, 'value').set;
                Object.defineProperty(gain.gain, 'value', {
                    set: function(value) {
                        if (isFrozen || tabSwitchCount >= 8) {
                            originalGainSetter.call(this, 1.0);
                        } else {
                            originalGainSetter.call(this, value);
                        }
                    },
                    get: function() {
                        return Object.getOwnPropertyDescriptor(gain.gain, 'value').get.call(this);
                    }
                });
                return gain;
            };
            return context;
        };
    }
});

// Initialize counter (optional - remove if not needed)
// addTabSwitchCounter();
    
        const startTime = Date.now();
        document.getElementById('start_time_input').value = Math.floor(startTime / 1000);

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
                timerElement.textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

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
                let answeredQuestions = 0;

                // Count radio buttons (multiple choice and true/false)
                answeredQuestions += document.querySelectorAll('input[type="radio"]:checked').length;

                // Count checkbox questions (at least one checked per question)
                const checkboxQuestions = document.querySelectorAll('input[type="checkbox"]');
                const checkboxGroups = {};
                checkboxQuestions.forEach(checkbox => {
                    const name = checkbox.name;
                    if (!checkboxGroups[name]) {
                        checkboxGroups[name] = false;
                    }
                    if (checkbox.checked) {
                        checkboxGroups[name] = true;
                    }
                });
                answeredQuestions += Object.values(checkboxGroups).filter(Boolean).length;

                // Count essay questions (non-empty textareas)
                const essayQuestions = document.querySelectorAll('textarea');
                essayQuestions.forEach(textarea => {
                    if (textarea.value.trim() !== '') {
                        answeredQuestions++;
                    }
                });

                const progressPercentage = (answeredQuestions / totalQuestions) * 100;
                document.getElementById('answered-count').textContent = answeredQuestions;
                document.getElementById('progress-bar').style.width = progressPercentage + '%';

                const submitBtn = document.getElementById('submit-btn');
                if (answeredQuestions === totalQuestions) {
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');
                    submitBtn.innerHTML =
                        '<i class="fas fa-check-circle me-2"></i>Semua Soal Terjawab - Submit Quiz';
                }
            }

            // Make updateProgress globally accessible
            window.updateProgress = updateProgress;

            // === SAVE & LOAD PROGRESS ===
            function saveProgress() {
                const answers = {};

                // Save radio button answers
                document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                    const soalId = input.name.split('_')[1];
                    answers[soalId] = input.value;
                });

                // Save checkbox answers
                const checkboxGroups = {};
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
                    const soalId = input.name.split('_')[1].replace('[]', '');
                    if (!checkboxGroups[soalId]) {
                        checkboxGroups[soalId] = [];
                    }
                    checkboxGroups[soalId].push(input.value);
                });
                Object.keys(checkboxGroups).forEach(soalId => {
                    answers[soalId] = checkboxGroups[soalId];
                });

                // Save essay answers
                document.querySelectorAll('textarea').forEach(textarea => {
                    const soalId = textarea.name.split('_')[1];
                    answers[soalId] = textarea.value;
                });

                localStorage.setItem(storageKey, JSON.stringify(answers));
            }

            // Load saved progress
            const savedAnswers = JSON.parse(localStorage.getItem(storageKey));
            if (savedAnswers) {
                Object.keys(savedAnswers).forEach(soalId => {
                    const savedAnswer = savedAnswers[soalId];

                    // Handle radio buttons
                    const radio = document.querySelector(
                        `input[name="jawaban_${soalId}"][value="${savedAnswer}"]`);
                    if (radio) {
                        radio.checked = true;
                    }

                    // Handle checkboxes
                    if (Array.isArray(savedAnswer)) {
                        savedAnswer.forEach(value => {
                            const checkbox = document.querySelector(
                                `input[name="jawaban_${soalId}[]"][value="${value}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    }

                    // Handle essays
                    const textarea = document.querySelector(`textarea[name="jawaban_${soalId}"]`);
                    if (textarea) {
                        textarea.value = savedAnswer;
                    }
                });
                updateProgress();
            }

            // Add event listeners for all input types
            document.querySelectorAll('input[type="radio"], input[type="checkbox"], textarea').forEach(input => {
                input.addEventListener('change', () => {
                    updateProgress();
                    saveProgress();
                });

                if (input.tagName === 'TEXTAREA') {
                    input.addEventListener('input', () => {
                        updateProgress();
                        saveProgress();
                    });
                }
            });

            // === FORM SUBMIT HANDLING ===
            form.addEventListener('submit', function(e) {
                let answeredQuestions = 0;

                // Count answered questions
                answeredQuestions += document.querySelectorAll('input[type="radio"]:checked').length;

                const checkboxGroups = {};
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    const name = checkbox.name;
                    if (!checkboxGroups[name]) {
                        checkboxGroups[name] = false;
                    }
                    if (checkbox.checked) {
                        checkboxGroups[name] = true;
                    }
                });
                answeredQuestions += Object.values(checkboxGroups).filter(Boolean).length;

                document.querySelectorAll('textarea').forEach(textarea => {
                    if (textarea.value.trim() !== '') {
                        answeredQuestions++;
                    }
                });

                if (answeredQuestions < totalQuestions) {
                    if (!confirm(
                            `Anda baru menjawab ${answeredQuestions} dari ${totalQuestions} soal.\n\nYakin ingin submit?`
                            )) {
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
