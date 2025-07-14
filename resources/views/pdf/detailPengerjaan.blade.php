<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pengerjaan - {{ $hasil->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
        }
        
        .header h1 {
            color: #4CAF50;
            font-size: 24px;
            margin: 0;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .info-section h2 {
            color: #2196F3;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #2196F3;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 140px;
        }
        
        .info-value {
            color: #333;
        }
        
        .score-highlight {
            background: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .detail-section {
            margin-top: 30px;
        }
        
        .detail-section h2 {
            color: #FF5722;
            font-size: 18px;
            margin-bottom: 20px;
            border-bottom: 2px solid #FF5722;
            padding-bottom: 5px;
        }
        
        .soal-item {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
        }
        
        .soal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .soal-number {
            background: #2196F3;
            color: white;
            padding: 8px 12px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
        }
        
        .soal-meta {
            font-size: 11px;
            color: #666;
        }
        
        .soal-question {
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            line-height: 1.5;
        }
        
        .answer-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .answer-item {
            padding: 10px;
            border-radius: 5px;
        }
        
        .answer-correct {
            background: #E8F5E8;
            border-left: 4px solid #4CAF50;
        }
        
        .answer-student {
            background: #FFF3E0;
            border-left: 4px solid #FF9800;
        }
        
        .answer-label {
            font-weight: bold;
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .answer-text {
            color: #333;
            word-wrap: break-word;
        }
        
        .status-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }
        
        .status-benar { background: #4CAF50; }
        .status-salah { background: #F44336; }
        .status-sebagian { background: #FF9800; }
        .status-pending { background: #2196F3; }
        .status-tidak-dijawab { background: #9E9E9E; }
        
        .bobot-info {
            font-size: 11px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL PENGERJAAN UJIAN</h1>
        <p>Laporan Hasil Ujian Siswa</p>
        <p>Digenerate pada: {{ date('d F Y, H:i:s') }}</p>
    </div>

    <div class="info-section">
        <h2>Informasi Peserta</h2>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <span class="info-label">Nama Peserta:</span>
                    <span class="info-value">{{ $hasil->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $hasil->user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Judul Quiz:</span>
                    <span class="info-value">{{ $hasil->quiz->judul }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Ujian:</span>
                    <span class="info-value">{{ $hasil->tanggal_ujian->format('d F Y') }}</span>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-label">Waktu Pengerjaan:</span>
                    <span class="info-value">{{ $hasil->waktu_pengerjaan }} menit</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Skor Akhir:</span>
                    <span class="info-value score-highlight">{{ $hasil->skor }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Bobot Diperoleh:</span>
                    <span class="info-value">{{ $hasil->bobot_diperoleh }} / {{ $hasil->total_bobot }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        @if($hasil->skor >= 80)
                            <span style="color: #4CAF50; font-weight: bold;">Sangat Baik</span>
                        @elseif($hasil->skor >= 70)
                            <span style="color: #8BC34A; font-weight: bold;">Baik</span>
                        @elseif($hasil->skor >= 60)
                            <span style="color: #FF9800; font-weight: bold;">Cukup</span>
                        @elseif($hasil->skor >= 50)
                            <span style="color: #FF5722; font-weight: bold;">Kurang</span>
                        @else
                            <span style="color: #F44336; font-weight: bold;">Sangat Kurang</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <h2>Detail Pengerjaan Soal</h2>
        
        @foreach($hasil->detail as $index => $detail)
            <div class="soal-item">
                <div class="soal-header">
                    <span class="soal-number">{{ $index + 1 }}</span>
                    <div class="soal-meta">
                        Jenis: {{ ucfirst(str_replace('_', ' ', $detail->soal->jenis_soal)) }} | 
                        Tingkat: {{ $detail->soal->tingkat_kesulitan ?? 'Normal' }}
                    </div>
                </div>
                
                <div class="soal-question">
                    {{ $detail->soal->pertanyaan }}
                </div>
                
                <div class="answer-section">
                    <div class="answer-item answer-correct">
                        <div class="answer-label">JAWABAN BENAR:</div>
                        <div class="answer-text">
                            @switch($detail->soal->jenis_soal)
                                @case('pilihan_ganda')
                                    {{ $detail->soal->jawaban_benar }}
                                    @break
                                @case('checkbox')
                                    {{ str_replace(',', ', ', $detail->soal->jawaban_benar) }}
                                    @break
                                @case('essay')
                                    Jawaban Essay (Subjektif)
                                    @break
                                @case('benar_salah')
                                    {{ $detail->soal->jawaban_benar }}
                                    @break
                                @default
                                    {{ $detail->soal->jawaban_benar }}
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="answer-item answer-student">
                        <div class="answer-label">JAWABAN PESERTA:</div>
                        <div class="answer-text">
                            @if(empty($detail->jawaban_peserta))
                                <em>Tidak dijawab</em>
                            @else
                                @if(strpos($detail->jawaban_peserta, ',') !== false)
                                    {{ str_replace(',', ', ', $detail->jawaban_peserta) }}
                                @else
                                    {{ $detail->jawaban_peserta }}
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="status-section">
                    <div>
                        <span class="status-badge 
                            @switch($detail->status_jawaban)
                                @case('benar') status-benar @break
                                @case('salah') status-salah @break
                                @case('sebagian') status-sebagian @break
                                @case('pending') status-pending @break
                                @case('tidak dijawab') status-tidak-dijawab @break
                            @endswitch
                        ">
                            @switch($detail->status_jawaban)
                                @case('benar') BENAR @break
                                @case('salah') SALAH @break
                                @case('sebagian') SEBAGIAN BENAR @break
                                @case('pending') PENDING @break
                                @case('tidak dijawab') TIDAK DIJAWAB @break
                            @endswitch
                        </span>
                    </div>
                    
                    <div class="bobot-info">
                        Bobot: {{ $detail->bobot_diperoleh }} / {{ $detail->bobot_soal }} 
                        ({{ $detail->persentase_bobot }}%)
                    </div>
                </div>
            </div>
            
            @if(($index + 1) % 3 == 0 && !$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>

    <div class="footer">
        <p>Laporan Detail Pengerjaan - {{ $hasil->user->name }} | {{ $hasil->quiz->judul }}</p>
    </div>
</body>
</html>