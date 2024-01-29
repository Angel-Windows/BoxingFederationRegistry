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
        Schema::create('box_federations', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('director')->nullable();
            $table->string('address')->nullable();
            $table->json('phones')->nullable();
            $table->string('email')->nullable();
            $table->string('federation')->nullable();
            $table->integer('edrpou')->nullable();
            $table->string('site')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_federations');
    }
};
