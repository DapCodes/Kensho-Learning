<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Nilai Peserta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 18px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .status-badge {
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-sangat-baik {
            background-color: #4CAF50;
            color: white;
        }
        .status-baik {
            background-color: #8BC34A;
            color: white;
        }
        .status-cukup {
            background-color: #FFC107;
            color: black;
        }
        .status-kurang {
            background-color: #FF9800;
            color: white;
        }
        .status-sangat-kurang {
            background-color: #F44336;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA NILAI PESERTA</h1>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-box">
        <h3>Informasi Laporan</h3>
        <p><strong>Total Peserta:</strong> {{ count($hasilUjians) }} orang</p>
        <p><strong>Rata-rata Skor:</strong> {{ number_format($hasilUjians->avg('skor'), 2) }}</p>
        <p><strong>Skor Tertinggi:</strong> {{ $hasilUjians->max('skor') }}</p>
        <p><strong>Skor Terendah:</strong> {{ $hasilUjians->min('skor') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 15%;">Nama Peserta</th>
                <th style="width: 15%;">Email</th>
                <th style="width: 15%;">Judul Quiz</th>
                <th style="width: 8%;">Tanggal</th>
                <th style="width: 8%;">Waktu</th>
                <th style="width: 5%;">Benar</th>
                <th style="width: 5%;">Salah</th>
                <th style="width: 6%;">Skor</th>
                <th style="width: 6%;">Bobot</th>
                <th style="width: 6%;">Total</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilUjians as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ optional($item->user)->name }}</td>
                <td>{{ optional($item->user)->email }}</td>
                <td>{{ optional($item->quiz)->judul_quiz }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $item->waktu_pengerjaan }} mnt</td>
                <td class="text-center">{{ $item->jumlah_benar }}</td>
                <td class="text-center">{{ $item->jumlah_salah }}</td>
                <td class="text-center">{{ number_format($item->skor, 2) }}</td>
                <td class="text-center">{{ $item->bobot_diperoleh }}</td>
                <td class="text-center">{{ $item->total_bobot }}</td>
                <td class="text-center">
                    @php
                        $statusClass = 'status-sangat-kurang';
                        $statusText = 'Sangat Kurang';
                        
                        if($item->skor >= 80) {
                            $statusClass = 'status-sangat-baik';
                            $statusText = 'Sangat Baik';
                        } elseif($item->skor >= 70) {
                            $statusClass = 'status-baik';
                            $statusText = 'Baik';
                        } elseif($item->skor >= 60) {
                            $statusClass = 'status-cukup';
                            $statusText = 'Cukup';
                        } elseif($item->skor >= 50) {
                            $statusClass = 'status-kurang';
                            $statusText = 'Kurang';
                        }
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>