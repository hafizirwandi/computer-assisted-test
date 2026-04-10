<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NilaiCloud;
use App\Models\Siswa;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $envUsername = env('API_USERNAME');
        $envPassword = env('API_PASSWORD');

        if ($username !== $envUsername || $password !== $envPassword) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => [],
                ],
                401,
            );
        }

        // Cari user berdasarkan API_USERNAME untuk generate Sanctum token
        $user = \App\Models\User::where('username', $envUsername)->first();

        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'API user not found in database',
                    'data' => [],
                ],
                500,
            );
        }

        // Hapus token lama agar tidak menumpuk
        $user->tokens()->where('name', 'API')->delete();

        $token = $user->createToken('API')->plainTextToken;

        return response()->json(
            [
                'status' => true,
                'message' => 'Success',
                'data' => ['token' => $token],
            ],
            200,
        );
    }
    public function getNilai(Request $request)
    {
        $kode_sekolah = $request->input('kode_sekolah');
        $data = NilaiCloud::where('kode_sekolah', $kode_sekolah)->get();
        return response()->json(
            [
                'status' => true,
                'massage' => 'Sucess',
                'data' => $data,
            ],
            200,
        );
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
                    'matapelajaran' => $r['matapelajaran'],
                ];

                NilaiCloud::updateOrCreate($where, $r);
            }

            return response()->json(
                [
                    'status' => true,
                    'massage' => 'Sucess',
                    'data' => $data,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'massage' => $e->getMessage(),
                ],
                400,
            );
        }
    }
}
