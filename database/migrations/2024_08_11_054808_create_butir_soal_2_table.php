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
     * Tipe Soal dimana setiap jawaban mempunyai poin
     */
    public function up()
    {
        Schema::create('butir_soal_2', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_optional_jawaban');
            $table->longText('soal');
            $table->longText('jawaban_a')->nullable();
            $table->longText('jawaban_b')->nullable();
            $table->longText('jawaban_c')->nullable();
            $table->longText('jawaban_d')->nullable();
            $table->longText('jawaban_e')->nullable();
            $table->double('poin_benar_a')->nullable();
            $table->double('poin_benar_b')->nullable();
            $table->double('poin_benar_c')->nullable();
            $table->double('poin_benar_d')->nullable();
            $table->double('poin_benar_e')->nullable();
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
        Schema::dropIfExists('butir_soal_2');
    }
};
