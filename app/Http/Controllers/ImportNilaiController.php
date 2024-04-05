<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportNilaiController extends Controller
{
    public function index()
    {
        return view('import-nilai.index');
    }
    public function upload(Request $request)
    {

        // Validasi file yang diunggah
        $request->validate([
            'crypt_file' => 'required|file|max:2048', // Maksimal 2MB
        ]);


        // Simpan file ke storage dengan nama asli dan ekstensi yang sama
        $fileName = Str::random(20) . '.' . $request->file('crypt_file')->getClientOriginalExtension();
        $filePath = $request->file('crypt_file')->storeAs('uploads', $fileName);


        try {

            $str = "ZsfDDf+6lEnsqwGQ2inT3nj48H76lCQpd/fASyZI4tMbueiY9Zt1HzIDW7buIDFgXkLod8W2OEDElNsX6R6oje/mJ2ZqkOVWs4BHfT4yZ1r3soB4/Upd8t6fyU3NFnkx4k4WA0cNwknmu1MZM9EYzjB6ETjb6Cyd0hCblHurVBqd07vfw429oxMZxFb4TqO5/zHzAWBYVtvYHu4ANZl2zENBv4x69Zu9bcFcegKv2ps9YH2sVmpE4xh/3+3B/BqF";
            $key = "WowAmazing123!";

            // Mendapatkan data terenkripsi dari file
            $encryptedData = explode("\n", Storage::get($filePath));

            // Mendekripsi setiap baris dan mengurai data menjadi array
            $decryptedData = collect($encryptedData)->map(function ($encryptedRow) {
                // Mendekripsi setiap baris
                $plainText = decryptText(trim($encryptedRow), "WowAmazing123!");

                // Menguraikan data menjadi array
                return json_decode($plainText, true);
            });
            dd($decryptedData);


            // dd(decryptText($str, $key));


            // Lakukan operasi lainnya sesuai kebutuhan, misalnya menyimpan ke database
            // $decryptedData adalah koleksi (collection) dari data yang telah didekripsi

            // Redirect atau tampilkan pesan sukses
            return redirect()->back()->with('success', 'File berhasil diunggah dan data berhasil didekripsi.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan
            // Hapus file yang gagal dibuka
            Storage::delete($filePath);

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Gagal mendekripsi file. Pastikan file berformat .crypt dan menggunakan password yang benar.');
        }
    }
}
