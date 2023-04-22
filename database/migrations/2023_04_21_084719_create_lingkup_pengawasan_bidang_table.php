<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLingkupPengawasanBidangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lingkup_pengawasan_bidang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("item_lingkup_pengawasan_id");
            $table->unsignedTinyInteger("sector_id");
            $table->timestamps();

            $table->foreign('item_lingkup_pengawasan_id')->references('id')->on('item_lingkup_pengawasan')
                ->onDelete('cascade');
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
        Schema::dropIfExists('lingkup_pengawasan_bidang');
    }
}
