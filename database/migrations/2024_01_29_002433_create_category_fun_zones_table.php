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
        Schema::create('category_fun_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('phones')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('director')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_fun_zones');
    }
};
