<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $data['data'] = Siswa::with('sekolah')->get();
        return view('siswa.index', $data);
    }

    public function create()
    {
        $data['sekolah'] = Sekolah::all();
        return view('siswa.create', $data);
    }
    public function edit($id)
    {
        $data['sekolah'] = Sekolah::all();
        $data['data'] = Siswa::with('sekolah')->findOrFail($id);
        return view('siswa.edit', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {


        try {
            $rules = [
                'nama' => 'required',
                'sekolah_id' => 'required',
                'kelas' => 'required',
                'status' => 'required|in:0,1,2',
                'password' => 'required',
            ];


            if ($id != null) {
                $rules['nis'] = [
                    'required',
                    Rule::unique('siswa')->ignore($id),
                ];

                $siswa = Siswa::findOrFail($id);
                $data = $request->validate($rules);
                if ($request->input('password2')) {
                    $data['password'] =  Hash::make(($request->input('password2')));
                }

                $siswa->where('id', $id)->update($data);

                $msg = 'Siswa berhasil diperbaharui';
            } else {
                $rules['nis'] = 'required|unique:siswa';
                $data = $request->validate($rules);
                $data['password'] =  Hash::make(($request->input('password')));
                $siswa = Siswa::create($data);
                $msg = 'Siswa berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        try {
            Siswa::destroy($request->input('id'));
            return back()->with('success', 'Siswa berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
