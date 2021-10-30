<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPerjalananDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_perjalanan_dinas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('perjadin_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tujuan');
            $table->timestamp('tanggal_berangkat');
            $table->timestamp('tanggal_kembali');
            $table->string('catatan')->nullable();
            $table->integer('mail_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_perjalanan_dinas');
    }
}
