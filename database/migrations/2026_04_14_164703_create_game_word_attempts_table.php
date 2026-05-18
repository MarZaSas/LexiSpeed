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
        Schema::create('game_word_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->string('typed_word')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->integer('errors_count')->default(0);
            $table->decimal('penalty_time', 8, 2)->default(0);
            $table->decimal('time_spent', 8, 2)->default(0);
            $table->integer('score_earned')->default(0);
            $table->integer('word_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_word_attempts');
    }
};
