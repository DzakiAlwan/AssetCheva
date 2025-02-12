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
        Schema::create('peminjams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('product_id');
            $table->string('jumlah', 100);
            $table->date('pengembalian');
            $table->timestamps();

            $table->foreign('product_id')-> references('id')-> on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
