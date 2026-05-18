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
    Schema::create('game_phrase_attempts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('game_id')->constrained()->onDelete('cascade');
        $table->foreignId('phrase_id')->constrained()->onDelete('cascade');
        $table->text('typed_phrase')->nullable();
        $table->decimal('similarity_score', 5, 2)->default(0);
        $table->integer('score_earned')->default(0);
        $table->integer('phrase_order');
        $table->boolean('is_completed')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_phrase_attempts');
    }
};
