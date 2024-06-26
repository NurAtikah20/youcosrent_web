<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transkasi');
            $table->foreign('id_transkasi')->references('id')->on('transaksis')->onDelete('cascade');
            $table->unsignedBigInteger('id_detailbarang');
            $table->foreign('id_detailbarang')->references('id')->on('detail_barangs');
            $table->integer('qty');
            $table->integer('subtotal_harga');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
