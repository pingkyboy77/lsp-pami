<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Tabel utama sertifikasi (parent & child)
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('sertifikasi')->onDelete('cascade');
            $table->index(['parent_id', 'is_active']);
        });

        // Tabel unit kompetensi - hanya untuk child sertifikasi
        Schema::create('unit_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sertifikasi_id');
            $table->longText('content')->nullable(); // Text editor content
            $table->timestamps();

            $table->foreign('sertifikasi_id')->references('id')->on('sertifikasi')->onDelete('cascade');
            $table->unique('sertifikasi_id'); // Satu sertifikasi hanya punya satu unit kompetensi
        });

        // Tabel persyaratan dasar - hanya untuk child sertifikasi
        Schema::create('persyaratan_dasar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sertifikasi_id');
            $table->longText('content')->nullable(); // Text editor content
            $table->timestamps();

            $table->foreign('sertifikasi_id')->references('id')->on('sertifikasi')->onDelete('cascade');
            $table->unique('sertifikasi_id'); // Satu sertifikasi hanya punya satu persyaratan dasar
        });

        // Tabel biaya uji kompetensi - hanya untuk child sertifikasi
        Schema::create('biaya_uji_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sertifikasi_id');
            $table->longText('content')->nullable(); // Text editor content
            $table->timestamps();

            $table->foreign('sertifikasi_id')->references('id')->on('sertifikasi')->onDelete('cascade');
            $table->unique('sertifikasi_id'); // Satu sertifikasi hanya punya satu biaya uji
        });
    }

    public function down()
    {
        Schema::dropIfExists('biaya_uji_kompetensi');
        Schema::dropIfExists('persyaratan_dasar');
        Schema::dropIfExists('unit_kompetensi');
        Schema::dropIfExists('sertifikasi');
    }
};
