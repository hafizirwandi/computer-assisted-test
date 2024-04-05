<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class xxx implements FromView, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    var $data = array(), $table_row, $lastColumn = 'D';
    var $view = '';
    public function __construct($data, $view)
    {
        $this->view = $view;
        $this->data = $data;
        $this->table_row =  3;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headerStyle = [
                    'font' => [
                        'bold' => true,
                    ]
                ];
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                    ],
                ];
                $cell_range = "A2:" . $this->lastColumn . $this->table_row;
                $event->sheet->getDelegate()->mergeCells('A1:' . $this->lastColumn . '1');
                $event->sheet->getDelegate()->getStyle('A1:A1')->applyFromArray($headerStyle);
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->getDelegate()->getStyle('A2:D2')->applyFromArray($headerStyle);
                $event->sheet->getDelegate()->getStyle($cell_range)->applyFromArray($styleArray);
            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
            'L' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function view(): View
    {
        return view($this->view, $this->data);
    }
}
