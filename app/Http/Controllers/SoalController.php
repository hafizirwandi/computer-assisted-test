<?php

namespace App\Http\Controllers;

use App\Models\ButirSoal;
use App\Models\Matapelajaran;
use Illuminate\Http\Request;
use App\Models\Soal;

class SoalController extends Controller
{
    public function index()
    {
        $data['data'] = Soal::all();

        return view('soal.index', $data);
    }

    public function create()
    {
        $data['matapelajaran'] = Matapelajaran::all();
        return view('soal.create', $data);
    }
    public function edit($id)
    {
        $data['data'] = Soal::findOrFail($id);
        $data['matapelajaran'] = Matapelajaran::all();
        return view('soal.edit', $data);
    }
    public function detail($id)
    {
        $data['data'] = Soal::with('butirSoal')->findOrFail($id);
        return view('soal.detail', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {

        try {
            if ($id != null) {
                $soal = Soal::findOrFail($id);
                $data = $request->except(['_token', '_method']);
                $soal->where('id', $id)->update($data);

                $msg = 'Soal berhasil diperbaharui';
            } else {
                $data = $request->all();
                Soal::create($data);
                $msg = 'Soal berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        try {
            Soal::destroy($request->input('id'));
            return back()->with('success', 'Soal berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function  createButirSoal($id)
    {
        $data['soal'] = Soal::findOrFail($id);

        return view('soal.butirsoal.create', $data);
    }
    public function  editButirSoal($id)
    {
        $data['data'] = ButirSoal::with('soal')->findOrFail($id);
        return view('soal.butirsoal.edit', $data);
    }

    public function saveOrUpdateButirSoal(Request $request, $id = null)
    {

        // dd($request->all());
        try {
            if ($id != null) {
                $butirsoal = ButirSoal::findOrFail($id);
                $data = $request->except(['_token', '_method', 'files']);
                $butirsoal->where('id', $id)->update($data);
                $msg = 'Soal berhasil diperbaharui';
            } else {
                $data = $request->all();
                ButirSoal::create($data);
                $msg = 'Soal berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroyButirSoal(Request $request)
    {
        try {
            ButirSoal::destroy($request->input('id'));
            return back()->with('success', 'Soal berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
