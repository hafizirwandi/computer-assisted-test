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
        Schema::create('butir_soal', function (Blueprint $table) {
            $table->id();
            $table->longText('soal');
            $table->longText('jawaban_a');
            $table->longText('jawaban_b');
            $table->longText('jawaban_c');
            $table->longText('jawaban_d');
            $table->longText('jawaban_e');
            $table->string('jawaban_benar');
            $table->double('poin_benar');
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
        Schema::dropIfExists('butir_soal');
    }
};
