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
        Schema::create('combo_plan_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combo_plan_id')->constrained('combo_plans');
            $table->foreignId('plan_id')->constrained('plans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_plan_item');
    }
};
