<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirSoal3 extends Model
{
    use HasFactory;
    protected $table = 'butir_soal_3';
    protected $fillable = [
        'soal_id',
        'soal',
        'optional_jawaban',
        'soal',
        'pernyataan_soal',
        'poin_benar',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
