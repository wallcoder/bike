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
        Schema::create('accessory_variants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('accessory_id')->constrained('accessories')->cascadeOnDelete();
            $table->float('weight');
            $table->string('material');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessory_variants');
    }
};
