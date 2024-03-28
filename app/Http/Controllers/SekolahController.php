<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    public function index()
    {
        $data['data'] = Sekolah::all();

        return view('sekolah.index', $data);
    }

    public function create()
    {
        return view('sekolah.create');
    }
    public function edit($id)
    {
        $data['data'] = Sekolah::findOrFail($id);
        return view('sekolah.edit', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {
        try {
            $rules = [
                'nama' => 'required',
                'alamat' => 'required',
                'telp' => 'required',
                'email' => 'required',
            ];
            if ($id != null) {
                $rules['kode_sekolah'] = [
                    'required',
                    Rule::unique('sekolah')->ignore($id),
                ];
                $data = $request->validate($rules);
                $sekolah = Sekolah::findOrFail($id);
                $sekolah->where('id', $id)->update($data);

                $msg = 'Sekolah berhasil diperbaharui';
            } else {
                $rules['kode_sekolah'] = 'required|unique:sekolah';
                $data = $request->validate($rules);
                $sekolah = Sekolah::create($data);
                $msg = 'Sekolah berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        try {
            Sekolah::destroy($request->input('id'));
            return back()->with('success', 'Sekolah berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
