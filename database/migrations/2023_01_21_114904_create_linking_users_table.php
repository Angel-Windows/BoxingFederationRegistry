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
        Schema::create('linking_users', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('type_id');
            $table->integer('refer_id');
            $table->integer('role_id');
            $table->integer('type_id');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
//            $table->foreign('type_id')->references('id')->on('class_types');
//            $table->foreign('refer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linking_users');
    }
};
