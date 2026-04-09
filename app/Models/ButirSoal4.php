<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirSoal4 extends Model
{
    use HasFactory;
    protected $table = 'butir_soal_4';
    protected $fillable = ['soal_id', 'soal', 'kunci_kata', 'soal', 'jawaban', 'poin_minimal', 'poin_maksimal'];

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
