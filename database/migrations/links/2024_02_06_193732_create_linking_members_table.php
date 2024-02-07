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
        Schema::create('linking_members', static function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->index();
            $table->integer('category_type')->index();
            $table->integer('member_id')->index();
            $table->integer('member_type')->index();
            $table->integer('type')->index();
            $table->string('role');
            $table->integer('status')->default(1);
            $table->date('date_start_at')->nullable();
            $table->date('date_end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linking_members');
    }
};
