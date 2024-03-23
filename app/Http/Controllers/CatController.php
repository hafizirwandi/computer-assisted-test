<?php

namespace App\Http\Controllers;

use App\Models\ButirSoal;
use App\Models\PemetaanSoal;
use Illuminate\Http\Request;
use App\Models\PengaturanUjian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CatController extends Controller
{

    public function index()
    {
        $data['ujian'] = PengaturanUjian::with('soal')->where('status', '1')->first();

        return view('cat.index', $data);
    }
    public function checkKodeUjian(Request $request)
    {
        $rules = [
            'kode_ujian' => 'required',
        ];
        $request->validate($rules);
        $pj = PengaturanUjian::where('kode_ujian', $request->input('kode_ujian'))
            ->where('status', '1')
            ->first();
        if ($pj) {
            $this->pemetaanSoal($pj);
            $crypt = Crypt::encryptString($pj->kode_ujian);
            return redirect(route('cat.mulai', $crypt));
        } else {
            return back()->with('error', 'Kode Ujian tidak valid!!');
        }
    }
    public function pemetaanSoal($pj)
    {
        $nis = Auth::guard('siswa')->user()->nis;
        $ps = PemetaanSoal::where('nis', $nis)
            ->where('kode_ujian', $pj->kode_ujian)
            ->get();
        if (!$ps) {

            if (!$pj->is_random) {
                $butirSoal  = ButirSoal::where('soal_id', $pj->soal_id)->limit($pj->jlh_soal)->get();
            } else {
                $butirSoal  = ButirSoal::where('soal_id', $pj->soal_id)->inRandomOrder()->limit($pj->jlh_soal)->get();
            }
            $i = 1;
            foreach ($butirSoal as $r) {
                $data  = [
                    'nomor' => $i++,
                    'soal_id' => $r->soal_id,
                    'butirsoal_id' => $r->id,
                    'jawaban_benar' =>  $r->jawaban_benar,
                    'poin_benar' => $r->poin_benar,
                    'kode_ujian' => $pj->kode_ujian,
                    'nis' => $nis,
                ];
                PemetaanSoal::create($data);
            }
        }
    }
    public function mulai($encryptedData)
    {
        try {
            $kode_ujian = Crypt::decryptString($encryptedData);
            $data['pu'] = PengaturanUjian::where('kode_ujian', $kode_ujian)->first();
            $nis = Auth::guard('siswa')->user()->nis;
            $ps = PemetaanSoal::where('nis', $nis)
                ->where('kode_ujian', $kode_ujian)->get();
            $ps_jwb = PemetaanSoal::where('nis', $nis)
                ->where('kode_ujian', $kode_ujian)
                ->whereNotNull('jawaban')->get();
            $data['ps']  = $ps;
            $data['progres'] = (count($ps_jwb) / count($ps) * 100) . '%';

            return view('cat.mulai', $data);
        } catch (\Exception $e) {
            // return $e->getMessage();
            return redirect(route('cat'))->with('error', $e->getMessage());
        }
    }
    public function getSoal(Request $request)
    {
        $data['ps'] = PemetaanSoal::with('butirSoal')->where('nomor', $request->input('nomor'))->first();
        return view('cat.soal', $data);
    }
    public function updateJawaban(Request $request)
    {

        $pemetaanSoal = PemetaanSoal::findOrFail($request->input('id'));

        $pemetaanSoal->jawaban = $request->input('jwb');
        $pemetaanSoal->update();

        return response()->json(['message' => 'Jawaban berhasil diperbarui']);
    }
}
