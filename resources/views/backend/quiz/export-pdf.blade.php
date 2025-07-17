<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quiz Export - {{ $quiz->judul_quiz }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .quiz-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .quiz-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .quiz-info td {
            padding: 5px;
            border: none;
        }
        
        .quiz-info .label {
            font-weight: bold;
            width: 150px;
        }
        
        .question {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .question-header {
            background-color: #4472C4;
            color: white;
            padding: 8px;
            font-weight: bold;
            border-radius: 3px 3px 0 0;
        }
        
        .question-content {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 0 0 3px 3px;
        }
        
        .question-text {
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .options {
            margin-left: 20px;
        }
        
        .option {
            margin-bottom: 8px;
            padding: 5px;
        }
        
        .correct-answer {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 3px;
            padding: 5px;
            margin-top: 10px;
        }
        
        .type-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .type-pilihan-ganda {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .type-benar-salah {
            background-color: #fff3e0;
            color: #f57c00;
        }
        
        .type-checkbox {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        
        .type-essay {
            background-color: #e8f5e8;
            color: #388e3c;
        }
        
        .essay-answer {
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
            padding: 20px;
            margin-top: 10px;
            min-height: 60px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $quiz->judul_quiz }}</h1>
        <p>Kode Quiz: {{ $quiz->kode_quiz }}</p>
        <p>Tanggal Export: {{ date('d F Y, H:i:s') }}</p>
    </div>
    
    <div class="quiz-info">
        <table>
            <tr>
                <td class="label">Deskripsi:</td>
                <td>{{ $quiz->deskripsi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Waktu:</td>
                <td>{{ $quiz->waktu_menit }} menit</td>
            </tr>
            <tr>
                <td class="label">Total Soal:</td>
                <td>{{ $quiz->soals->count() }} soal</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td>{{ $quiz->status_aktivasi ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
        </table>
    </div>
    
    @foreach($quiz->soals as $index => $soal)
        <div class="question">
            <div class="question-header">
                Soal {{ $index + 1 }} 
                <span class="type-badge type-{{ str_replace('_', '-', $soal->tipe) }}">
                    {{ $soal->tipe == 'pilihan_ganda' ? 'Pilihan Ganda' : 
                       ($soal->tipe == 'benar_salah' ? 'Benar/Salah' : 
                       ($soal->tipe == 'checkbox' ? 'Checkbox' : 'Essay')) }}
                </span>
                <span style="float: right;">Bobot: {{ $soal->bobot ?? 1 }}</span>
            </div>
            
            <div class="question-content">
                <div class="question-text">
                    {{ $soal->pertanyaan }}
                </div>
                
                @if($soal->tipe == 'pilihan_ganda')
                    <div class="options">
                        @if($soal->pilihan_a)
                            <div class="option">A. {{ $soal->pilihan_a }}</div>
                        @endif
                        @if($soal->pilihan_b)
                            <div class="option">B. {{ $soal->pilihan_b }}</div>
                        @endif
                        @if($soal->pilihan_c)
                            <div class="option">C. {{ $soal->pilihan_c }}</div>
                        @endif
                        @if($soal->pilihan_d)
                            <div class="option">D. {{ $soal->pilihan_d }}</div>
                        @endif
                        @if($soal->pilihan_e)
                            <div class="option">E. {{ $soal->pilihan_e }}</div>
                        @endif
                    </div>
                    
                    <div class="correct-answer">
                        <strong>Jawaban Benar:</strong> {{ $soal->jawaban_benar }}
                    </div>
                    
                @elseif($soal->tipe == 'benar_salah')
                    <div class="options">
                        <div class="option">A. Benar</div>
                        <div class="option">B. Salah</div>
                    </div>
                    
                    <div class="correct-answer">
                        <strong>Jawaban Benar:</strong> {{ $soal->jawaban_benar }}
                    </div>
                    
                @elseif($soal->tipe == 'checkbox')
                    <div class="options">
                        @if($soal->pilihan_a)
                            <div class="option">☐ {{ $soal->pilihan_a }}</div>
                        @endif
                        @if($soal->pilihan_b)
                            <div class="option">☐ {{ $soal->pilihan_b }}</div>
                        @endif
                        @if($soal->pilihan_c)
                            <div class="option">☐ {{ $soal->pilihan_c }}</div>
                        @endif
                        @if($soal->pilihan_d)
                            <div class="option">☐ {{ $soal->pilihan_d }}</div>
                        @endif
                        @if($soal->pilihan_e)
                            <div class="option">☐ {{ $soal->pilihan_e }}</div>
                        @endif
                    </div>
                    
                    <div class="correct-answer">
                        <strong>Jawaban Benar:</strong> {{ $soal->jawaban_benar }}
                    </div>
                    
                @elseif($soal->tipe == 'essay')
                    <div class="essay-answer">
                        <em>Ruang untuk jawaban essay...</em>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    
    <div class="footer">
        Halaman {PAGE_NUM} dari {PAGE_COUNT}
    </div>
</body>
</html>