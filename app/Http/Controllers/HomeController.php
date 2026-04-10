<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiCloud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Dashboard ke-2 untuk role online
        if ($user && $user->hasAnyRole(['admin-online', 'operator-online'])) {
            return $this->dashboardOnline();
        }

        // Dashboard lokal (admin & operator biasa)
        $widget = [
            'sekolah' => \App\Models\Sekolah::count(),
            'siswa' => \App\Models\Siswa::count(),
            'soal' => \App\Models\Soal::count(),
            'matapelajaran' => \App\Models\Matapelajaran::count(),
            'user' => \App\Models\User::count(),
        ];
        return view('home.index', compact('widget'));
    }

    private function dashboardOnline()
    {
        // Statistik ringkasan
        $widget = [
            'total_siswa' => NilaiCloud::distinct('nis')->count('nis'),
            'total_sekolah' => NilaiCloud::distinct('kode_sekolah')->count('kode_sekolah'),
            'total_ujian' => NilaiCloud::distinct('kode_ujian')->count('kode_ujian'),
            'total_mapel' => NilaiCloud::distinct('matapelajaran')->count('matapelajaran'),
            'rata_nilai' => round(NilaiCloud::avg('nilai') ?? 0, 2),
            'nilai_tertinggi' => NilaiCloud::max('nilai') ?? 0,
            'nilai_terendah' => NilaiCloud::min('nilai') ?? 0,
        ];

        // Rekap per sekolah: rata-rata nilai & jumlah siswa
        $rekapSekolah = NilaiCloud::select('kode_sekolah', 'nama_sekolah', DB::raw('COUNT(DISTINCT nis) as jumlah_siswa'), DB::raw('ROUND(AVG(nilai), 2) as rata_nilai'), DB::raw('MAX(nilai) as nilai_max'), DB::raw('MIN(nilai) as nilai_min'))->groupBy('kode_sekolah', 'nama_sekolah')->orderByDesc('rata_nilai')->get();

        // Rekap per mata pelajaran: rata-rata nilai
        $rekapMapel = NilaiCloud::select('matapelajaran', DB::raw('COUNT(DISTINCT nis) as jumlah_siswa'), DB::raw('ROUND(AVG(nilai), 2) as rata_nilai'), DB::raw('MAX(nilai) as nilai_max'), DB::raw('MIN(nilai) as nilai_min'))->groupBy('matapelajaran')->orderByDesc('rata_nilai')->get();

        // Distribusi nilai (0-20, 21-40, 41-60, 61-80, 81-100)
        $distribusi = [
            '0-20' => NilaiCloud::whereBetween('nilai', [0, 20])->count(),
            '21-40' => NilaiCloud::whereBetween('nilai', [21, 40])->count(),
            '41-60' => NilaiCloud::whereBetween('nilai', [41, 60])->count(),
            '61-80' => NilaiCloud::whereBetween('nilai', [61, 80])->count(),
            '81-100' => NilaiCloud::whereBetween('nilai', [81, 100])->count(),
        ];

        return view('home.dashboard-online', compact('widget', 'rekapSekolah', 'rekapMapel', 'distribusi'));
    }

    public function siswa()
    {
        return view('home.siswa');
    }
}
