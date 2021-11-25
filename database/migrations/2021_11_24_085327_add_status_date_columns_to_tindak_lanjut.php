<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusDateColumnsToTindakLanjut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tindak_lanjut', function (Blueprint $table) {
            $table->tinyInteger('status_kepegawaian')->default(0);
            $table->timestamp('tgl_followup_kepegawaian')->nullable();
            $table->tinyInteger('status_keuangan')->default(0);
            $table->timestamp('tgl_followup_keuangan')->nullable();
            $table->tinyInteger('status_barjas')->default(0);
            $table->timestamp('tgl_followup_barjas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tindak_lanjut', function (Blueprint $table) {
            $table->dropColumn(['status_kepegawaian', 'tgl_followup_kepegawaian']);
            $table->dropColumn(['status_keuangan', 'tgl_followup_keuangan']);
            $table->dropColumn(['status_barjas', 'tgl_followup_barjas']);
        });
    }
}
