<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    protected $fillable = [
        'text',
        'is_active',
    ];

    public function attempts()
    {
        return $this->hasMany(GamePhraseAttempt::class);
    }
}
