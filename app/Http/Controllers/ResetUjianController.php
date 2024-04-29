<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\PemetaanSoal;
use App\Models\PengaturanUjian;
use Illuminate\Http\Request;
use App\Models\ResetUjian;
use App\Models\Sekolah;
use App\Models\Siswa;

class ResetUjianController extends Controller
{
    public function index()
    {
        $data['data'] = ResetUjian::with(['siswa', 'pengaturanUjian.soal'])->get();
        $data['pujian'] = PengaturanUjian::with('soal')->get();

        return view('reset-ujian.index', $data);
    }
    public function edit($id)
    {
        $data['data'] = ResetUjian::findOrFail($id);

        return view('reset-ujian.edit', $data);
    }

    public function create()
    {
        $data['pu'] = PengaturanUjian::with('soal')->get();
        $data['sekolah'] = Sekolah::all();
        return view('reset-ujian.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'kode_ujian' => 'required',
                'nis' => 'required',
                'keterangan' => 'nullable',
            ];
            $data = $request->validate($rules);

            PemetaanSoal::where('nis', $request->input('nis'))
                ->where('kode_ujian', $request->input('kode_ujian'))
                ->delete();

            HasilUjian::where('nis', $request->input('nis'))
                ->where('kode_ujian', $request->input('kode_ujian'))
                ->delete();

            ResetUjian::create($data);

            $msg = 'Data berhasil direset';
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request, $id = null)
    {
        try {
            $rules = [
                'keterangan' => 'nullable',
            ];
            $data = $request->validate($rules);



            ResetUjian::where('id', $id)->update($data);

            $msg = 'Sekolah berhasil diubah';
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        try {
            ResetUjian::destroy($request->input('id'));
            return back()->with('success', 'Reset ujian berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function resetall(Request $request)
    {
        try {


            PemetaanSoal::where('kode_ujian', $request->input('kode_ujian'))
                ->delete();

            HasilUjian::where('kode_ujian', $request->input('kode_ujian'))
                ->delete();

            $msg = 'Data berhasil direset';
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
