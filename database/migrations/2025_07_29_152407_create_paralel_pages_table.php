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
        Schema::create('paralel_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('banner')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->timestamps();
        });

        // Insert default pages langsung di sini
        DB::table('paralel_pages')->insert([
            [
                'slug' => 'sejarah-lsppm',
                'title' => 'Sejarah LSP - PAMI',
                'banner' => 'images/sejarah-banner.jpg', // sesuaikan path kamu
                'content' => '<p>Sejarah LSP Pasar Modal Indonesia dimulai sejak ...</p><p>...</p>',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'latar-belakang',
                'title' => 'Latar Belakang LSP - PAMI',
                'banner' => 'images/latar-belakang-banner.jpg',
                'content' => '<p>Latar belakang pendirian LSP-PAMI adalah ...</p><p>...</p>',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paralel_pages');
    }
};
