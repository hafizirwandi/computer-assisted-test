<?php

namespace App\Http\Controllers;


use App\Models\HasilUjian;
use Illuminate\Support\Facades\Http;


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
        if ($response->successful()) {
            return $response->json();
        } else {
            return null;
        }
    }
}
