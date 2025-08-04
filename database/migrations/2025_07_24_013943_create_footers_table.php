<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_footers_table.php
    public function up()
    {
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->text('map_embed')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->json('socials')->nullable();
            $table->string('certification_title')->nullable();
            $table->json('certification_links')->nullable();
            $table->string('subscription_title')->nullable();
            $table->string('subscription_text')->nullable();
            $table->string('subscription_button')->nullable();
            $table->string('subscription_url')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
