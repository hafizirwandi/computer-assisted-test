<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
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
if (!function_exists('statusIsRandomSoal')) {
    function statusIsRandomSoal($status)
    {
        switch ($status) {
            case 1:
                return '<span class="badge bg-label-success" text-capitalized="">Active</span>';

            case 0:
                return '<span class="badge bg-label-secondary" text-capitalized="">Pending</span>';



            default:
                return '';
        }
    }
}
if (!function_exists('statusGeneral')) {
    function statusGeneral($status)
    {
        switch ($status) {
            case 1:
                return '<span class="badge bg-label-success" text-capitalized="">Active</span>';

            case 0:
                return '<span class="badge bg-label-secondary" text-capitalized="">Pending</span>';



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

if (!function_exists('getTokenApi')) {
    function getTokenApi()
    {

        if (!session('api_token')) {
            $response = Http::post(env('URL_API') . 'login', [
                'username' => 'admin',
                'password' => 'admin',
            ]);
            if ($response->successful()) {
                $token = $response->json()['data']['token'];
                session(['api_token' => $token]);
                return $token;
            } else {

                return null;
            }
        } else {
            return session('api_token');
        }
    }
}

if (!function_exists('encryptText')) {
    function encryptText($plainText, $key)
    {
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encryptedText = openssl_encrypt($plainText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encryptedText);
    }
}

if (!function_exists('decryptText')) {
    function decryptText($encryptedText, $key)
    {
        $encryptedText = base64_decode($encryptedText);
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = substr($encryptedText, 0, $ivLength);
        $encryptedText = substr($encryptedText, $ivLength);
        return openssl_decrypt($encryptedText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}
