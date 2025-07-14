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
        return $this->hasilUjians->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nama Peserta' => optional($item->user)->name,
                'Email' => optional($item->user)->email,
                'Judul Quiz' => optional($item->quiz)->judul_quiz,
                'Tanggal Ujian' => $item->tanggal_ujian,
                'Waktu Pengerjaan' => $item->waktu_pengerjaan.' menit',
                'Jumlah Benar' => $item->jumlah_benar,
                'Jumlah Salah' => $item->jumlah_salah,
                'Skor' => $item->skor,
                'Bobot Diperoleh' => $item->bobot_diperoleh,
                'Total Bobot' => $item->total_bobot,
                'Status' => $this->getStatusLabel($item->skor),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peserta',
            'Email',
            'Judul Quiz',
            'Tanggal Ujian',
            'Waktu Pengerjaan',
            'Jumlah Benar',
            'Jumlah Salah',
            'Skor',
            'Bobot Diperoleh',
            'Total Bobot',
            'Status',
        ];
    }

    public function styles($sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Style untuk header
        $sheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFF'));
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50');

        // Border untuk semua cell
        $sheet->getStyle('A1:L'.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Text wrap untuk semua cell
        $sheet->getStyle('A1:L'.$highestRow)->getAlignment()->setWrapText(true);

        // Auto size columns
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Center alignment untuk beberapa kolom
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tanggal
        $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Waktu
        $sheet->getStyle('G:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Jumlah Benar
        $sheet->getStyle('H:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Jumlah Salah
        $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Skor
        $sheet->getStyle('J:J')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Bobot Diperoleh
        $sheet->getStyle('K:K')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Total Bobot
        $sheet->getStyle('L:L')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Status

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER_00,
            'J' => NumberFormat::FORMAT_NUMBER_00,
            'K' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    private function getStatusLabel($skor)
    {
        if ($skor >= 80) {
            return 'Sangat Baik';
        } elseif ($skor >= 70) {
            return 'Baik';
        } elseif ($skor >= 60) {
            return 'Cukup';
        } elseif ($skor >= 50) {
            return 'Kurang';
        } else {
            return 'Sangat Kurang';
        }
    }
}
