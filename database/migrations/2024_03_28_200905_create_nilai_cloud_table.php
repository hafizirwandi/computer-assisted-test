<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_cloud', function (Blueprint $table) {

            $table->id();
            $table->string('kode_ujian');
            $table->string('nis');
            $table->integer('jlh_soal');
            $table->integer('jlh_jawab_benar');
            $table->integer('jlh_jawab_salah');
            $table->integer('jlh_tidak_jawab');
            $table->decimal('nilai', 5, 2);
            $table->string('nama_siswa');
            $table->string('kode_sekolah');
            $table->string('nama_sekolah');
            $table->string('matapelajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_cloud');
    }
};
