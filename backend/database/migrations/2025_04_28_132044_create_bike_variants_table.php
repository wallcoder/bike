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
        Schema::create('bike_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bike_id')->constrained('bikes')->cascadeOnDelete();
            $table->integer('engine_capacity');
            $table->float('mileage');
            $table->integer('transmission');
            $table->float('kerb_weight');
            $table->float('fuel_tank_capacity');
            $table->float('seat_height');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_variants');
    }
};
