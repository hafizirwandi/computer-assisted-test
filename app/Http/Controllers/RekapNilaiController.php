<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\HasilUjian;
use Illuminate\Http\Request;
use App\Models\PengaturanUjian;
use App\Models\Siswa;
use Illuminate\Database\Query\JoinClause;

class RekapNilaiController extends Controller
{
    public function index(Request $request)
    {
        $data['data'] = [];
        $hu = HasilUjian::select('*')->with('pengaturanUjian.soal');
        if ($request->query('sekolah')) {
            $sekolahID = $request->input('sekolah');
            $hu->join('siswa', function (JoinClause $join) use ($sekolahID) {
                $join->on('hasil_ujian.nis', '=', 'siswa.nis')
                    ->where('siswa.sekolah_id', $sekolahID);
            });
            $result = $hu->get();
            $collection = $this->setRankValue($result);
            $data['data'] = $this->setRankValueV2($collection);
        }

        if ($request->query('ujian')) {
            $hu->where('hasil_ujian.kode_ujian', $request->input('ujian'));
            $result = $hu->get();
            $collection = $this->setRankValue($result);
            $data['data'] = $this->setRankValueV2($collection);
        }




        $data['sekolah'] = Sekolah::all();
        $data['ujian'] = PengaturanUjian::with('soal')->get();


        return view('rekap-nilai.index', $data);
    }
    public function kumulatif(Request $request)
    {
        $data['data'] = [];
        $data['ujian'] = [];
        if ($request->query('sekolah')) {
            $siswa = Siswa::where('sekolah_id', $request->input('sekolah'))->get();
            $ujian = PengaturanUjian::all();
            foreach ($siswa as &$r) {
                $temp = [];
                $total = 0;
                foreach ($ujian as $u) {
                    $hu = HasilUjian::where('nis', $r->nis)->where('kode_ujian', $u->kode_ujian)->first();
                    $temp[] = $hu;
                    $total += $hu->nilai ?? 0;
                }
                $r->ujian = $temp;
                $r->nilai = $total;
            }

            $data['ujian'] = PengaturanUjian::all();
            $collection = $this->setRankValue($siswa);
            $data['data'] = $this->setRankValueV2($collection);
        }


        $data['sekolah'] = Sekolah::all();

        return view('rekap-nilai.kumulatif', $data);
    }
    public function dashboard()
    {
        return view('rekap-nilai.dashboard');
    }
    public function setRankValue($result)
    {
        $collection = collect($result);
        $sortedCollection = $collection->sortByDesc('nilai');
        $updatedCollection = $sortedCollection->map(function ($item, $index) {
            // Add a new 'rank' property to each item
            $item->rank = $index + 1; // Assign rank based on position in sorted collection
            return $item;
        });
        return $updatedCollection;
    }
    public function setRankValueV2($result)
    {

        $rank = 1;
        $prevNilai = null;
        $rankedCollection = $result->map(function ($item) use (&$rank, &$prevNilai) {
            if ($item->nilai != $prevNilai) {
                $item->rank2 = $rank;
            } else {
                $item->rank2 = $rank - 1;
            }
            $prevNilai = $item->nilai;
            $rank++;
            return $item;
        });
        return $rankedCollection;
    }
}
