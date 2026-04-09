<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirSoal extends Model
{
    use HasFactory;
    protected $table = 'butir_soal';
    protected $fillable = ['soal_id', 'soal', 'tipe_optional_jawaban', 'jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d', 'jawaban_e', 'jawaban_benar', 'poin_benar'];
    protected $hidden = ['jawaban_benar'];
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

    public function setJawabanAAttribute($value)
    {
        $this->attributes['jawaban_a'] = str_replace(url('/'), '{APP_URL}', $value);
    }
    public function getJawabanAAttribute($value)
    {
        return str_replace('{APP_URL}', url('/'), $value);
    }

    public function setJawabanBAttribute($value)
    {
        $this->attributes['jawaban_b'] = str_replace(url('/'), '{APP_URL}', $value);
    }
    public function getJawabanBAttribute($value)
    {
        return str_replace('{APP_URL}', url('/'), $value);
    }

    public function setJawabanCAttribute($value)
    {
        $this->attributes['jawaban_c'] = str_replace(url('/'), '{APP_URL}', $value);
    }
    public function getJawabanCAttribute($value)
    {
        return str_replace('{APP_URL}', url('/'), $value);
    }

    public function setJawabanDAttribute($value)
    {
        $this->attributes['jawaban_d'] = str_replace(url('/'), '{APP_URL}', $value);
    }
    public function getJawabanDAttribute($value)
    {
        return str_replace('{APP_URL}', url('/'), $value);
    }

    public function setJawabanEAttribute($value)
    {
        $this->attributes['jawaban_e'] = str_replace(url('/'), '{APP_URL}', $value);
    }
    public function getJawabanEAttribute($value)
    {
        return str_replace('{APP_URL}', url('/'), $value);
    }
}
