<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlokasiPerjalananDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alokasi_perjalanan_dinas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tahun');
            $table->unsignedBigInteger('pok_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alokasi_perjalanan_dinas');
    }
}
