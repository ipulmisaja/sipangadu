<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceToDetailPerjalananDinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_perjalanan_dinas', function (Blueprint $table) {
            $table->string('reference_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_perjalanan_dinas', function (Blueprint $table) {
            $table->dropColumn('reference_id');
        });
    }
}
