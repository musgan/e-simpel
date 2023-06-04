<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusPeriodeToSettingPeriodHawasbidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_period_hawasbids', function (Blueprint $table) {
            //
            $table->enum('status_periode',['A','NA'])
                ->default('NA')
                ->comment('A adalah aktif; NA adalah not active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_period_hawasbids', function (Blueprint $table) {
            //
            $table->dropColumn('status_periode');
        });
    }
}
