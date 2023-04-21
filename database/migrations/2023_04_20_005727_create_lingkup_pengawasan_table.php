<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLingkupPengawasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table = "lingkup_pengawasan";
    public function up()
    {
        //
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments("id");
            $table->string('nama');
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
        //
        Schema::drop($this->table);
    }
}
