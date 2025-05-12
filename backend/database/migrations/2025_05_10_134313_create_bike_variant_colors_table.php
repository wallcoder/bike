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
        Schema::create('bike_variant_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bike_variant_id')->constrained('bike_variants')->cascadeOnDelete();
            $table->foreignId('color_id')->constrained('colors')->nullOnDelete();
            $table->string('image');
            $table->decimal('price', 10,2);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_variant_colors');
    }
};
