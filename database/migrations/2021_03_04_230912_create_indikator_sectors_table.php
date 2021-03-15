<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndikatorSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikator_sectors', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('secretariat_id');
            $table->tinyInteger('sector_id')->unsigned();
            $table->boolean('evidence')->default(0)->comment('1 = memiliki gambar, 0=tidak ada gambar');
            $table->text('uraian');
            $table->timestamps();

            $table->primary('id');

            $table->foreign('sector_id')->references('id')->on('sectors')
                ->onDelete('cascade');
            $table->foreign('secretariat_id')->references('id')->on('secretariats')
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
        Schema::dropIfExists('indikator_sectors');
    }
}
