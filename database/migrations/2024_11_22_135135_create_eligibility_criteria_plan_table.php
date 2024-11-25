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
        Schema::create('eligibility_criteria_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eligibility_criteria_id')->constrained('eligibility_criterias');
            $table->foreignId('plan_id')->constrained('plans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eligibility_criteria_plan');
    }
};
