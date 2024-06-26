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
        Schema::create('detail_dendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transkasi');
            $table->foreign('id_transkasi')->references('id')->on('transaksis')->onDelete('cascade');
            $table->unsignedBigInteger('id_detailbarang');
            $table->foreign('id_detailbarang')->references('id')->on('detail_barangs')->onDelete('cascade');
            $table->integer('denda');
            $table->string("keterangan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_dendas');
    }
};
