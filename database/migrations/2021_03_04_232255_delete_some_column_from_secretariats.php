<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSomeColumnFromSecretariats extends Migration
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
            $table->unsignedSmallInteger('periode_tahun');
            $table->enum('periode_bulan',["01","02","03","04","05","06","07","08","09","10","11","12"]);
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
            $table->dropColumn('periode_tahun');
            $table->dropColumn('periode_bulan');
        });
    }
}
