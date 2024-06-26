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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string("nama_barang");
            // $table->string("ukuran");
            // $table->string("warna");
            // $table->integer("harga");
            // $table->integer("stok");
            $table->text("deskripsi");
            // $table->enum('ukura', ['pegawai', 'admin']);
            $table->unsignedBigInteger('id_jenis');
            $table->foreign('id_jenis')->references('id')->on('jenis_barangs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
