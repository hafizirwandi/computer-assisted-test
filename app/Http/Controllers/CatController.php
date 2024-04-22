<?php

namespace App\Http\Controllers;

use App\Models\ButirSoal;
use App\Models\HasilUjian;
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
        $nis = Auth::guard('siswa')->user()->nis;
        $hu = HasilUjian::where('nis', $nis)
            ->where('kode_ujian', $data['ujian']->kode_ujian)->first();
        $data['hu'] = $hu;
        return view('cat.index', $data);
    }
    public function checkKodeUjian(Request $request)
    {
        $rules = [
            'kode_ujian' => 'required',
        ];
        $request->validate($rules);
        $pu = PengaturanUjian::where('kode_ujian', $request->input('kode_ujian'))
            ->where('status', '1')
            ->first();

        if ($pu) {
            $this->pemetaanSoal($pu);

            $crypt = Crypt::encryptString($pu->kode_ujian);
            return redirect(route('cat.mulai', $crypt));
        } else {
            return back()->with('error', 'Kode Ujian tidak valid!!');
        }
    }
    public function pemetaanSoal($pu)
    {
        $nis = Auth::guard('siswa')->user()->nis;
        $ps = PemetaanSoal::where('nis', $nis)
            ->where('kode_ujian', $pu->kode_ujian)
            ->get();

        if ($ps->isEmpty()) {

            if (!$pu->is_random) {
                $butirSoal  = ButirSoal::where('soal_id', $pu->soal_id)->limit($pu->jlh_soal)->get();
            } else {
                $butirSoal  = ButirSoal::where('soal_id', $pu->soal_id)->inRandomOrder()->limit($pu->jlh_soal)->get();
            }
            $i = 1;
            foreach ($butirSoal as $r) {
                $data  = [
                    'nomor' => $i++,
                    'soal_id' => $r->soal_id,
                    'butirsoal_id' => $r->id,
                    'jawaban_benar' =>  $r->jawaban_benar,
                    'poin_benar' => $r->poin_benar,
                    'kode_ujian' => $pu->kode_ujian,
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
            $nis = Auth::guard('siswa')->user()->nis;
            //cek apakah sudah ujian
            $hu = HasilUjian::where('nis', $nis)
                ->where('kode_ujian', $kode_ujian)->first();

            if ($hu) {
                return redirect(route('cat.hasil', $encryptedData));
            }
            $data['hu'] = $hu;
            $data['ku_en'] = $encryptedData;
            $data['pu'] = PengaturanUjian::where('kode_ujian', $kode_ujian)->first();

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
        $nis = Auth::guard('siswa')->user()->nis;
        $data['ps'] = PemetaanSoal::with('butirSoal')
            ->where('nis', $nis)
            ->where('nomor', $request->input('nomor'))->first();
        return view('cat.soal', $data);
    }
    public function updateJawaban(Request $request)
    {

        $pemetaanSoal = PemetaanSoal::findOrFail($request->input('id'));

        $pemetaanSoal->jawaban = $request->input('jwb');
        $pemetaanSoal->update();

        return response()->json(['message' => 'Jawaban berhasil diperbarui']);
    }
    public function hitungHasil(Request $request)
    {

        $nis = Auth::guard('siswa')->user()->nis;
        $ps = PemetaanSoal::where('nis', $nis)
            ->where('kode_ujian', $request->input('kode_ujian'))
            ->get();

        $jlh_soal = count($ps);
        $jlh_jawab_benar = 0;
        $jlh_jawab_salah = 0;
        $jlh_tidak_jawab = 0;
        $nilai = 0;
        foreach ($ps as $r) {
            if ($r->jawaban != null) {
                if ($r->jawaban == $r->jawaban_benar) {
                    $jlh_jawab_benar++;
                    $nilai += $r->poin_benar;
                } else {
                    $jlh_jawab_salah++;
                }
            } else {
                $jlh_tidak_jawab++;
            }
        }

        $where = ['nis' => $nis, 'kode_ujian' => $request->input('kode_ujian')];
        $data = [
            'nis' => $nis,
            'kode_ujian' => $request->input('kode_ujian'),
            'jlh_soal' => $jlh_soal,
            'jlh_jawab_benar' => $jlh_jawab_benar,
            'jlh_jawab_salah' => $jlh_jawab_salah,
            'jlh_tidak_jawab' => $jlh_tidak_jawab,
            'nilai' => $nilai,
        ];
        HasilUjian::updateOrCreate($where, $data);
        return response()->json(['message' => 'Jawaban berhasil disimpan']);
    }
    public function hasil($encryptedData)
    {
        try {
            $kode_ujian = Crypt::decryptString($encryptedData);
            $data['pu'] = PengaturanUjian::where('kode_ujian', $kode_ujian)->first();
            $nis = Auth::guard('siswa')->user()->nis;

            $data['hu'] = HasilUjian::where('nis', $nis)
                ->where('kode_ujian', $kode_ujian)->first();
            return view('cat.hasil', $data);
        } catch (\Exception $e) {
            $e->getMessage();
            abort('404');
        }
    }
    public function nilai()
    {
        $nis = Auth::guard('siswa')->user()->nis;
        $data['data'] = HasilUjian::with('pengaturanUjian.soal')->where('nis', $nis)->get();
        return view('cat.nilai', $data);
    }
}
