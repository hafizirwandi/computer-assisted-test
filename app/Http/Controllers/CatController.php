<?php

namespace App\Http\Controllers;

use App\Models\ButirSoal;
use App\Models\HasilUjian;
use App\Models\PemetaanSoal;
use Illuminate\Http\Request;
use App\Models\PengaturanUjian;
use App\Models\RefButirSoal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class CatController extends Controller
{

    public function index()
    {

        $ujian = PengaturanUjian::with('soal')->where('status', '1')->get();
        $nis = Auth::guard('siswa')->user()->nis;
        foreach ($ujian as &$r) {
            $hu = HasilUjian::where('nis', $nis)
                ->where('kode_ujian', $r->kode_ujian)->first();
            if ($hu) {
                $r['hu'] = $hu;
            }
        }
        $data['ujian'] = $ujian;
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
                $butirSoal  = RefButirSoal::where('soal_id', $pu->soal_id)->limit($pu->jlh_soal)->get();
            } else {
                $butirSoal  = RefButirSoal::where('soal_id', $pu->soal_id)->inRandomOrder()->limit($pu->jlh_soal)->get();
            }
            $i = 1;
            foreach ($butirSoal as $r) {
                $data  = [
                    'nomor' => $i++,
                    'soal_id' => $r->soal_id,
                    'ref_butirsoal_id' => $r->id,
                    'ref_butir_soal' => $r->ref_butir_soal,
                    'butirsoal_id' => $r->butir_soal_id,
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
        $ps = PemetaanSoal::with(['butirSoal', 'butirSoal2', 'butirSoal3', 'butirSoal4'])
            ->where('nis', $nis)
            ->where('kode_ujian', $request->input('kode_ujian'))
            ->where('nomor', $request->input('nomor'))->first();

        $data['ps'] = $ps;

        if ($ps->ref_butir_soal == '1') {
            return view('cat.soal', $data);
        } else if ($ps->ref_butir_soal == '2') {
            return view('cat.soal2', $data);
        } else if ($ps->ref_butir_soal == '3') {
            return view('cat.soal3', $data);
        } else if ($ps->ref_butir_soal == '4') {
            return view('cat.soal4', $data);
        }
    }
    public function updateJawaban(Request $request)
    {

        $pemetaanSoal = PemetaanSoal::with(['butirSoal', 'butirSoal2', 'butirSoal3', 'butirSoal4'])
            ->where('id', $request->input('id'))->first();


        if ($pemetaanSoal->ref_butir_soal == '1') {
            $bs = $pemetaanSoal->butirSoal;
            $poin = 0;
            if ($request->input('jwb') == $bs->jawaban_benar) {
                $poin = $bs->poin_benar;
            }
        } else if ($pemetaanSoal->ref_butir_soal == '2') {
            $bs = $pemetaanSoal->butirSoal2;
            $poin = 0;
            $jawaban = json_decode($request->input('jwb'));
            foreach ($jawaban as $r) {
                if ($r == 'a') {
                    $poin += $bs->poin_benar_a;
                } else if ($r == 'b') {
                    $poin += $bs->poin_benar_b;
                } else if ($r == 'b') {
                    $poin += $bs->poin_benar_b;
                } else if ($r == 'c') {
                    $poin += $bs->poin_benar_c;
                } else if ($r == 'd') {
                    $poin += $bs->poin_benar_d;
                } else if ($r == 'e') {
                    $poin += $bs->poin_benar_e;
                }
            }
        } else if ($pemetaanSoal->ref_butir_soal == '3') {
            $bs = $pemetaanSoal->butirSoal3;
            $soal = json_decode($bs->pernyataan_soal);
            $jawaban = json_decode($request->input('jwb'));

            $poin_benar = json_decode($bs->poin_benar);
            $ob = json_decode($bs->optional_jawaban);
            $poin = 0;
            for ($i = 0; $i < count($soal); $i++) {
                for ($j = 0; $j < count($ob); $j++) {
                    if ($jawaban[$i] == $j) {
                        $poin += $poin_benar[$i][$j];
                    }
                }
            }
        } else if ($pemetaanSoal->ref_butir_soal == '4') {
            $bs = $pemetaanSoal->butirSoal4;

            $poin = 0;
            if ($bs->kunci_kata) {
                $a = strtolower($bs->jawaban);
                $b = strtolower($request->input('jwb'));

                // Menghitung kemiripan teks menggunakan fungsi similar_text
                similar_text($a, $b, $persentase_kemiripan);

                // Menghitung poin berdasarkan persentase kemiripan
                $poin = $bs->poin_minimal + (($bs->poin_maksimal - $bs->poin_minimal) * ($persentase_kemiripan / 100));
            } else {
                if ($request->input('jwb')) {
                    $poin = $bs->poin_maksimal;
                }
            }
        }
        $pemetaanSoal->jawaban = $request->input('jwb');
        $pemetaanSoal->poin_benar = $poin;
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
        $jlh_tidak_jawab = $ps->filter(function ($item) {
            return is_null($item->jawaban) || $item->jawaban === '';
        })->count();
        $nilai = $ps->sum('poin_benar');


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
