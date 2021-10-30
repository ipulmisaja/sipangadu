<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file')->nullable();
            $table->string('catatan_file')->nullable();
            $table->boolean('has_collect')->default(false);
            $table->integer('verifikasi')->default(0);
            $table->unsignedBigInteger('verifikator')->nullable();
            $table->text('catatan_verifikator')->nullable();
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
        Schema::dropIfExists('berkas');
    }
}
