<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingPeriodHawasbidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_period_hawasbids', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('periode_bulan',["01","02","03","04","05","06","07","08","09","10","11","12"]);
            $table->unsignedSmallInteger('periode_tahun');
            $table->date('start_periode_tindak_lanjut');
            $table->date('stop_periode_tindak_lanjut');
            $table->date('start_input_session');
            $table->date('stop_input_session');
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
        Schema::dropIfExists('setting_period_hawasbids');
    }
}
