<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouletteGame extends Model
{
    protected $fillable = [
        'game_id',
        'roulette_phrase_id',
        'revealed_text',
        'used_letters',
        'current_points',
        'turn_points',
        'lives',
        'status',
    ];

    protected $casts = [
        'used_letters' => 'array',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function phrase()
    {
        return $this->belongsTo(RoulettePhrase::class, 'roulette_phrase_id');
    }
}
