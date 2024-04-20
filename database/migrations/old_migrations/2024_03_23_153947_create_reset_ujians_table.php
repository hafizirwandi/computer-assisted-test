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
        Schema::create('reset_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ujian')->nullable();
            $table->foreign('kode_ujian')->references('kode_ujian')->on('pengaturan_ujian');
            $table->string('nis')->nullable();
            $table->foreign('nis')->references('nis')->on('siswa');
            $table->string('keterangan');
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
        Schema::dropIfExists('reset_ujian');
    }
};
