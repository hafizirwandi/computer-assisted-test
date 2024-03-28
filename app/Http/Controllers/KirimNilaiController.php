<?php

namespace App\Http\Controllers;


use App\Models\HasilUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Sekolah;
use App\Models\PengaturanUjian;


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
}
