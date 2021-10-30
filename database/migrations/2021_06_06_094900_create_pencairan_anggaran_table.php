<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePencairanAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pencairan_anggaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->nullable();
            $table->string('reference_id')->nullable();
            $table->unsignedBigInteger('pok_id')->nullable();
            $table->string('spm')->nullable();
            $table->timestamp('spm_date')->nullable();
            $table->bigInteger('total')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('approve_ppk')->default(0);
            $table->timestamp('tanggal_approve_ppk')->nullable();
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
        Schema::dropIfExists('pencairan_anggaran');
    }
}
