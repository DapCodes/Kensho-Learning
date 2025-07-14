<?php

namespace App\Exports;

use App\Models\HasilUjian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DataPengerjaanSiswaExport implements FromCollection, WithColumnFormatting, WithHeadings, WithStyles, WithTitle
{
    protected $hasilUjianId;

    protected $hasilUjian;

    public function __construct($hasilUjianId)
    {
        $this->hasilUjianId = $hasilUjianId;
        $this->hasilUjian = HasilUjian::with(['quiz', 'user', 'detail.soal'])->findOrFail($hasilUjianId);
    }

    public function collection()
    {
        return $this->hasilUjian->detail->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Pertanyaan' => $this->limitText($item->soal->pertanyaan, 100),
                'Jawaban Benar' => $this->formatJawabanBenar($item->soal),
                'Jawaban Peserta' => $this->formatJawabanPeserta($item->jawaban_peserta),
                'Status' => $this->getStatusJawaban($item->status_jawaban),
                'Bobot Soal' => $item->bobot_soal,
                'Bobot Diperoleh' => $item->bobot_diperoleh,
                'Persentase' => $item->persentase_bobot.'%',
                'Jenis Soal' => $item->soal->tipe,
                'Tingkat Kesulitan' => $item->soal->tingkat_kesulitan ?? 'Normal',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Pertanyaan',
            'Jawaban Benar',
            'Jawaban Peserta',
            'Status',
            'Bobot Soal',
            'Bobot Diperoleh',
            'Persentase (%)',
            'Jenis Soal',
            'Tingkat Kesulitan',
        ];
    }

    public function styles($sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Style untuk header
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFF'));
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50');

        // Border untuk semua cell
        $sheet->getStyle('A1:J'.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Text wrap untuk semua cell
        $sheet->getStyle('A1:J'.$highestRow)->getAlignment()->setWrapText(true);

        // Auto size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Center alignment untuk kolom tertentu
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Status
        $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Bobot Soal
        $sheet->getStyle('G:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Bobot Diperoleh
        $sheet->getStyle('H:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Persentase
        $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Jenis Soal
        $sheet->getStyle('J:J')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tingkat Kesulitan

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function title(): string
    {
        return 'Pengerjaan '.$this->hasilUjian->user->name;
    }

    private function getStatusJawaban($status)
    {
        switch ($status) {
            case 'benar':
                return 'Benar';
            case 'salah':
                return 'Salah';
            case 'sebagian':
                return 'Sebagian Benar';
            case 'pending':
                return 'Pending';
            case 'tidak dijawab':
                return 'Tidak Dijawab';
            default:
                return 'Unknown';
        }
    }

    private function formatJawabanBenar($soal)
    {
        switch ($soal->jenis_soal) {
            case 'pilihan_ganda':
                return $soal->jawaban_benar;
            case 'checkbox':
                return str_replace(',', ', ', $soal->jawaban_benar);
            case 'essay':
                return 'Jawaban Essay (Subjektif)';
            case 'benar_salah':
                return $soal->jawaban_benar;
            default:
                return $soal->jawaban_benar;
        }
    }

    private function formatJawabanPeserta($jawaban)
    {
        if (empty($jawaban)) {
            return 'Tidak dijawab';
        }

        // Jika jawaban berupa pilihan ganda yang dipisahkan koma (checkbox)
        if (strpos($jawaban, ',') !== false) {
            $jawabanArray = explode(',', $jawaban);

            return implode(', ', array_map('trim', $jawabanArray));
        }

        return $jawaban;
    }

    private function limitText($text, $limit = 100)
    {
        if (strlen($text) > $limit) {
            return substr($text, 0, $limit).'...';
        }

        return $text;
    }
}
