<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemLingkupPengawasanIdToKesesuaianPengawasanRegularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kesesuaian_pengawasan_regular', function (Blueprint $table) {
            //
            $table->unsignedInteger("item_lingkup_pengawasan_id")->nullable();
            $table->foreign('item_lingkup_pengawasan_id')->references('id')->on('item_lingkup_pengawasan')
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
        Schema::table('kesesuaian_pengawasan_regular', function (Blueprint $table) {
            //
            $table->dropForeign('kesesuaian_pengawasan_regular_item_lingkup_pengawasan_id_foreign');
            $table->dropColumn("item_lingkup_pengawasan_id");
        });
    }
}
