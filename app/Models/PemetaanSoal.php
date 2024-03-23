<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemetaanSoal extends Model
{
    use HasFactory;
    protected $table = 'pemetaan_soal';
    protected $fillable = [
        'nomor',
        'butirsoal_id',
        'soal_id',
        'jawaban_benar',
        'jawaban',
        'poin_benar',
        'kode_ujian',
        'nis',
    ];
    protected $hidden = [
        'jawaban_benar',
    ];
    public function butirSoal()
    {
        return $this->belongsTo(ButirSoal::class, 'butirsoal_id', 'id');
    }
}
