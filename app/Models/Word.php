<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'text',
        'difficulty',
        'length',
        'is_active',
    ];

    public function attempts()
    {
        return $this->hasMany(GameWordAttempt::class);
    }
}
