<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = 'soal';
    protected $fillable = [
        'nama',
        'kode_soal',
        'matapelajaran_id',
    ];
    public function matapelajaran()
    {
        return $this->belongsTo(Matapelajaran::class, 'matapelajaran_id', 'id');
    }
    public function refButirSoal()
    {
        return $this->hasMany(RefButirSoal::class, 'soal_id', 'id');
    }
}
