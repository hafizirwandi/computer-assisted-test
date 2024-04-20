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
        Schema::table('pemetaan_soal', function (Blueprint $table) {
            //

            $table->integer('soal_id')->after('nomor');
            $table->integer('butirsoal_id');
            $table->char('jawaban_benar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemetaan_soal', function (Blueprint $table) {
            //
            $table->dropColumn('butirsoal_id');
        });
    }
};
