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
        Schema::create('category_employess_schools', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('phones')->nullable();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->integer('school');
            $table->date('birthday');
            $table->string('address');
            $table->string('position');
            $table->date('end_subscription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_employess_schools');
    }
};
