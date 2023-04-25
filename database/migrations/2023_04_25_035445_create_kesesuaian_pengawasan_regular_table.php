<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKesesuaianPengawasanRegularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kesesuaian_pengawasan_regular', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("periode_tahun");
            $table->enum('periode_bulan', ['01', '02','03','04','05','06','07','08','09','10','11','12']);
            $table->unsignedTinyInteger("sector_id");
            $table->text("uraian");
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
        Schema::dropIfExists('kesesuaian_pengawasan_regular');
    }
}
