<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Ambil daftar semua tabel dari database (menggunakan query PostgreSQL)
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");

        // Iterasi untuk setiap tabel
        foreach ($tables as $table) {
            // Ambil nama tabel
            $tableName = $table->table_name;

            // Pastikan kita tidak menambahkan kolom pada tabel 'migrations' dan 'password_reset_tokens'
            if ($tableName != 'migrations' && $tableName != 'password_reset_tokens') {
                // Menambahkan kolom `created_by` dan `updated_by`
                Schema::table($tableName, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'created_by')) {
                        $table->unsignedBigInteger('created_by')->nullable()->after('id');
                    }
                    if (!Schema::hasColumn($table->getTable(), 'updated_by')) {
                        $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
                    }
                });
            }
        }
    }

    public function down()
    {
        // Ambil daftar semua tabel dari database (menggunakan query PostgreSQL)
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");

        // Iterasi untuk setiap tabel
        foreach ($tables as $table) {
            // Ambil nama tabel
            $tableName = $table->table_name;

            // Pastikan kita tidak menghapus kolom pada tabel 'migrations' dan 'password_reset_tokens'
            if ($tableName != 'migrations' && $tableName != 'password_reset_tokens') {
                // Menghapus kolom `created_by` dan `updated_by`
                Schema::table($tableName, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'created_by')) {
                        $table->dropColumn('created_by');
                    }
                    if (Schema::hasColumn($table->getTable(), 'updated_by')) {
                        $table->dropColumn('updated_by');
                    }
                });
            }
        }
    }
};
