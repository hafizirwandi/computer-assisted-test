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
        Schema::table('butir_soal', function (Blueprint $table) {
            $table->string('tipe_optional_jawaban')->after('soal');
            // $table->string('jawaban_a')->nullable()->change();
            // $table->string('jawaban_b')->nullable()->change();
            // $table->string('jawaban_c')->nullable()->change();
            // $table->string('jawaban_d')->nullable()->change();
            // $table->string('jawaban_e')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('butir_soal', function (Blueprint $table) {
            $table->dropColumn('tipe_optional_jawaban');
            // $table->string('jawaban_a')->nullable(false)->change();
            // $table->string('jawaban_b')->nullable(false)->change();
            // $table->string('jawaban_c')->nullable(false)->change();
            // $table->string('jawaban_d')->nullable(false)->change();
            // $table->string('jawaban_e')->nullable(false)->change();
        });
    }
};
