<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matapelajaran;

class MatapelajaranController extends Controller
{
    public function index()
    {
        $data['data'] = Matapelajaran::all();

        return view('matapelajaran.index', $data);
    }

    public function create()
    {
        return view('matapelajaran.create');
    }
    public function edit($id)
    {
        $data['data'] = Matapelajaran::findOrFail($id);
        return view('matapelajaran.edit', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {
        try {
            if ($id != null) {

                $matapelajaran = Matapelajaran::findOrFail($id);
                $data = $request->except(['_token', '_method']);
                $matapelajaran->where('id', $id)->update($data);

                $msg = 'Matapelajaran berhasil diperbaharui';
            } else {
                $data = $request->all();
                $matapelajaran = Matapelajaran::create($data);
                $msg = 'Matapelajaran berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        try {
            Matapelajaran::destroy($request->input('id'));
            return back()->with('success', 'Matapelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
