<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peserta_sertifikats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('sertifikasi')->nullable();
            $table->string('no_ser')->nullable();
            $table->string('no_reg')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_exp')->nullable();
            $table->string('registrasi_nomor')->nullable();
            $table->string('tahun_registrasi')->nullable();
            $table->string('nomor_blanko')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_sertifikats');
    }
};
