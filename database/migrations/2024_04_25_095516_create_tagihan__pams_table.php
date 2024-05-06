<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTagihanPamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan__pams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pam_id');
            $table->date('tanggal_tagihan');
            $table->decimal('harga', 10, 2);
            $table->date('due_date')->nullable();
            $table->enum('status_pembayaran', ['belum dibayar', 'sudah dibayar'])->default('belum dibayar'); // Menambahkan kolom status_pembayaran

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pam_id')->references('id')->on('no_pams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihan__pams');
    }
}
