<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->index();
            $table->string('username', 30)->index();
            $table->string('password');
            $table->boolean('ubah_password')->default('false');
            $table->string('slug');
            $table->string('email', 30)->unique()->index();
            $table->string('bps_id', 9)->index();
            $table->string('nip_id', 20)->nullable()->index();
            $table->unsignedBigInteger('pangkat_golongan_id')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('telegram_id')->unique()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
