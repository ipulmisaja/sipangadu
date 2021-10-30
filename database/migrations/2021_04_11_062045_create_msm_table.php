<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('reference_id', 10);
            $table->json('pok_id');
            $table->text('catatan');
            $table->string('file');
            $table->timestamp('tanggal_pengajuan');
            $table->integer('approve_kf')->default(0);
            $table->timestamp('tanggal_approve_kf')->nullable();
            $table->integer('approve_binagram')->default(0);
            $table->timestamp('tanggal_approve_binagram')->nullable();
            $table->integer('approve_ppk')->default(0);
            $table->timestamp('tanggal_approve_ppk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msm');
    }
}
