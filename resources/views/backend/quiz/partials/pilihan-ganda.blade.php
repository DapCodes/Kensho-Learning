{{-- resources/views/quiz/partials/pilihan-ganda.blade.php --}}
<div class="mb-4">
    <h6 class="text-dark mb-3">
        <i class="ti ti-list text-primary me-2"></i>Pilihan Jawaban:
    </h6>
    
    @php
        $options = ['A', 'B', 'C', 'D'];
        $optionFields = ['pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d'];
    @endphp
    
    <div class="row">
        @foreach($options as $key => $option)
            @if($soal->{$optionFields[$key]})
                <div class="col-md-6 mb-3">
                    <div class="option-item d-flex align-items-center p-3 rounded {{ $soal->jawaban_benar == $option ? 'bg-success-subtle border border-success' : 'bg-light border' }}">
                        <span class="badge {{ $soal->jawaban_benar == $option ? 'bg-success' : 'bg-secondary' }} me-3 fs-6">{{ $option }}</span>
                        <span class="text-dark flex-grow-1">{{ $soal->{$optionFields[$key]} }}</span>
                        @if ($soal->jawaban_benar == $option)
                            <i class="ti ti-check-circle text-success fs-5"></i>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    @if(!$soal->pilihan_a && !$soal->pilihan_b && !$soal->pilihan_c && !$soal->pilihan_d)
        <div class="alert alert-warning">
            <i class="ti ti-alert-triangle me-2"></i>
            Pilihan jawaban belum diisi.
        </div>
    @endif
</div>