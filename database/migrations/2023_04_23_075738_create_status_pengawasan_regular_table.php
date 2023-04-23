<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusPengawasanRegularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_pengawasan_regular', function (Blueprint $table) {
            $table->string('id',30);
            $table->string('nama');
            $table->string('text_color');
            $table->string('background_color');
            $table->string('icon');
            $table->unsignedTinyInteger('urutan');
            $table->primary('id');
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
        Schema::dropIfExists('status_pengawasan_regular');
    }
}
