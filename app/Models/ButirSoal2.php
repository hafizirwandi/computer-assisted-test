<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirSoal2 extends Model
{
    use HasFactory;
    protected $table = 'butir_soal_2';
    protected $fillable = [
        'soal_id',
        'soal',
        'tipe_optional_jawaban',
        'jawaban_a',
        'jawaban_b',
        'jawaban_c',
        'jawaban_d',
        'jawaban_e',
        'poin_benar_a',
        'poin_benar_b',
        'poin_benar_c',
        'poin_benar_d',
        'poin_benar_e',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
