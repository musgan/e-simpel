<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUraianHawasbidToIndikatorSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indikator_sectors', function (Blueprint $table) {
            //
            $table->text('uraian_hawasbid')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indikator_sectors', function (Blueprint $table) {
            //
            $table->dropColumn('uraian_hawasbid');
        });
    }
}
