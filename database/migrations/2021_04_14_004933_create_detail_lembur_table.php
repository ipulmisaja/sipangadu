<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailLemburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_lembur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lembur_id');
            $table->unsignedBigInteger('user_id');
            $table->string('deskripsi');
            $table->timestamp('tanggal_mulai');
            $table->timestamp('tanggal_berakhir');
            $table->float('durasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_lembur');
    }
}
