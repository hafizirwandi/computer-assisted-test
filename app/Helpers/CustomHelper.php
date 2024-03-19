<?php

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (!function_exists('statusUser')) {
    function statusUser($status)
    {
        switch ($status) {
            case 1:
                return '<span class="badge bg-label-success" text-capitalized="">Active</span>';

            case 0:
                return '<span class="badge bg-label-warning" text-capitalized="">Pending</span>';

            case 2:
                return '<span class="badge bg-label-secondary" text-capitalized="">Inactive</span>';

            default:
                return '';
        }
    }
}
if (!function_exists('uploadAndReadExcel')) {
    function uploadAndReadExcel($file)
    {
        // Mendapatkan ekstensi file
        $extension = $file->getClientOriginalExtension();

        // Memeriksa apakah file adalah file Excel
        if ($extension != 'xls' && $extension != 'xlsx') {
            return ['error' => 'File harus berformat Excel (xls, xlsx)'];
        }

        // Membaca file Excel baris per baris
        $rows = [];
        $reader = IOFactory::createReaderForFile($file->getPathname());
        $spreadsheet = $reader->load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Jika ada sel yang kosong, jangan diperhitungkan
            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
            $rows[] = $rowData;
        }

        return $rows;
    }
}
