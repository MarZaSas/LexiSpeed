<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoulettePhrase extends Model
{
    protected $fillable = [
        'text',
        'is_active',
    ];

    public function rouletteGames()
    {
        return $this->hasMany(RouletteGame::class);
    }
}
