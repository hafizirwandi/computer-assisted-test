<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $widget = [
            'sekolah' => \App\Models\Sekolah::count(),
            'siswa' => \App\Models\Siswa::count(),
            'soal' => \App\Models\Soal::count(),
            'matapelajaran' => \App\Models\Matapelajaran::count(),
            'user' => \App\Models\User::count(),
        ];
        return view('home.index', compact('widget'));
    }
    public function siswa()
    {
        return view('home.siswa');
    }
}
