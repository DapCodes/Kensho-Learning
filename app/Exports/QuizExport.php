<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuizExport implements FromArray, WithColumnWidths, WithHeadings, WithStyles, WithTitle
{
    protected $quiz;

    public function __construct($quiz)
    {
        $this->quiz = $quiz;
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        foreach ($this->quiz->soals as $soal) {
            $row = [
                $no++,
                $this->getQuestionType($soal->tipe),
                $soal->pertanyaan,
                $soal->bobot ?? 1,
            ];

            // Add options based on question type
            switch ($soal->tipe) {
                case 'pilihan_ganda':
                    $row = array_merge($row, [
                        $soal->pilihan_a,
                        $soal->pilihan_b,
                        $soal->pilihan_c,
                        $soal->pilihan_d,
                        $soal->pilihan_e,
                        $soal->jawaban_benar,
                        '', // Empty for essay answer
                    ]);
                    break;

                case 'benar_salah':
                    $row = array_merge($row, [
                        'Benar',
                        'Salah',
                        '',
                        '',
                        '',
                        $soal->jawaban_benar,
                        '',
                    ]);
                    break;

                case 'checkbox':
                    $row = array_merge($row, [
                        $soal->pilihan_a,
                        $soal->pilihan_b,
                        $soal->pilihan_c,
                        $soal->pilihan_d,
                        $soal->pilihan_e,
                        $soal->jawaban_benar,
                        '',
                    ]);
                    break;

                case 'essay':
                    $row = array_merge($row, [
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                    ]);
                    break;

                default:
                    $row = array_merge($row, ['', '', '', '', '', '', '']);
                    break;
            }

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tipe Soal',
            'Pertanyaan',
            'Bobot',
            'Pilihan A',
            'Pilihan B',
            'Pilihan C',
            'Pilihan D',
            'Pilihan E',
            'Jawaban Benar',
            'Essay Answer',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style for header
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style for data rows
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:K'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
        ]);

        // Center align specific columns
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D:D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J:J')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 15,  // Tipe Soal
            'C' => 50,  // Pertanyaan
            'D' => 8,   // Bobot
            'E' => 20,  // Pilihan A
            'F' => 20,  // Pilihan B
            'G' => 20,  // Pilihan C
            'H' => 20,  // Pilihan D
            'I' => 20,  // Pilihan E
            'J' => 15,  // Jawaban Benar
            'K' => 30,  // Essay Answer
        ];
    }

    public function title(): string
    {
        return 'Quiz: '.$this->quiz->judul_quiz;
    }

    private function getQuestionType($tipe)
    {
        switch ($tipe) {
            case 'pilihan_ganda':
                return 'Pilihan Ganda';
            case 'benar_salah':
                return 'Benar/Salah';
            case 'checkbox':
                return 'Checkbox';
            case 'essay':
                return 'Essay';
            default:
                return 'Unknown';
        }
    }
}
