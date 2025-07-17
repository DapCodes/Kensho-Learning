<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DataNilaiExport implements FromCollection, WithColumnFormatting, WithHeadings, WithStyles
{
    protected $hasilUjians;

    public function __construct($hasilUjians)
    {
        $this->hasilUjians = $hasilUjians;
    }

    public function collection()
    {
        $data = collect();

        foreach ($this->hasilUjians as $hasilUjian) {
            // Load detail dengan relasi soal
            $details = $hasilUjian->detail()->with('soal')->get();

            foreach ($details as $index => $detail) {
                $data->push([
                    'No' => $data->count() + 1,
                    'Nama Peserta' => optional($hasilUjian->user)->name ?? '-',
                    'Email' => optional($hasilUjian->user)->email ?? '-',
                    'Judul Quiz' => optional($hasilUjian->quiz)->judul_quiz ?? '-',
                    'Tanggal Ujian' => $hasilUjian->tanggal_ujian ?? '-',
                    'No Soal' => $index + 1,
                    'Tipe Soal' => $this->getTipeSoalLabel($detail->soal->tipe ?? ''),
                    'Pertanyaan' => $this->cleanText($detail->soal->pertanyaan ?? ''),
                    'Pilihan A' => $this->cleanText($detail->soal->pilihan_a ?? ''),
                    'Pilihan B' => $this->cleanText($detail->soal->pilihan_b ?? ''),
                    'Pilihan C' => $this->cleanText($detail->soal->pilihan_c ?? ''),
                    'Pilihan D' => $this->cleanText($detail->soal->pilihan_d ?? ''),
                    'Pilihan E' => $this->cleanText($detail->soal->pilihan_e ?? ''),
                    'Jawaban Benar' => $this->getJawabanBenar($detail->soal),
                    'Jawaban Peserta' => $detail->jawaban_peserta_formatted ?? 'Tidak dijawab',
                    'Status Jawaban' => $this->getStatusLabel($detail->status_jawaban),
                    'Bobot Soal' => $detail->bobot_soal ?? 0,
                    'Bobot Diperoleh' => $detail->bobot_diperoleh ?? 0,
                    'Persentase' => $detail->persentase_bobot ?? 0,
                ]);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peserta',
            'Email',
            'Judul Quiz',
            'Tanggal Ujian',
            'No Soal',
            'Tipe Soal',
            'Pertanyaan',
            'Pilihan A',
            'Pilihan B',
            'Pilihan C',
            'Pilihan D',
            'Pilihan E',
            'Jawaban Benar',
            'Jawaban Peserta',
            'Status Jawaban',
            'Bobot Soal',
            'Bobot Diperoleh',
            'Persentase (%)',
        ];
    }

    public function styles($sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $lastColumn = 'S'; // Kolom terakhir (S = kolom ke-19)

        // Style untuk header
        $sheet->getStyle('A1:'.$lastColumn.'1')
            ->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFF'));
        $sheet->getStyle('A1:'.$lastColumn.'1')
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:'.$lastColumn.'1')
            ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50');

        // Border untuk semua cell
        $sheet->getStyle('A1:'.$lastColumn.$highestRow)
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Text wrap untuk semua cell
        $sheet->getStyle('A1:'.$lastColumn.$highestRow)
            ->getAlignment()->setWrapText(true);

        // Set row height untuk menampilkan text wrap dengan baik
        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(60);
        }

        // Auto size columns dengan batas maksimal
        $columnWidths = [
            'A' => 5,   // No
            'B' => 25,  // Nama Peserta
            'C' => 25,  // Email
            'D' => 30,  // Judul Quiz
            'E' => 15,  // Tanggal Ujian
            'F' => 8,   // No Soal
            'G' => 12,  // Tipe Soal
            'H' => 50,  // Pertanyaan
            'I' => 30,  // Pilihan A
            'J' => 30,  // Pilihan B
            'K' => 30,  // Pilihan C
            'L' => 30,  // Pilihan D
            'M' => 30,  // Pilihan E
            'N' => 20,  // Jawaban Benar
            'O' => 25,  // Jawaban Peserta
            'P' => 15,  // Status Jawaban
            'Q' => 12,  // Bobot Soal
            'R' => 15,  // Bobot Diperoleh
            'S' => 12,  // Persentase
        ];

        foreach ($columnWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Center alignment untuk kolom tertentu
        $centerColumns = ['A', 'E', 'F', 'G', 'P', 'Q', 'R', 'S'];
        foreach ($centerColumns as $col) {
            $sheet->getStyle($col.':'.$col)
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Vertical alignment untuk semua cell
        $sheet->getStyle('A1:'.$lastColumn.$highestRow)
            ->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        // Styling untuk status jawaban
        for ($row = 2; $row <= $highestRow; $row++) {
            $statusCell = $sheet->getCell('P'.$row);
            $statusValue = $statusCell->getValue();

            switch ($statusValue) {
                case 'Benar':
                    $sheet->getStyle('P'.$row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D4EDDA');
                    $sheet->getStyle('P'.$row)->getFont()->setColor(new Color('155724'));
                    break;
                case 'Salah':
                    $sheet->getStyle('P'.$row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8D7DA');
                    $sheet->getStyle('P'.$row)->getFont()->setColor(new Color('721C24'));
                    break;
                case 'Sebagian Benar':
                    $sheet->getStyle('P'.$row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF3CD');
                    $sheet->getStyle('P'.$row)->getFont()->setColor(new Color('856404'));
                    break;
                case 'Pending':
                    $sheet->getStyle('P'.$row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D1ECF1');
                    $sheet->getStyle('P'.$row)->getFont()->setColor(new Color('0C5460'));
                    break;
            }
        }

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_NUMBER,
            'Q' => NumberFormat::FORMAT_NUMBER,
            'R' => '0.00',
            'S' => '0.00',
        ];
    }

    private function getTipeSoalLabel($tipe)
    {
        $labels = [
            'pilihan_ganda' => 'Pilihan Ganda',
            'checkbox' => 'Checkbox',
            'essay' => 'Essay',
            'benar_salah' => 'Benar/Salah',
        ];

        return $labels[$tipe] ?? ucfirst($tipe);
    }

    private function getJawabanBenar($soal)
    {
        if (! $soal) {
            return '-';
        }

        if ($soal->tipe == 'essay') {
            return 'Essay (Lihat Kunci Jawaban)';
        }

        if ($soal->tipe == 'checkbox') {
            // Jika jawaban benar berupa multiple choice (dipisahkan koma)
            if (strpos($soal->jawaban_benar, ',') !== false) {
                $jawaban = explode(',', $soal->jawaban_benar);

                return implode(', ', array_map('trim', $jawaban));
            }
        }

        return $soal->jawaban_benar ?? '-';
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'benar' => 'Benar',
            'salah' => 'Salah',
            'sebagian' => 'Sebagian Benar',
            'pending' => 'Pending',
            'tidak dijawab' => 'Tidak Dijawab',
        ];

        return $labels[$status] ?? 'Unknown';
    }

    private function cleanText($text)
    {
        // Membersihkan HTML tags dan entities
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // Menghilangkan karakter yang tidak diinginkan
        $text = preg_replace('/[\x00-\x1F\x7F]/', '', $text);

        return trim($text);
    }
}
