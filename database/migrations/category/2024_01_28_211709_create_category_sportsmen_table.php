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
            $table->string('name')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('arm_height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight_category')->nullable();
            $table->string('address_birth')->nullable();
            $table->json('address')->nullable();
            $table->string('passport')->nullable();
            $table->string('foreign_passport')->nullable();
            $table->integer('federation')->nullable();
            $table->integer('trainer')->nullable();
            $table->integer('sports_institutions')->nullable();
            $table->string('achievements')->nullable();
            $table->integer('rank')->nullable();
            $table->json('family')->nullable();
            $table->integer('category_sports_institutions')->nullable();
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
