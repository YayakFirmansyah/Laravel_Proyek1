<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->string('nama_barang');
            $table->integer('harga');
            $table->string('status')->default('tersedia');
            $table->string('keterangan');
            $table->string('foto');
            $table->timestamps();
            
            $table->foreign('kategori_id')->references('id')->on('kategori');
            $table->foreign('transaksi_id')->references('id')->on('shop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
