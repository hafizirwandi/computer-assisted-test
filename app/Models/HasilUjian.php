<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;
    protected $table = 'hasil_ujian';
    protected $fillable = [
        'kode_ujian',
        'nis',
        'jlh_soal',
        'jlh_jawab_benar',
        'jlh_jawab_salah',
        'jlh_tidak_jawab',
        'nilai',
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
    public function pengaturanUjian()
    {
        return $this->belongsTo(PengaturanUjian::class, 'kode_ujian', 'kode_ujian');
    }
}
