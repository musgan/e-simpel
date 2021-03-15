<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSectorIdToSecretariatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secretariats', function (Blueprint $table) {
            //
            $table->tinyInteger('sector_id')->nullable()->unsigned();

            $table->foreign('sector_id')->references('id')->on('sectors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secretariats', function (Blueprint $table) {
            //
            $table->dropForeign('secretariats_sector_id_foreign');
            $table->dropColumn('sector_id');
        });
    }
}
