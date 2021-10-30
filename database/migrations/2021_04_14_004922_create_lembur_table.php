<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_id', 10);
            $table->timestamp('tanggal_pengajuan');
            $table->string('nomor_pengajuan');
            $table->string('nama');
            $table->unsignedBigInteger('pok_id');
            $table->string('nomor_spkl')->nullable();
            $table->timestamp('tanggal_spkl')->nullable();
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lembur');
    }
}
