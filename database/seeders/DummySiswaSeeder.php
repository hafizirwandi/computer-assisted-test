<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Sekolah;

class DummySiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan ada instance sekolah agar kolom relasi bisa terisi
        $sekolah = Sekolah::first();
        if (!$sekolah) {
            $sekolah = Sekolah::create([
                'kode_sekolah' => 'SCH-DUMMY',
                'nama' => 'Sekolah Dummy',
                'alamat' => 'Jl. Pendidikan Dummy No. 1',
                'telp' => '08123456789',
                'email' => 'sekolah@dummy.com',
            ]);
        }

        // Generate 10 Siswa
        for ($i = 1; $i <= 10; $i++) {
            $nis = '1010' . str_pad($i, 2, '0', STR_PAD_LEFT); // Format: 101001, 101002, dst

            Siswa::create([
                'nis' => $nis,
                'nama' => 'Siswa Dummy ' . $i,
                'sekolah_id' => $sekolah->id,
                'kelas' => 'X',
                'password' => Hash::make($nis), // Password disamakan dengan NIS
                'status' => '1',
            ]);
        }
    }
}
