<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matapelajaran extends Model
{
    use HasFactory;
    protected $table = 'matapelajaran';
    protected $fillable = [
        'nama',
    ];

    public function soal()
    {
        return $this->hasMany(Soal::class, 'matapelajaran_id', 'id');
    }
}
