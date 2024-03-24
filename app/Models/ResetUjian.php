<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetUjian extends Model
{
    use HasFactory;
    protected $table = 'reset_ujian';
    protected $fillable = [
        'nis',
        'kode_ujian',
        'keterangan'
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
