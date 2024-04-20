<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\NilaiCloud;

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
            'crypt_file' => 'required|file|max:20048', // Maksimal 20MB
        ]);


        // Simpan file ke storage dengan nama asli dan ekstensi yang sama
        $fileName = Str::random(20) . '.' . $request->file('crypt_file')->getClientOriginalExtension();
        $filePath = $request->file('crypt_file')->storeAs('uploads', $fileName);


        try {

            // Mendapatkan data terenkripsi dari file
            $encryptedData = explode("\n", Storage::get($filePath));

            // Mendekripsi setiap baris dan mengurai data menjadi array
            $decryptedData = collect($encryptedData)->map(function ($encryptedRow) {
                // Mendekripsi setiap baris
                $plainText = decryptText(trim($encryptedRow), "WowAmazing123!");

                // Menguraikan data menjadi array
                return json_decode($plainText, true);
            });
            // dd($decryptedData);
            foreach ($decryptedData as $r) {
                $where = [
                    'kode_sekolah' => $r['kode_sekolah'],
                    'nis' => $r['nis'],
                    'kode_ujian' => $r['kode_ujian'],
                    // 'matapelajaran' => $r['matapelajaran'],
                ];
                NilaiCloud::updateOrCreate($where, $r);
            }


            return redirect()->back()->with('success', 'File berhasil diunggah dan data berhasil didekripsi.');
        } catch (\Exception $e) {
            Storage::delete($filePath);

            // Redirect dengan pesan error
            // return redirect()->back()->with('error', 'Gagal mendekripsi file. Pastikan file berformat .crypt dan menggunakan password yang benar.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
