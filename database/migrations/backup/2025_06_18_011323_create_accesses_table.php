<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // admin, sales, dll
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->boolean('can_view')->default(false);
            $table->boolean('can_create')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('accesses');
    }
};


