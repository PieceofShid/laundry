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
        Schema::table('laundries', function(Blueprint $table){
            $table->string('keterangan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('catatan')->nullable();
            $table->string('menggunakan_kartu_spotting')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laundries', function(Blueprint $table){
            $table->dropColumn('keterangan');
            $table->dropColumn('tanggal_selesai');
            $table->dropColumn('catatan');
            $table->dropColumn('menggunakan_kartu_spotting');
        });
    }
};
