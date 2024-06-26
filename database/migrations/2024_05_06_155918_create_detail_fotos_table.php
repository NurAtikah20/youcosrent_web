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
        Schema::create('detail_fotos', function (Blueprint $table) {
            $table->id();
            $table->string("keterangan");
            $table->string("foto");
            $table->unsignedBigInteger('id_barang');
            
            $table->foreign('id_barang')->references('id')->on('barangs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_fotos');
    }
};
