<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiCloud extends Model
{
    use HasFactory;
    protected $table = 'nilai_cloud';
    protected $fillable = [
        'kode_ujian',
        'nis',
        'jlh_soal',
        'jlh_jawab_benar',
        'jlh_jawab_salah',
        'jlh_tidak_jawab',
        'nilai',
        'nama_siswa',
        'kelas',
        'kode_sekolah',
        'nama_sekolah',
        'matapelajaran',
    ];
}
