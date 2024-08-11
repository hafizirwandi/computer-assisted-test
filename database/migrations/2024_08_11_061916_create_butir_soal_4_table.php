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
     * Soal uraian
     */
    public function up()
    {
        Schema::create('butir_soal_4', function (Blueprint $table) {
            $table->id();
            $table->enum('kunci_kata', ['0', '1'])->default('0');
            $table->longText('soal');
            $table->longText('jawaban')->nullable();
            $table->double('poin_minimal')->nullable();
            $table->double('poin_maksimal')->nullable();
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
        Schema::dropIfExists('butir_soal_4');
    }
};
