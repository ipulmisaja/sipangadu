<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_id', 10);
            $table->timestamp('tanggal_pengajuan');
            $table->string('nomor_pengajuan');
            $table->string('nama');
            $table->unsignedBigInteger('pok_id');
            $table->unsignedBigInteger('total');
            $table->integer('volume');
            $table->string('file');
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
        Schema::dropIfExists('paket_meeting');
    }
}
