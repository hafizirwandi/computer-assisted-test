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
        Schema::create('pengaturan_ujian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('soal_id');
            $table->integer('waktu');
            $table->integer('jlh_soal');
            // $table->foreign('soal_id')->references('id')->on('soal');
            $table->string('kode_ujian')->unique();
            $table->date('tanggal_ujian')->nullable();
            $table->enum('is_random', ['0', '1'])->default('0');
            $table->enum('status', ['0', '1', '2'])->default('0');
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
        Schema::dropIfExists('pengaturan_ujian');
    }
};
