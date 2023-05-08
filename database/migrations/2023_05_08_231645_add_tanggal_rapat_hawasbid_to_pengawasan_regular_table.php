<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTanggalRapatHawasbidToPengawasanRegularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengawasan_regular', function (Blueprint $table) {
            //
            $table->date("tanggal_rapat_hawasbid")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengawasan_regular', function (Blueprint $table) {
            //
            $table->dropColumn("tanggal_rapat_hawasbid");
        });
    }
}
