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
        Schema::create('category_sports_institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('phones')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->integer('edrpou')->nullable();
            $table->string('director')->nullable();
            $table->string('site')->nullable();
            $table->date('end_subscription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_sports_institutions');
    }
};
