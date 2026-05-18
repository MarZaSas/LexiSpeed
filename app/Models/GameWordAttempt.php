<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameWordAttempt extends Model
{
    protected $fillable = [
        'game_id',
        'word_id',
        'typed_word',
        'is_correct',
        'is_completed',
        'errors_count',
        'penalty_time',
        'time_spent',
        'score_earned',
        'word_order',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}