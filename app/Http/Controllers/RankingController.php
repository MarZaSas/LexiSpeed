<?php

namespace App\Http\Controllers;

use App\Models\Game;

class RankingController extends Controller
{
    public function classic()
    {
        $games = Game::with('user')
            ->where('mode', 'classic')
            ->whereNotNull('ended_at')
            ->orderByDesc('total_score')
            ->orderBy('total_errors')
            ->take(20)
            ->get();

        return view('ranking.classic', compact('games'));
    }
}
