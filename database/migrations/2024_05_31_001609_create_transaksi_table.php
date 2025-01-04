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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique()->nullable();
            $table->integer('bulan_tagihan');
            $table->integer('tahun_tagihan');
            $table->date('tgl_pembayaran')->nullable();
            $table->decimal('total_bayar', 15,0)->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('status_transaksi', 50)->default('Belum Lunas');
            $table->string('snap_token')->nullable();

            // $table->unsignedBigInteger('sewa_kamar_id')->nullable();
            $table->unsignedBigInteger('penghuni_id')->nullable();
            $table->timestamps();

            // $table->foreign('sewa_kamar_id')->references('id')->on('sewa_kamar')->onDelete('cascade');
            $table->foreign('penghuni_id')->references('id')->on('penghuni')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
