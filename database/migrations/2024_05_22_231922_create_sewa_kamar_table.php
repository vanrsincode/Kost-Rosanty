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
        Schema::create('sewa_kamar', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_awal_sewa');
            $table->date('tgl_selesai_sewa')->nullable();

            $table->unsignedBigInteger('kamar_id')->nullable();
            $table->unsignedBigInteger('penghuni_id');
            $table->timestamps();

            $table->foreign('kamar_id')->references('id')->on('kamar')->onDelete('SET NULL');
            $table->foreign('penghuni_id')->references('id')->on('penghuni')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_kamar');
    }
};
