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
        'ref_butirsoal_id',
        'ref_butir_soal',
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
    public function butirSoal2()
    {
        return $this->belongsTo(ButirSoal2::class, 'butirsoal_id', 'id');
    }
    public function butirSoal3()
    {
        return $this->belongsTo(ButirSoal3::class, 'butirsoal_id', 'id');
    }
    public function butirSoal4()
    {
        return $this->belongsTo(ButirSoal4::class, 'butirsoal_id', 'id');
    }
}
