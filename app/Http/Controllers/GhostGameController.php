<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Phrase;
use App\Models\GamePhraseAttempt;
use Illuminate\Http\Request;

class GhostGameController extends Controller
{
    public function start(Request $request)
    {
        if (!$request->user()) {
            abort(403);
        }

        $phrases = Phrase::where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        if ($phrases->count() < 3) {
            return redirect()
                ->route('game.modes')
                ->with('error', 'No hay suficientes frases activas para jugar al modo fantasma.');
        }

        $game = Game::create([
            'user_id' => $request->user()->id,
            'mode' => 'ghost',
            'difficulty' => 'medium',
            'total_words' => 3,
            'started_at' => now(),
        ]);

        foreach ($phrases as $index => $phrase) {
            GamePhraseAttempt::create([
                'game_id' => $game->id,
                'phrase_id' => $phrase->id,
                'phrase_order' => $index + 1,
            ]);
        }

        return redirect()->route('ghost.play', $game);
    }

    public function play(Request $request, Game $game)
    {
        if (!$request->user() || $game->user_id !== $request->user()->id || $game->mode !== 'ghost') {
            abort(403);
        }

        $game->load('phraseAttempts');

        $currentAttempt = $game->phraseAttempts()
            ->with('phrase')
            ->where('is_completed', false)
            ->orderBy('phrase_order')
            ->first();

        $isFinished = $currentAttempt === null;

        return view('ghost.play', compact('game', 'currentAttempt', 'isFinished'));
    }

    public function submitAttempt(Request $request, Game $game)
    {
        if (!$request->user() || $game->user_id !== $request->user()->id || $game->mode !== 'ghost') {
            abort(403);
        }

        $request->validate([
            'typed_phrase' => 'nullable|string',
        ]);

        $currentAttempt = $game->phraseAttempts()
            ->with('phrase')
            ->where('is_completed', false)
            ->orderBy('phrase_order')
            ->first();

        if (!$currentAttempt) {
            return redirect()->route('ghost.play', $game);
        }

        $original = mb_strtolower(trim($currentAttempt->phrase->text));
        $typed = mb_strtolower(trim($request->typed_phrase ?? ''));

        similar_text($original, $typed, $percent);

        $score = (int) round($percent);

        $currentAttempt->update([
            'typed_phrase' => $typed,
            'similarity_score' => round($percent, 2),
            'score_earned' => $score,
            'is_completed' => true,
        ]);

        $game->completed_words += 1;
        $game->total_score += $score;

        $remainingAttempts = $game->phraseAttempts()
            ->where('is_completed', false)
            ->count();

        if ($remainingAttempts === 0) {
            $game->ended_at = now();
        }

        $game->save();

        return redirect()->route('ghost.play', $game);
    }
}
