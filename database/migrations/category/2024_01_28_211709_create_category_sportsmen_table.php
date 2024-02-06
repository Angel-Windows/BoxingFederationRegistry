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
        Schema::create('category_sportsmen', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight_category')->nullable();
            $table->json('address_birth')->nullable();
            $table->json('address_address')->nullable();
            $table->string('passport')->nullable();
            $table->integer('federation')->nullable();
            $table->integer('trainer')->nullable();
            $table->string('school')->nullable();
            $table->string('achievements')->nullable();
            $table->string('rank')->nullable();
            $table->dateTime('end_subscription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_sportsmen');
    }
};
