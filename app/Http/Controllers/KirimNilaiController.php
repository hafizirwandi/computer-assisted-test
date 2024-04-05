<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Models\HasilUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Sekolah;
use App\Models\PengaturanUjian;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;




class KirimNilaiController extends Controller
{

    public function index()
    {
        return view('kirim-nilai.index');
    }
    public function syncData()
    {


        $token = getTokenApi();

        $hu = HasilUjian::with(['siswa.sekolah', 'pengaturanUjian.soal'])->get();
        $result = $hu->map(function ($item) {
            $item->makeHidden(['id', 'siswa', 'pengaturanUjian', 'created_at', 'updated_at']);


            $item->nis = $item->siswa->nis;
            $item->nama_siswa = $item->siswa->nama;
            $item->kelas = $item->siswa->kelas;
            $item->kode_sekolah = $item->siswa->sekolah->kode_sekolah;
            $item->nama_sekolah = $item->siswa->sekolah->nama;
            $item->kode_ujian = $item->pengaturanUjian->kode_ujian;
            $item->matapelajaran = $item->pengaturanUjian->soal->nama;

            // Mengembalikan item dengan bidang baru
            return $item;
        });
        $data['data'] = $result;

        // Sertakan token dalam header Authorization
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post(env('URL_API') . 'sync-nilai', $data);

        return $response->json();
    }
    public function checkSyncData(Request $request)
    {

        $sekolah = Sekolah::first();
        $token = getTokenApi();
        $params = [
            'kode_sekolah' => $sekolah->kode_sekolah
        ];

        // Sertakan token dalam header Authorization
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->get(env('URL_API') . 'get-nilai', $params);

        $data['data'] = [];
        $data['ujian'] = PengaturanUjian::with('soal')->get();
        $kode_ujian = $request->input('ujian');
        if ($response->successful()) {
            $result = $response->json()['data'];

            $data['data'] = $result;
            if ($request->query('ujian')) {
                $data['data'] =  collect($result)->filter(function ($item) use ($kode_ujian) {
                    return  $item['kode_ujian'] == $kode_ujian;
                })->values();
            }
        }
        return view('kirim-nilai.check-sync-data', $data);
    }
    public function exportData()
    {
        $hu = HasilUjian::with(['siswa.sekolah', 'pengaturanUjian.soal'])->get();
        $key = "WowAmazing123!";
        $data = collect($hu->map(function ($item) use ($key) {
            // Menyiapkan data yang ingin dienkripsi
            $plainText = json_encode([
                'nis' => $item->siswa->nis,
                'nama_siswa' => $item->siswa->nama,
                'kelas' => $item->siswa->kelas,
                'kode_sekolah' => $item->siswa->sekolah->kode_sekolah,
                'nama_sekolah' => $item->siswa->sekolah->nama,
                'kode_ujian' => $item->pengaturanUjian->kode_ujian,
                'matapelajaran' => $item->pengaturanUjian->soal->nama,
            ]);

            return encryptText($plainText, $key);
        }));
        $filename = 'encrypted_data_' . now()->format('Y-m-d_H-i-s') . '.crypt';
        Storage::put($filename, $data->implode("\n"));
        return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend();



        // $excelFileName = 'export-kirim-nilai.xlsx';
        // // Menggunakan Maatwebsite/Excel untuk mengekspor data ke file Excel
        // Excel::store(new ExportData($data), 'exports/' . $excelFileName, 'public');

        // // Path file Excel yang telah dibuat
        // $filePath = storage_path('app/public/exports/' . $excelFileName);

        // // Buka file Excel dengan PhpSpreadsheet
        // $spreadsheet = IOFactory::load($filePath);

        // // Mendapatkan semua sheet dalam file
        // $worksheet = $spreadsheet->getActiveSheet();

        // // Mengunci semua sel di worksheet
        // $protection = $worksheet->getProtection();
        // $protection->setSheet(true);
        // $protection->setPassword('your_password'); // Ganti 'your_password' dengan kata sandi yang Anda inginkan
        // $protection->setSort(true);
        // $protection->setInsertRows(true);
        // $protection->setFormatCells(true);

        // // Simpan perubahan ke file
        // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save($filePath);

        // // Set headers untuk unduhan
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $excelFileName . '"');
        // header('Cache-Control: max-age=0');

        // // Output file Excel ke browser
        // readfile($filePath);
    }
}
