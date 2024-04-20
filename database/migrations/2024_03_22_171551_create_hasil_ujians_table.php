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
        Schema::create('hasil_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ujian')->nullable();
            // $table->foreign('kode_ujian')->references('kode_ujian')->on('pengaturan_ujian');
            $table->string('nis')->nullable();
            $table->foreign('nis')->references('nis')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('jlh_soal');
            $table->integer('jlh_jawab_benar');
            $table->integer('jlh_jawab_salah');
            $table->integer('jlh_tidak_jawab');
            $table->decimal('nilai', 5, 2);
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
        Schema::dropIfExists('hasil_ujian');
    }
};
