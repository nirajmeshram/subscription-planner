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
        Schema::create('eligibility_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age_less_than');
            $table->integer('age_greater_than');
            $table->unsignedBigInteger('last_login_days_ago');
            $table->decimal('income_less_than', 15, 2);
            $table->decimal('income_greater_than', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eligibility_criterias');
    }
};
