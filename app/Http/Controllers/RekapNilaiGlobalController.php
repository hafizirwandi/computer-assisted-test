<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\HasilUjian;
use App\Models\NilaiCloud;
use Illuminate\Http\Request;
use App\Models\PengaturanUjian;
use App\Models\Siswa;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Validation\Rule;

class RekapNilaiGlobalController extends Controller
{
    public function index(Request $request)
    {
        $data['data'] = [];
        $hu = HasilUjian::select('*')->with('pengaturanUjian.soal');
        if ($request->query('sekolah')) {

            $result = NilaiCloud::where('kode_sekolah', $request->input('sekolah'))->get();
            $data['data'] = $result;
            // $collection = $this->setRankValue($result);
            // $data['data'] = $this->setRankValueV2($collection);
        }

        if ($request->query('ujian')) {
            $result = NilaiCloud::where('kode_ujian', $request->input('ujian'))->get();
            $data['data'] = $result;

            // $collection = $this->setRankValue($result);
            // $data['data'] = $this->setRankValueV2($collection);
        }

        $data['sekolah'] = NilaiCloud::select('nama_sekolah', 'kode_sekolah')->groupBy('kode_sekolah', 'nama_sekolah')->get();
        $data['ujian'] = NilaiCloud::select('matapelajaran', 'kode_ujian')->groupBy('kode_ujian', 'matapelajaran')->get();


        return view('rekap-nilai-global.index', $data);
    }
    public function kumulatif(Request $request)
    {
        $data['data'] = [];
        $data['ujian'] = [];
        if ($request->query('sekolah')) {
            $siswa = NilaiCloud::select('nama_siswa', 'nis', 'kelas')->where('kode_sekolah', $request->input('sekolah'))->groupBy('nama_siswa', 'nis', 'kelas')->get();
            $ujian = NilaiCloud::select('matapelajaran', 'kode_ujian')->groupBy('kode_ujian', 'matapelajaran')->get();
            foreach ($siswa as &$r) {
                $temp = [];
                $total = 0;
                foreach ($ujian as $u) {
                    $hu = NilaiCloud::where('nis', $r->nis)->where('kode_ujian', $u->kode_ujian)->first();
                    $temp[] = $hu;
                    $total += $hu->nilai ?? 0;
                }
                $r->ujian = $temp;
                $r->nilai = $total;
            }

            $data['ujian'] = $ujian;
            $data['data'] = $siswa;
            // $collection = $this->setRankValue($siswa);
            // $data['data'] = $this->setRankValueV2($collection);
        }


        $data['sekolah'] = NilaiCloud::select('nama_sekolah', 'kode_sekolah')->groupBy('kode_sekolah', 'nama_sekolah')->get();

        return view('rekap-nilai-global.kumulatif', $data);
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

    public function create()
    {
        return view('rekap-nilai-global.create');
    }
    public function edit($id)
    {
        $data['data'] = NilaiCloud::find($id);
        return view('rekap-nilai-global.edit', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {

        // dd($request->all());
        try {

            $rules = [
                'kode_sekolah' => 'required',
                'nama_sekolah' => 'required',
                'kode_ujian' => 'required',
                'nis' => 'required',
                'jlh_soal' => 'required|numeric',
                'jlh_jawab_benar' => 'required|numeric',
                'jlh_jawab_salah' => 'required|numeric',
                'jlh_tidak_jawab' => 'required|numeric',
                'nilai' => 'required|numeric',
                'nama_siswa' => 'required',
                'kelas' => 'required',
                'matapelajaran' => 'required',
            ];
            if ($id != null) {
                $nilai = NilaiCloud::findOrFail($id);
                $data = $request->validate($rules);
                $nilai->where('id', $id)->update($data);

                $msg = 'Rekap Nilai Global berhasil diperbaharui';
            } else {
                $data = $request->validate($rules);
                NilaiCloud::create($data);
                $msg = 'Rekap Nilai Global berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        try {
            NilaiCloud::destroy($request->input('id'));
            return back()->with('success', 'Nilai berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function editAll($sekolah)
    {
        $data['data'] = NilaiCloud::where('kode_sekolah', $sekolah)->get();
        return view('rekap-nilai-global.edit-all', $data);
    }
    public function saveEditAll(Request $request, $id = null)
    {

        try {

            $rules = [
                'kode_sekolah' => 'required',
                'nama_sekolah' => 'required',
                'kode_ujian' => 'required',
                'nis' => 'required',
                'jlh_soal' => 'required|numeric',
                'jlh_jawab_benar' => 'required|numeric',
                'jlh_jawab_salah' => 'required|numeric',
                'jlh_tidak_jawab' => 'required|numeric',
                'nilai' => 'required|numeric',
                'nama_siswa' => 'required',
                'kelas' => 'required',
                'matapelajaran' => 'required',
            ];

            $nilai = NilaiCloud::findOrFail($id);
            $data = $request->validate($rules);
            $nilai->where('id', $id)->update($data);

            $msg = 'Rekap Nilai Global berhasil diperbaharui';
            return response()->json(['message' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function deleteAll($sekolah)
    {
        $result = NilaiCloud::where('kode_sekolah', $sekolah)->get();
        if ($result->isEmpty()) {
            return redirect()->route('rekap-nilai-global');
        }
        $data['data'] = $result;
        return view('rekap-nilai-global.delete-all', $data);
    }
    public function destroyAll(Request $request)
    {
        try {
            foreach ($request->input('selectedItems') as $id) {
                NilaiCloud::destroy($id);
            }

            $msg = 'Rekap Nilai Global berhasil dihapus';
            return response()->json(['message' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
