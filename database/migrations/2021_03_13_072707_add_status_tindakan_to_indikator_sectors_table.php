<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusTindakanToIndikatorSectorsTable extends Migration
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
            $table->unsignedTinyInteger('status_tindakan')->default(0)
                ->comment('0=> normal, \n1 = Tindak Lanjutan, 2 = Tunggakan');
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
            $table->dropColumn('status_tindakan');
        });
    }
}
