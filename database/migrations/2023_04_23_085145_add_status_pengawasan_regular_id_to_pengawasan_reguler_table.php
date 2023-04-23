<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusPengawasanRegularIdToPengawasanRegulerTable extends Migration
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
            $table->string('status_pengawasan_regular_id',30)->nullable();

            $table->foreign('status_pengawasan_regular_id')->references('id')->on('status_pengawasan_regular')
                ->onDelete('set null');
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
            $table->dropForeign('pengawasan_regular_status_pengawasan_regular_id_foreign');
            $table->dropColumn('status_pengawasan_regular_id');

        });
    }
}
