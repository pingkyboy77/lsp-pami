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
        Schema::create('license_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default license settings
        DB::table('license_settings')->insert([
            [
                'key' => 'license_title',
                'value' => 'Lisensi LSP Pasar Modal',
                'type' => 'text',
                'description' => 'Title for license page',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'license_description',
                'value' => 'Sertifikasi kompetensi kerja bidang pasar modal pertama di Indonesia dilaksanakan oleh Lembaga Sertifikasi Profesi Pasar Modal (LSP-PM) yang telah memperoleh lisensi dari BNSP sebagai berikut:',
                'type' => 'textarea',
                'description' => 'Description for license page',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_settings');
    }
};
