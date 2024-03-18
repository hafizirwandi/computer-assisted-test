<?php

namespace Database\Seeders;

use App\Models\Matapelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatapelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $matpel = array(
            array(
                'nama' => 'Matematika',
            ),
            array(
                'nama' => 'Bahasa Indonesia',
            ),
            array(
                'nama' => 'Bahasa Inggris',
            ),
        );
        foreach ($matpel as $r) {
            Matapelajaran::create($r);
        }
    }
}
