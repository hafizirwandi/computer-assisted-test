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
        Schema::create('pemetaan_soal', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor');
            $table->integer('soal_id');
            $table->integer('ref_butirsoal_id')->nullable();
            $table->integer('ref_butir_soal')->nullable();
            $table->integer('butirsoal_id')->nullable();
            $table->char('jawaban_benar')->nullable();
            $table->char('jawaban')->nullable();
            $table->double('poin_benar')->nullable();
            $table->string('kode_ujian')->nullable();
            // $table->foreign('kode_ujian')->references('kode_ujian')->on('pengaturan_ujian');
            $table->string('nis')->nullable();
            $table->foreign('nis')->references('nis')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pemetaan_soal');
    }
};
