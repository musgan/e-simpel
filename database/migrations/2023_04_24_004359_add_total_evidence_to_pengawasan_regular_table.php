<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalEvidenceToPengawasanRegularTable extends Migration
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
            $table->unsignedSmallInteger("total_evidence")->default(0);
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
            $table->dropColumn("total_evidence");
        });
    }
}
