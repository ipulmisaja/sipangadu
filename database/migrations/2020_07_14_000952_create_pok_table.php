<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tahun', 4);
            $table->smallInteger('revisi');
            $table->boolean('pakai');
            $table->string('kd_departemen', 3);
            $table->string('kd_organisasi', 2);
            $table->string('kd_program', 2);
            $table->string('kd_kegiatan', 4);
            $table->string('kd_kro', 3);
            $table->string('kd_ro', 3);
            $table->string('kd_komponen', 3);
            $table->string('kd_subkomponen', 1);
            $table->string('kd_akun', 6);
            $table->unsignedInteger('kd_detail');
            $table->string('deskripsi');
            $table->float('volume')->unsigned()->nullable();
            $table->string('satuan', 30)->nullable();
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('total');
            $table->unsignedTinyInteger('unit_id')->nullable();
            $table->float('volume_realisasi')->unsigned()->default(0);
            $table->unsignedBigInteger('total_realisasi')->default(0);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pok');
    }
}
