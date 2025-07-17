{{-- resources/views/backend/quiz/partials/checkbox.blade.php --}}
<div class="mb-4">
    <h6 class="text-dark mb-3">
        <i class="ti ti-checkbox text-info me-2"></i>Pilihan Ganda (Multiple Answer):
    </h6>
    
    <div class="bg-info-subtle border border-info rounded p-2 mb-3">
        <small class="text-info">
            <i class="ti ti-info-circle me-1"></i>
            Soal ini memiliki lebih dari satu jawaban yang benar
        </small>
    </div>
    
    @php
        $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
        $letterLabels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        
        // Get all available options
        $options = [];
        if ($soal->pilihan_a) $options[] = $soal->pilihan_a;
        if ($soal->pilihan_b) $options[] = $soal->pilihan_b;
        if ($soal->pilihan_c) $options[] = $soal->pilihan_c;
        if ($soal->pilihan_d) $options[] = $soal->pilihan_d;
        if ($soal->pilihan_e) $options[] = $soal->pilihan_e;
        if ($soal->pilihan_f) $options[] = $soal->pilihan_f;
        if ($soal->pilihan_g) $options[] = $soal->pilihan_g;
        if ($soal->pilihan_h) $options[] = $soal->pilihan_h;
        if ($soal->pilihan_i) $options[] = $soal->pilihan_i;
        if ($soal->pilihan_j) $options[] = $soal->pilihan_j;
        
        // Handle different formats of correct answers
        $correctAnswers = [];
        if (is_string($soal->jawaban_benar)) {
            $correctAnswers = explode(',', $soal->jawaban_benar);
        } elseif (is_array($soal->jawaban_benar)) {
            $correctAnswers = $soal->jawaban_benar;
        }
        
        // Clean up the array
        $correctAnswers = array_map('trim', $correctAnswers);
        $correctAnswers = array_filter($correctAnswers);
        
        // Convert to consistent format (indices)
        $correctIndices = [];
        foreach ($correctAnswers as $answer) {
            if (is_numeric($answer)) {
                $correctIndices[] = (int)$answer;
            } else {
                // If it's a letter, convert to index
                $letterIndex = array_search(strtoupper($answer), $letterLabels);
                if ($letterIndex !== false) {
                    $correctIndices[] = $letterIndex;
                }
            }
        }
    @endphp
    
    <div class="row">
        @foreach($options as $index => $pilihan)
            @php
                $isCorrect = in_array($index, $correctIndices);
            @endphp
            
            <div class="col-md-6 mb-2">
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="checkbox_{{ $soal->id }}_{{ $index }}"
                           disabled
                           @if($isCorrect) checked @endif>
                    
                    <label class="form-check-label d-flex align-items-center 
                           @if($isCorrect) text-success @endif" 
                           for="checkbox_{{ $soal->id }}_{{ $index }}">
                        
                        <span class="badge me-2 
                              @if($isCorrect) bg-success @else bg-secondary @endif">
                            {{ $letterLabels[$index] }}
                        </span>
                        
                        <span class="flex-grow-1">{{ $pilihan }}</span>
                        
                        @if($isCorrect)
                            <i class="ti ti-check text-success ms-2"></i>
                        @endif
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Tampilkan informasi jawaban benar --}}
    <div class="mt-3">
        <div class="bg-success-subtle border border-success rounded p-3">
            <div class="row">
                <div class="col-md-8">
                    <h6 class="mb-2">
                        <i class="ti ti-check-circle text-success me-2"></i>
                        Jawaban Benar
                    </h6>
                    <p class="mb-0 text-success fw-semibold">
                        {{ implode(', ', array_map(function($i) use ($letterLabels) { return $letterLabels[$i]; }, $correctIndices)) }}
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="text-end">
                        <small class="text-muted">
                            <i class="ti ti-info-circle me-1"></i>
                            {{ count($correctIndices) }} jawaban benar
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>