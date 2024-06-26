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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans');
            $table->date("tanggal_sewa");
            $table->date("tanggal_akhir");
            $table->date("tanggal_kembali")->nullable();
            $table->integer("durasi");
            $table->integer("bayar")->nullable();
            $table->text("keterangan_denda")->nullable();
            // $table->integer("denda")->nullable();
            $table->integer("kurang_bayar");
            $table->integer("kembalian")->default(0);   
            $table->integer("total_harga");
            $table->integer("total_denda")->nullable();
            $table->enum("status_pengembalian",['belum','sudah']);
            $table->enum("status_konfirmasi",['belum_terkonfirmasi','sudah_terkonfirmasi','tidak_terkonfirmasi'])->default('belum_terkonfirmasi');
            $table->enum("model_bayar",['cod','tf'])->nullable();
            // $table->string("bukti_bayar")->nullable();
            $table->string("bukti_bayar")->nullable();
            $table->integer("bayar2")->nullable();
            $table->enum("model_bayar2",['cod','tf'])->nullable();
            // $table->string("bukti_bayar")->nullable();
            $table->string("bukti_bayar2")->nullable();
            $table->integer("total_ongkir")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};