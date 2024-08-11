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
     * Setiap soal punya beberapa pernyataan yang bisa bernilai Benar atau Salah
     */
    public function up()
    {
        Schema::create('butir_soal_3', function (Blueprint $table) {
            $table->id();
            $table->json('optional_jawaban'); //['benar','salah']
            $table->longText('soal');
            $table->json('pernyataan_soal')->nullable(); //['soal1','soal2']
            $table->json('poin_benar')->nullable(); //['poinbenar1','poinbenar2']
            $table->unsignedBigInteger('soal_id');
            $table->foreign('soal_id')->references('id')->on('soal');
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
        Schema::dropIfExists('butir_soal_3');
    }
};
