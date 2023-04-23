<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengawasanRegulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengawasan_regular', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("periode_tahun");
            $table->enum('periode_bulan', ['01', '02','03','04','05','06','07','08','09','10','11','12']);
            $table->unsignedTinyInteger("sector_id");
            $table->unsignedInteger("item_lingkup_pengawasan_id");
            $table->text('temuan');
            $table->text('kriteria');
            $table->text('sebab');
            $table->text('akibat');
            $table->text('rekomendasi');
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
        Schema::dropIfExists('pengawasan_regular');
    }
}
