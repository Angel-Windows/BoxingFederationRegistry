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
        Schema::create('employees_federations', static function (Blueprint $table) {
            $table->id();
            $table->string('federation_id')->nullable();
            $table->string('name');
            $table->string('city');
            $table->string('phone');
            $table->string('email');
            $table->date('birthday');
            $table->integer('position');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_federations');
    }
};
