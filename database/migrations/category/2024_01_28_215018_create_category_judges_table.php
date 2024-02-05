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
        Schema::create('category_judges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('phones')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('qualification')->nullable();
            $table->string('rank')->nullable();
            $table->string('gov')->nullable();
            $table->string('school')->nullable();
            $table->json('history_works')->nullable();
            $table->dateTime('end_subscription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_judges');
    }
};
