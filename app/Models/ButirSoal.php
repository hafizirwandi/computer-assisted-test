<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirSoal extends Model
{
    use HasFactory;
    protected $table = 'butir_soal';
    protected $fillable = [
        'soal_id',
        'soal',
        'jawaban_a',
        'jawaban_b',
        'jawaban_c',
        'jawaban_d',
        'jawaban_e',
        'jawaban_benar',
        'poin_benar',
    ];
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
