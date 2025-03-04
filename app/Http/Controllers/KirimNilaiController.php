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
use Illuminate\Support\Str;




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
        $result = collect($hu->map(function ($item) {
            // Menyiapkan data yang ingin dienkripsi
            $array = [
                'nis' => $item->siswa->nis,
                'nama_siswa' => $item->siswa->nama,
                'kelas' => $item->siswa->kelas,
                'kode_sekolah' => $item->siswa->sekolah->kode_sekolah,
                'nama_sekolah' => $item->siswa->sekolah->nama,
                'kode_ujian' => $item->pengaturanUjian->kode_ujian,
                'matapelajaran' => $item->pengaturanUjian->soal->nama,
                'jlh_soal' => $item->pengaturanUjian->jlh_soal,
                'jlh_jawab_benar' => $item->jlh_jawab_benar,
                'jlh_jawab_salah' => $item->jlh_jawab_salah,
                'jlh_tidak_jawab' => $item->jlh_tidak_jawab,
                'nilai' => $item->nilai,
            ];

            return $array;
        }));
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
        if ($sekolah) {
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
                if ($result) {



                    $data['data'] = $result;
                    if ($request->query('ujian')) {
                        $data['data'] =  collect($result)->filter(function ($item) use ($kode_ujian) {
                            return  $item['kode_ujian'] == $kode_ujian;
                        })->values();
                    }
                } else {
                    $data['data'] = [];
                }
            }
        } else {
            $data['data'] = [];
            $data['ujian'] = PengaturanUjian::with('soal')->get();
        }
        return view('kirim-nilai.check-sync-data', $data);
    }
    public function exportData()
    {
        $sekolah = Sekolah::first();
        // dd($sekolah);
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
                'jlh_soal' => $item->pengaturanUjian->jlh_soal,
                'jlh_jawab_benar' => $item->jlh_jawab_benar,
                'jlh_jawab_salah' => $item->jlh_jawab_salah,
                'jlh_tidak_jawab' => $item->jlh_tidak_jawab,
                'nilai' => $item->nilai,
            ]);

            return encryptText($plainText, $key);
        }));
        $filename = 'export-' . $sekolah->kode_sekolah . '-' . Str::slug($sekolah->nama) . '-' . now()->format('Y-m-d_H-i-s') . '.crypt';
        Storage::put($filename, $data->implode("\n"));
        return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend();
    }
}
