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
        Schema::create('sambutan_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->nullable();
            
            // Dewan Pengarah
            $table->string('pengarah_name')->nullable();
            $table->string('pengarah_title')->nullable();
            $table->string('pengarah_image')->nullable();
            $table->longText('pengarah_content')->nullable();
            
            // Dewan Pelaksana
            $table->string('pelaksana_name')->nullable();
            $table->string('pelaksana_title')->nullable();
            $table->string('pelaksana_image')->nullable();
            $table->longText('pelaksana_content')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sambutan_pages');
    }
};
