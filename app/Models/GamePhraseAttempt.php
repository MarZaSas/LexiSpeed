<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamePhraseAttempt extends Model
{
    protected $fillable = [
        'game_id',
        'phrase_id',
        'typed_phrase',
        'similarity_score',
        'score_earned',
        'phrase_order',
        'is_completed',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function phrase()
    {
        return $this->belongsTo(Phrase::class);
    }
}
