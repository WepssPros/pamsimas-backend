<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeterAwalToTagihanPamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagihan__pams', function (Blueprint $table) {
            $table->string('meter_awal')->nullable();
            $table->string('meter_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagihan__pams', function (Blueprint $table) {
            $table->dropColumn('meter_awal');
            $table->dropColumn('meter_akhir');
        });
    }
}
