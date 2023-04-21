<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemLingkupPengawasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table = "item_lingkup_pengawasan";
    public function up()
    {
        //
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("lingkup_pengawasan_id");
            $table->string('nama');
            $table->timestamps();

            $table->foreign('lingkup_pengawasan_id')->references('id')->on('lingkup_pengawasan')
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
        //
        Schema::drop($this->table);
    }
}
