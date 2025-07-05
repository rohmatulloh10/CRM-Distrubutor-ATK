<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['call', 'email', 'kunjungan']);
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('activities');
    }
};

