<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('reference_id');
            $table->timestamp('tanggal_pengajuan');
            $table->integer('approve_kf')->default(0);
            $table->timestamp('tanggal_approve_kf')->nullable();
            $table->integer('approve_binagram')->default(0);
            $table->timestamp('tanggal_approve_binagram')->nullable();
            $table->integer('approve_ppk')->default(0);
            $table->timestamp('tanggal_approve_ppk')->nullable();
            $table->integer('followup_sekretaris')->default(0);
            $table->timestamp('tanggal_followup_sekretaris')->nullable();
            $table->integer('approve_kepala')->default(0);
            $table->timestamp('tanggal_approve_kepala')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan');
    }
}
