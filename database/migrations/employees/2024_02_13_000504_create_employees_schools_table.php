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
        Schema::create('employees_schools', static function (Blueprint $table) {
            $table->id();
            $table->integer('school_id')->nullable()->index();
            $table->string('name');
            $table->json('address')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->date('birthday');
            $table->integer('position')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_schools');
    }
};
