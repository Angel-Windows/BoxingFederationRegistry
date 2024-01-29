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
        Schema::create('category_employess_institutions', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('phones')->nullable();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->date('birthday');
            $table->string('position');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_employess_institutions');
    }
};