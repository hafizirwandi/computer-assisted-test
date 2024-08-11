<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefButirSoal extends Model
{
    use HasFactory;
    protected $table = 'ref_butir_soal';
    protected $fillable = [
        'soal_id',
        'ref_butir_soal',
        'butir_soal_id',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
    public function butirSoal()
    {
        return $this->belongsTo(ButirSoal::class, 'butir_soal_id', 'id');
    }
    public function butirSoal2()
    {
        return $this->belongsTo(ButirSoal2::class, 'butir_soal_id', 'id');
    }
    public function butirSoal3()
    {
        return $this->belongsTo(ButirSoal3::class, 'butir_soal_id', 'id');
    }
    public function butirSoal4()
    {
        return $this->belongsTo(ButirSoal4::class, 'butir_soal_id', 'id');
    }
}
