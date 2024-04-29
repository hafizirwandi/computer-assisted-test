<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {

        $data['data'] = [];
        $siswa = Siswa::query();
        $data['kelas'] = [];
        $data['sekolah'] = Sekolah::all();
        if ($request->query('sekolah')) {
            $siswa->where('sekolah_id', $request->query('sekolah'));
            $data['data'] = $siswa->get();
            $data['kelas'] = Siswa::select('kelas')
                ->where('sekolah_id', $request->query('sekolah'))
                ->groupBy('kelas')
                ->get();
        }
        if ($request->query('kelas')) {
            $siswa->where('kelas', $request->query('kelas'));
            $data['data'] = $siswa->get();
        }



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
                // 'username' => 'required',
                'sekolah_id' => 'required',
                'kelas' => 'required',
                'status' => 'required|in:0,1,2',
                // 'password' => 'required',
            ];


            if ($id != null) {
                $rules['nis'] = [
                    'required',
                    Rule::unique('siswa')->ignore($id),
                ];

                $siswa = Siswa::findOrFail($id);
                $data = $request->validate($rules);
                // if ($request->input('password2')) {
                //     $data['password'] =  Hash::make(($request->input('password2')));
                // }
                $data['password'] =  Hash::make(($request->input('nis')));

                $siswa->where('id', $id)->update($data);

                $msg = 'Siswa berhasil diperbaharui';
            } else {
                $rules['nis'] = 'required|unique:siswa';
                $data = $request->validate($rules);
                // $data['password'] =  Hash::make(($request->input('password')));
                $data['password'] =  Hash::make(($request->input('nis')));
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
    public function import()
    {
        $data['sekolah'] = Sekolah::all();
        return view('siswa.import', $data);
    }

    public function uploadImportFile(Request $request)
    {
        try {
            $request->validate([
                'sekolah_id' => 'required',
                'excel_file' => 'required|mimes:xls,xlsx|max:10048', // Memeriksa bahwa file adalah Excel dengan maksimum ukuran 10MB
            ]);

            $file = $request->file('excel_file');

            $importedData = uploadAndReadExcel($file);

            for ($i = 1; $i < count($importedData); $i++) {
                $data = $importedData[$i];
                try {
                    $newStudent = [
                        'nis' => $data[0],
                        'nama' => $data[1],
                        // 'username' => $data[2],
                        'password' => Hash::make($data[0]),
                        'status' => '1',
                        'kelas' => $data[2],
                        'sekolah_id' => $request->input('sekolah_id'),
                    ];

                    Siswa::updateOrCreate(['nis' => $newStudent['nis']], $newStudent);
                } catch (\Exception $e) {
                    // Menangkap kesalahan dan menyimpannya dalam array
                    $errors[] = [
                        'row' => $i + 1, // Nomor baris (ditambah 1 karena array dimulai dari 0)
                        'message' => $e->getMessage(), // Pesan kesalahan
                    ];
                }
            }


            return back()->with('success', 'Data Berhasil di Import');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function getKelas(Request $request)
    {
        $sekolah_id = $request->input('sekolah_id');

        $kelas = Siswa::select('kelas')
            ->where('sekolah_id', $sekolah_id)
            ->groupBy('kelas')
            ->get();

        return response()->json($kelas);
    }
    public function getSiswa(Request $request)
    {
        $sekolah_id = $request->input('sekolah_id');

        $siswa = Siswa::where('sekolah_id', $sekolah_id)
            ->get();

        return response()->json($siswa);
    }
    public function profileSiswa()
    {
        $data['data'] = Siswa::with('sekolah')->find(Auth::guard('siswa')->id());
        //dd($data);
        return view('siswa.profile', $data);
    }
}
