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
        Schema::create('transaction_categories', static function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('key')->unique();
            $table->integer('type');
            $table->integer('status')->default(1);
            $table->dateTime('send_transaction_at')->nullable();
            $table->dateTime('get_transaction_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_categories');
    }
};
