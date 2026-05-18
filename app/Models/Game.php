<?php

namespace App\Models;

use App\Models\GamePhraseAttempt;
use Illuminate\Database\Eloquent\Model;
use App\Models\GameWordAttempt;
use App\Models\User;

class Game extends Model
{
    protected $fillable = [
        'user_id',
        'difficulty',
        'total_words',
        'completed_words',
        'total_score',
        'total_errors',
        'total_penalty_time',
        'started_at',
        'ended_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attempts()
    {
        return $this->hasMany(GameWordAttempt::class);
    }
    public function phraseAttempts()
    {
        return $this->hasMany(GamePhraseAttempt::class);
    }
}
