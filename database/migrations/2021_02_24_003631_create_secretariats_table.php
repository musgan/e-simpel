<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretariatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secretariats', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->text('indikator');
            $table->tinyInteger('user_level_id')->unsigned();
            $table->tinyInteger('sector_id')->unsigned();
            $table->boolean('evidence')->default(0);
            $table->timestamps();

            $table->primary('id');

            $table->foreign('user_level_id')->references('id')->on('user_levels')
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
        Schema::dropIfExists('secretariats');
    }
}
