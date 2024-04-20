<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\NilaiCloud;
use App\Models\Siswa;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API')->plainTextToken;

            return response()->json([
                'status' => true,
                'massage' => 'Sucess',
                'data' => ['token' => $token]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => []
            ], 401);
        }
    }
    public function getNilai(Request $request)
    {
        $kode_sekolah = $request->input('kode_sekolah');
        $data = NilaiCloud::where('kode_sekolah', $kode_sekolah)->get();
        return response()->json([
            'status' => true,
            'massage' => 'Sucess',
            'data' => $data
        ], 200);
    }
    public function syncNilai(Request $request)
    {
        try {
            $data = $request->input('data');
            foreach ($data as $r) {


                $where = [
                    'kode_sekolah' => $r['kode_sekolah'],
                    'nis' => $r['nis'],
                    'kode_ujian' => $r['kode_ujian'],
                    // 'matapelajaran' => $r['matapelajaran'],
                ];

                NilaiCloud::updateOrCreate($where, $r);
            }

            return response()->json([
                'status' => true,
                'massage' => 'Sucess'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'massage' => $e->getMessage(),
            ], 400);
        }
    }
}
