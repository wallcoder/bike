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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('note')->nullable();
            $table->foreignId('bike_variant_color_id')->nullable()->constrained('bike_variant_colors')->cascadeOnDelete();
            $table->enum('type', ['purchase', 'servicing']);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'failed', 'absent']);
            $table->dateTime('appointment_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
