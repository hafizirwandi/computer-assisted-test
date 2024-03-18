<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $sekolah = array(
            array(
                'nama' => 'SMP Negeri 4 Banda Aceh',
                'alamat' => 'H86C+G29, Peunayong, Kec. Kuta Alam, Kota Banda Aceh, Aceh',
                'telp' => '08323923398',
                'email' => 'smp4banda@gmail.com',
            ),
            array(
                'nama' => 'SMP Negeri 3 Pante Ceureumen dan SD Negeri Alue Lhok',
                'alamat' => 'C8VG+QXG, Unnamed Road, Jambak, Kec. Pantai Ceuremen, Kabupaten Aceh Barat, Aceh 23681',
                'telp' => '06327387230',
                'email' => 'smpnegeri3@gmail.com',
            ),
            array(
                'nama' => 'SMP Negeri 1 Banda Aceh',
                'alamat' => 'H827+R4V, Punge Jurong, Kec. Meuraxa, Kota Banda Aceh, Aceh 23321',
                'telp' => '06327387230',
                'email' => 'smpnegeri1@gmail.com',
            ),
        );
        foreach ($sekolah as $r) {
            Sekolah::create($r);
        }
    }
}
