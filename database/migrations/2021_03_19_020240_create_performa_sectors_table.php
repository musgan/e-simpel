<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformaSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performa_sectors', function (Blueprint $table) {
            $table->enum('periode_bulan',["01","02","03","04","05","06","07","08","09","10","11","12"]);
            $table->unsignedSmallInteger('periode_tahun');
            $table->tinyInteger('sector_id')->unsigned();
            $table->unsignedSmallInteger('total_bidang');
            $table->unsignedSmallInteger('total_bidang_success');
            $table->unsignedSmallInteger('total_tindak_lanjut');
            $table->unsignedSmallInteger('total_tindak_lanjut_success');

            $table->timestamps();

            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performa_sectors');
    }
}
