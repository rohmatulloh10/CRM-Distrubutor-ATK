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
         Schema::create('sales_matrix', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
                $table->string('bulan', 2); // MM (contoh: 07)
                $table->string('tahun', 4); // YYYY (contoh: 2025)

                $table->integer('jumlah_toko')->default(0);       // Jumlah toko yang ditangani
                $table->integer('jumlah_prospek')->default(0);    // Jumlah prospek
                $table->integer('jumlah_aktivitas')->default(0);  // Jumlah aktivitas
                $table->integer('jumlah_closing')->default(0);    // Jumlah closing

                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->unique(['user_id', 'bulan', 'tahun']); // Hindari data ganda
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_matrix');
    }
};
