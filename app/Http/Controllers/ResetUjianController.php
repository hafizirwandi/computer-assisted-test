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

        return view('reset-ujian.index', $data);
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

            $msg = 'Sekolah berhasil dibuat';
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
