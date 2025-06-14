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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('borrower_name', 255);
            $table->integer('quantity');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->string('class', 100); // Tambahan: kolom kelas
            $table->string('phone_number', 20); // Tambahan: kolom nomor HP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
