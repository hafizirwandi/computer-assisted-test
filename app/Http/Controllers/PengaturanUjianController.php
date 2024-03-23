<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanUjian;
use App\Models\Soal;
use Illuminate\Validation\Rule;

class PengaturanUjianController extends Controller
{
    public function index()
    {
        $data['data'] = PengaturanUjian::with('soal')->get();

        return view('pengaturan-ujian.index', $data);
    }

    public function create()
    {
        $data['soal'] = Soal::all();
        return view('pengaturan-ujian.create', $data);
    }
    public function edit($id)
    {
        $data['soal'] = Soal::all();
        $data['data'] = PengaturanUjian::with('soal')->findOrFail($id);
        return view('pengaturan-ujian.edit', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {
        try {
            $rules = [
                'soal_id' => 'required|exists:soal,id',
                'jlh_soal' => 'required|numeric',
                'waktu' => 'required|numeric',
                'tanggal_ujian' => 'required|date',
                'status' => 'required|in:0,1',
                'is_random' => 'required|in:0,1',
            ];
            if ($id != null) {

                $rules['kode_ujian'] = [
                    'required',
                    Rule::unique('pengaturan_ujian')->ignore($id),
                ];
                $pengaturan_ujian = PengaturanUjian::findOrFail($id);
                $data = $request->validate($rules);
                $pengaturan_ujian->where('id', $id)->update($data);
                $this->updateStatusPengaturanUjian($id, $data['status']);

                $msg = 'Pengaturan ujian berhasil diperbaharui';
            } else {
                $rules['kode_ujian'] = 'required|unique:pengaturan_ujian';
                $data = $request->validate($rules);
                $pengaturan_ujian = PengaturanUjian::create($data);
                $this->updateStatusPengaturanUjian($pengaturan_ujian->id, $data['status']);
                $msg = 'Pengaturan ujian berhasil dibuat';
            }



            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return $e->getMessage();
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        try {
            PengaturanUjian::destroy($request->input('id'));
            return back()->with('success', 'Pengaturan ujian berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatusPengaturanUjian($id, $status)
    {
        if ($status == 1) {
            PengaturanUjian::where('id', '!=', $id)->update(['status' => '0']);
        }
    }
}
