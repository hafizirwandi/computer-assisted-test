<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanUjian extends Model
{
    use HasFactory;
    protected $table = 'pengaturan_ujian';
    protected $fillable = [
        'kode_ujian',
        'waktu',
        'tanggal_ujian',
        'is_random',
        'status',
        'soal_id',
        'jlh_soal',
    ];
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
