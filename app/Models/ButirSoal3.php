<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirSoal3 extends Model
{
    use HasFactory;
    protected $table = 'butir_soal_3';
    protected $fillable = ['soal_id', 'soal', 'optional_jawaban', 'soal', 'pernyataan_soal', 'poin_benar'];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }

    public function setSoalAttribute($value)
    {
        $this->attributes['soal'] = str_replace(url('/'), '{APP_URL}', $value);
    }
    public function getSoalAttribute($value)
    {
        return str_replace('{APP_URL}', url('/'), $value);
    }
}
