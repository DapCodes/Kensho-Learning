<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quiz Export - {{ $quiz->judul_quiz }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm 1.5cm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
        }
        
        .school-info {
            text-align: center;
            margin-bottom: 5px;
        }
        
        .school-name {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        
        .subject-info {
            font-size: 14px;
            margin: 5px 0;
            font-weight: bold;
        }
        
        .exam-title {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
            text-transform: uppercase;
        }
        
        .class-info {
            font-size: 12px;
            margin: 5px 0;
        }
        
        .quiz-details {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .left-details, .right-details {
            width: 48%;
        }
        
        .detail-row {
            margin-bottom: 3px;
            display: flex;
        }
        
        .detail-label {
            width: 120px;
            font-weight: normal;
        }
        
        .detail-value {
            flex: 1;
            border-bottom: 1px solid #000;
            padding-left: 5px;
        }
        
        .question {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .question-number {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .question-text {
            margin-bottom: 10px;
            text-align: justify;
        }
        
        .options {
            margin-left: 0;
        }
        
        .option {
            margin-bottom: 5px;
            display: flex;
            align-items: flex-start;
        }
        
        .option-letter {
            width: 20px;
            font-weight: bold;
        }
        
        .option-text {
            flex: 1;
        }
        
        .checkbox-option {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 8px;
            background-color: white;
        }
        
        .essay-space {
            margin-top: 10px;
            border: 1px solid #000;
            min-height: 100px;
            padding: 10px;
        }
        
        .answer-sheet {
            margin-top: 30px;
            page-break-before: always;
        }
        
        .answer-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        
        .answer-item {
            text-align: center;
            padding: 8px;
            border: 1px solid #000;
        }
        
        .answer-number {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .answer-options {
            display: flex;
            justify-content: space-around;
        }
        
        .answer-circle {
            width: 20px;
            height: 20px;
            border: 1px solid #000;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
        }
        
        .footer {
            position: fixed;
            bottom: 1cm;
            right: 1.5cm;
            font-size: 10px;
            color: #666;
        }

        /* Print specific styles */
        @media print {
            body {
                font-size: 11px;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .question {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-info">
            <h2 class="school-name">SMK ASSALAAM</h2>
            <div class="subject-info">{{ $quiz->mataPelajaran->nama_mapel ?? '...' }}</div>
        </div>
        
        <div class="exam-title">{{ $quiz->judul_quiz }}</div>
    </div>
    
    <div class="quiz-details">
        <div class="left-details">
            <div class="detail-row">
                <span class="detail-label">Nama : </span>
                <span class="detail-value"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">No. Absen : </span>
                <span class="detail-value"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Kelas : </span>
                <span class="detail-value"></span>
            </div>
        </div>
        
        <div class="right-details">
            <div class="detail-row">
                <span class="detail-label">Hari/Tanggal : </span>
                <span class="detail-value"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Waktu</span>
                <span class="detail-value">{{ $quiz->waktu_menit }} menit</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jumlah Soal</span>
                <span class="detail-value">{{ $quiz->soals->count() }} soal</span>
            </div>
        </div>
    </div>
    
    @foreach($quiz->soals as $index => $soal)
        <div class="question">
            <div class="question-number">{{ $index + 1 }}.</div>
            
            <div class="question-text">
                {{ $soal->pertanyaan }}
            </div>
            
            @if($soal->tipe == 'pilihan_ganda')
                <div class="options">
                    @if($soal->pilihan_a)
                        <div class="option">
                            <span class="option-letter">a.</span>
                            <span class="option-text">{{ $soal->pilihan_a }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_b)
                        <div class="option">
                            <span class="option-letter">b.</span>
                            <span class="option-text">{{ $soal->pilihan_b }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_c)
                        <div class="option">
                            <span class="option-letter">c.</span>
                            <span class="option-text">{{ $soal->pilihan_c }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_d)
                        <div class="option">
                            <span class="option-letter">d.</span>
                            <span class="option-text">{{ $soal->pilihan_d }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_e)
                        <div class="option">
                            <span class="option-letter">e.</span>
                            <span class="option-text">{{ $soal->pilihan_e }}</span>
                        </div>
                    @endif
                </div>
                
            @elseif($soal->tipe == 'benar_salah')
                <div class="options">
                    <div class="option">
                        <span class="option-letter">a.</span>
                        <span class="option-text">Benar</span>
                    </div>
                    <div class="option">
                        <span class="option-letter">b.</span>
                        <span class="option-text">Salah</span>
                    </div>
                </div>
                
            @elseif($soal->tipe == 'checkbox')
                <div class="options">
                    @if($soal->pilihan_a)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_a }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_b)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_b }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_c)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_c }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_d)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_d }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_e)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_e }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_f)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_f }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_g)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_g }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_h)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_h }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_i)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_i }}</span>
                        </div>
                    @endif
                    @if($soal->pilihan_j)
                        <div class="checkbox-option">
                            <span class="checkbox"></span>
                            <span>{{ $soal->pilihan_j }}</span>
                        </div>
                    @endif
                </div>
                
            @elseif($soal->tipe == 'essay')
                <div class="essay-space">
                    <!-- Ruang untuk jawaban essay -->
                </div>
            @endif
        </div>
    @endforeach
    
    <!-- Optional: Lembar jawaban terpisah untuk pilihan ganda -->
    {{-- Uncomment if you want a separate answer sheet
    <div class="answer-sheet">
        <h3>LEMBAR JAWABAN</h3>
        <p>Nama: _________________________ Kelas: _______ No. Absen: _____</p>
        
        <div class="answer-grid">
            @for($i = 1; $i <= $quiz->soals->count(); $i++)
                <div class="answer-item">
                    <div class="answer-number">{{ $i }}</div>
                    <div class="answer-options">
                        <span class="answer-circle"></span>A
                        <span class="answer-circle"></span>B
                        <span class="answer-circle"></span>C
                        <span class="answer-circle"></span>D
                        <span class="answer-circle"></span>E
                    </div>
                </div>
            @endfor
        </div>
    </div>
    --}}
</body>
</html>