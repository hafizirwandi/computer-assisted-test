<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Matapelajaran;
use App\Models\Soal;
use App\Models\ButirSoal;
use App\Models\RefButirSoal;
use App\Models\PengaturanUjian;
use Carbon\Carbon;

class DummyTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            // 1. Create Matapelajaran
            $mapel = Matapelajaran::create([
                'nama' => 'Mapel Dummy ' . $i,
            ]);

            // 2. Create Soal (Bank Soal) for this Mapel
            $soal = Soal::create([
                'nama' => 'Bank Soal Dummy ' . $i,
                'kode_soal' => 'BS-DUMMY-' . $i . '-' . time(),
                'matapelajaran_id' => $mapel->id,
            ]);

            // 3. Create 10 Butir Soal for this Soal
            for ($j = 1; $j <= 10; $j++) {
                $butir = ButirSoal::create([
                    'soal_id' => $soal->id,
                    'soal' => '<p>Ini adalah butir soal pilihan ganda nomor ' . $j . ' untuk mata pelajaran ' . $mapel->nama . '. Manakah jawaban yang paling tepat?</p>',
                    'tipe_optional_jawaban' => 'a,b,c,d,e',
                    'jawaban_a' => '<p>Opsi Jawaban A untuk soal ' . $j . '</p>',
                    'jawaban_b' => '<p>Opsi Jawaban B untuk soal ' . $j . '</p>',
                    'jawaban_c' => '<p>Opsi Jawaban C untuk soal ' . $j . '</p>',
                    'jawaban_d' => '<p>Opsi Jawaban D untuk soal ' . $j . '</p>',
                    'jawaban_e' => '<p>Opsi Jawaban E untuk soal ' . $j . '</p>',
                    'jawaban_benar' => 'a', // Default jawaban benar A
                    'poin_benar' => 10,
                ]);

                // Create RefButirSoal connection
                RefButirSoal::create([
                    'soal_id' => $soal->id,
                    'ref_butir_soal' => '1',
                    'butir_soal_id' => $butir->id,
                ]);
            }

            // 4. Create Pengaturan Ujian referencing this Soal
            PengaturanUjian::create([
                'kode_ujian' => 'UJIAN-' . strtoupper(Str::random(5)) . '-' . $i,
                'waktu' => 60, // 60 menit
                'tanggal_ujian' => Carbon::now()->addDays($i)->format('Y-m-d'),
                'is_random' => '0',
                'status' => '1', // Status aktif
                'soal_id' => $soal->id,
                'jlh_soal' => 10,
            ]);
        }
    }
}
