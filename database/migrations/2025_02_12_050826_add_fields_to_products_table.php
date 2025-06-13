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
        Schema::table('products', function (Blueprint $table) {
            Schema::table('products', function (Blueprint $table) {
                $table->date('tanggal')->nullable(); // Kolom untuk tanggal
                $table->string('image')->nullable(); // Kolom untuk menyimpan nama file gambar
                $table->string('source')->nullable(); // Kolom untuk sumber perolehan barang
                $table->enum('status', ['baru', 'second', 'rusak'])->default('baru'); // Kolom status barang
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
