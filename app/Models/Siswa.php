<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory, Authenticatable;
    protected $table = 'siswa';
    protected $fillable = [
        'nis',
        'nama',
        'username',
        'sekolah_id',
        'kelas',
        'password',
        'status',
    ];
    protected $hidden = [
        'password',
    ];
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }
}
