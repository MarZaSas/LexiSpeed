<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Word;
use App\Models\GameWordAttempt;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function difficulty()
    {
        return view('game.difficulty');
    }

    public function start(Request $request)
    {
        if (!$request->user()) {
            abort(403);
        }

        $request->validate([
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $difficulty = $request->difficulty;

        // nº palabras según dificultad
        $totalWords = match ($difficulty) {
            'easy' => 10,
            'medium' => 15,
            'hard' => 20,
        };

        // coger palabras aleatorias activas
        $words = Word::where('difficulty', $difficulty)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take($totalWords)
            ->get();

        // control de seguridad
        if ($words->count() < $totalWords) {
            return redirect()->route('game.difficulty')
                ->with('error', 'No hay suficientes palabras activas.');
        }

        // crear partida
        $game = Game::create([
            'user_id' => $request->user()->id,
            'difficulty' => $difficulty,
            'total_words' => $totalWords,
            'started_at' => now(),
        ]);

        // guardar palabras de la partida
        foreach ($words as $index => $word) {
            GameWordAttempt::create([
                'game_id' => $game->id,
                'word_id' => $word->id,
                'word_order' => $index + 1,
            ]);
        }

        return redirect()->route('game.play', $game);
    }

    public function play(Request $request, Game $game)
    {
        if (!$request->user() || $game->user_id !== $request->user()->id) {
            abort(403);
        }

        $currentAttempt = $game->attempts()
            ->with('word')
            ->where('is_completed', false)
            ->orderBy('word_order')
            ->first();

        $isFinished = $currentAttempt === null;

        $game->load('attempts');

        return view('game.play', compact('game', 'currentAttempt', 'isFinished'));
    }

    public function submitAttempt(Request $request, Game $game)
    {
        if (!$request->user() || $game->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'typed_word' => 'nullable|string',
            'time_spent' => 'required|numeric|min:0',
            'errors_count' => 'required|integer|min:0',
            'penalty_time' => 'required|numeric|min:0',
        ]);

        $currentAttempt = $game->attempts()
            ->with('word')
            ->where('is_completed', false)
            ->orderBy('word_order')
            ->first();

        if (!$currentAttempt) {
            return redirect()->route('game.play', $game);
        }

        $typedWord = strtolower(trim($request->typed_word ?? ''));
        $correctWord = strtolower($currentAttempt->word->text);
        $isCorrect = $typedWord === $correctWord;

        $difficultyConfig = match ($game->difficulty) {
            'easy' => ['time_limit' => 5, 'base_score' => 100],
            'medium' => ['time_limit' => 7, 'base_score' => 150],
            'hard' => ['time_limit' => 8, 'base_score' => 200],
        };

        $timeLimit = $difficultyConfig['time_limit'];
        $baseScore = $difficultyConfig['base_score'];

        $timeSpent = min((float) $request->time_spent, $timeLimit);
        $errorsCount = (int) $request->errors_count;
        $penaltyTime = (float) $request->penalty_time;

        $scoreEarned = 0;

        if ($isCorrect) {
            $remainingTime = max(0, $timeLimit - $timeSpent);
            $scoreEarned = (int) round($baseScore * ($remainingTime / $timeLimit));
        }

        $currentAttempt->update([
            'typed_word' => $typedWord,
            'is_correct' => $isCorrect,
            'is_completed' => true,
            'errors_count' => $errorsCount,
            'penalty_time' => $penaltyTime,
            'time_spent' => $timeSpent,
            'score_earned' => $scoreEarned,
        ]);

        $game->total_errors += $errorsCount;
        $game->total_penalty_time += $penaltyTime;

        if ($isCorrect) {
            $game->completed_words += 1;
            $game->total_score += $scoreEarned;
        }

        $remainingAttempts = $game->attempts()
            ->where('is_completed', false)
            ->count();

        if ($remainingAttempts === 0) {
            $game->ended_at = now();
        }

        $game->save();

        return redirect()->route('game.play', $game);
    }

    public function modes()
    {
        return view('game.modes');
    }
}
