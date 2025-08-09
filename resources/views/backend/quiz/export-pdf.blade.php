<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->judul_quiz }} - Exam Paper</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 2cm 2cm 3cm 2cm;

            @bottom-center {
                content: "Halaman " counter(page) " dari " counter(pages);
                font-family: Arial, sans-serif;
                font-size: 10px;
                color: #666;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
            margin: 0 15px;
            padding: 20px;
        }

        /* Header Styles */
        .exam-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .exam-info {
            margin: 10px 0;
        }

        .subject-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .quiz-title {
            font-size: 16pt;
            font-weight: bold;
            margin: 10px 0;
            text-transform: uppercase;
            text-decoration: underline;
        }

        /* Student Information */
        .student-info {
            display: table;
            width: 100%;
            margin: 20px 0 30px 0;
            font-size: 12pt;
        }

        .student-row {
            display: table-row;
        }

        .student-left,
        .student-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }

        .info-field {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .field-label {
            width: 120px;
            font-weight: normal;
        }

        .field-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 20px;
            padding: 0 5px;
        }

        .field-filled {
            background: none;
        }

        /* Instructions */
        .instructions {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .instructions h4 {
            margin-bottom: 10px;
            font-size: 13pt;
            font-weight: bold;
        }

        .instructions ul {
            margin-left: 20px;
        }

        .instructions li {
            margin-bottom: 5px;
            font-size: 11pt;
        }

        /* Question Styles */
        .questions-container {
            margin-top: 25px;
        }

        .question {
            margin-bottom: 25px;
            page-break-inside: avoid;
            orphans: 3;
            widows: 3;
        }

        .question-header {
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 12pt;
            gap: 8px;
        }

        .question-number {
            min-width: 30px;
            flex-shrink: 0;
            font-weight: bold;
        }

        .question-text {
            flex: 1;
            text-align: justify;
            line-height: 1.6;
            font-weight: normal;
        }

        /* Multiple Choice Options */
        .options {
            margin-left: 38px;
            margin-top: 10px;
        }

        .option {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
            gap: 8px;
        }

        .option-letter {
            min-width: 20px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .option-text {
            flex: 1;
            text-align: justify;
            line-height: 1.4;
        }

        /* True/False Options */
        .true-false-options {
            margin-left: 38px;
            margin-top: 10px;
            display: flex;
            gap: 30px;
        }

        .tf-option {
            display: flex;
            align-items: center;
            font-weight: bold;
        }

        .tf-circle {
            width: 15px;
            height: 15px;
            border: 2px solid #000;
            border-radius: 50%;
            margin-right: 8px;
        }

        /* Checkbox Options */
        .checkbox-options {
            margin-left: 38px;
            margin-top: 10px;
        }

        .checkbox-option {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
            gap: 8px;
        }

        .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .checkbox-text {
            flex: 1;
            text-align: justify;
            line-height: 1.4;
        }

        /* Essay Answer Space */
        .essay-space {
            margin-left: 38px;
            margin-top: 15px;
            min-height: 120px;
            border: 1px solid #000;
            background:
                repeating-linear-gradient(transparent,
                    transparent 23px,
                    #ddd 23px,
                    #ddd 24px);
            position: relative;
        }

        .essay-space::before {
            content: "Jawaban:";
            position: absolute;
            top: 5px;
            left: 10px;
            font-style: italic;
            color: #666;
            font-size: 10pt;
        }

        /* Page Break Controls */
        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        /* Print Optimizations */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
                margin: 0;
                padding: 15px;
            }

            .question {
                break-inside: avoid;
            }

            .instructions {
                break-inside: avoid;
            }
        }

        /* Footer */
        .footer-info {
            position: fixed;
            bottom: 1cm;
            left: 2cm;
            right: 2cm;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Exam Header -->
    <div class="exam-header">
        <div class="school-name">SMK ASSALAAM</div>
        <div class="subject-name">{{ $quiz->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</div>
        <div class="quiz-title">{{ $quiz->judul_quiz }}</div>
    </div>

    <!-- Student Information -->
    <div class="student-info">
        <div class="student-row">
            <div class="student-left">
                <div class="info-field">
                    <span class="field-label">Nama:</span>
                    <span class="field-value"></span>
                </div>
                <div class="info-field">
                    <span class="field-label">Kelas:</span>
                    <span class="field-value"></span>
                </div>
            </div>
            <div class="student-right">
                <div class="info-field">
                    <span class="field-label">Waktu:</span>
                    <span class="field-value field-filled">{{ $quiz->waktu_menit }} menit</span>
                </div>
                <div class="info-field">
                    <span class="field-label">Jumlah Soal:</span>
                    <span class="field-value field-filled">{{ $jumlahSoal }} soal</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="instructions no-break">
        <h4>PETUNJUK UMUM:</h4>
        <ul>
            <li>Tulis nama, dan kelas pada tempat yang telah disediakan.</li>
            <li>Periksa dan bacalah soal-soal sebelum menjawab.</li>
            <li>Dahulukan menjawab soal-soal yang dianggap mudah.</li>
            <li>Untuk soal pilihan ganda, pilihlah salah satu jawaban yang paling tepat.</li>
            <li>Untuk soal essay, jawablah dengan jelas dan lengkap pada tempat yang disediakan.</li>
            <li>Periksa kembali pekerjaan Anda sebelum dikumpulkan.</li>
        </ul>
    </div>

    <!-- Questions -->
    <div class="questions-container">
        @foreach ($quiz->soals as $index => $soal)
            <div class="question">
                <div class="question-header">
                    <div class="question-text"> <span class="question-number">{{ $index + 1 }}.</span>
                        {!! nl2br(e($soal->pertanyaan)) !!}</div>
                </div>

                @if ($soal->tipe == 'pilihan_ganda')
                    <div class="options">
                        @if (!empty($soal->pilihan_a))
                            <div class="option">
                                <span class="option-letter">a.</span>
                                <span class="option-text">{{ $soal->pilihan_a }}</span>
                            </div>
                        @endif
                        @if (!empty($soal->pilihan_b))
                            <div class="option">
                                <span class="option-letter">b.</span>
                                <span class="option-text">{{ $soal->pilihan_b }}</span>
                            </div>
                        @endif
                        @if (!empty($soal->pilihan_c))
                            <div class="option">
                                <span class="option-letter">c.</span>
                                <span class="option-text">{{ $soal->pilihan_c }}</span>
                            </div>
                        @endif
                        @if (!empty($soal->pilihan_d))
                            <div class="option">
                                <span class="option-letter">d.</span>
                                <span class="option-text">{{ $soal->pilihan_d }}</span>
                            </div>
                        @endif
                        @if (!empty($soal->pilihan_e))
                            <div class="option">
                                <span class="option-letter">e.</span>
                                <span class="option-text">{{ $soal->pilihan_e }}</span>
                            </div>
                        @endif
                    </div>
                @elseif($soal->tipe == 'benar_salah')
                    <div class="true-false-options">
                        <div class="tf-option">
                            <span class="tf-circle"></span>
                            <span>BENAR</span>
                        </div>
                        <div class="tf-option">
                            <span class="tf-circle"></span>
                            <span>SALAH</span>
                        </div>
                    </div>
                @elseif($soal->tipe == 'checkbox')
                    <div class="checkbox-options">
                        @foreach (['pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'pilihan_e', 'pilihan_f', 'pilihan_g', 'pilihan_h', 'pilihan_i', 'pilihan_j'] as $option)
                            @if (!empty($soal->$option))
                                <div class="checkbox-option">
                                    <span class="checkbox"></span>
                                    <span class="checkbox-text">{{ $soal->$option }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif($soal->tipe == 'essay')
                    <div class="essay-space"></div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="footer-info">
        <em>{{ $quiz->judul_quiz }} - {{ $quiz->mataPelajaran->nama_mapel ?? 'SMK Assalaam' }}</em>
    </div>
</body>

</html>
