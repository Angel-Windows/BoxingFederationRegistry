<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('qualification_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('surname');
            $table->string('phone');
            $table->string('address');
            $table->string('honors_and_awards');
            $table->string('rewards');
            $table->string('education_place');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('qualification_id')->references('id')->on('qualifications');
            $table->foreign('federation_id')->references('id')->on('federations');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};