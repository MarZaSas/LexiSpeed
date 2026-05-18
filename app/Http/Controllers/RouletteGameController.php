<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\RouletteGame;
use App\Models\RoulettePhrase;
use Illuminate\Http\Request;

class RouletteGameController extends Controller
{
    public function start(Request $request)
    {
        if (!$request->user()) {
            abort(403);
        }

        $phrase = RoulettePhrase::where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (!$phrase) {
            return redirect()
                ->route('game.modes')
                ->with('error', 'No hay frases activas para jugar al modo ruleta.');
        }

        $game = Game::create([
            'user_id' => $request->user()->id,
            'mode' => 'roulette',
            'difficulty' => 'medium',
            'total_words' => 1,
            'started_at' => now(),
        ]);

        $rouletteGame = RouletteGame::create([
            'game_id' => $game->id,
            'roulette_phrase_id' => $phrase->id,
            'revealed_text' => $this->hidePhrase($phrase->text),
            'used_letters' => [],
            'current_points' => 0,
            'turn_points' => 0,
            'lives' => 3,
            'status' => 'playing',
        ]);

        return redirect()->route('roulette.play', $game);
    }

    public function play(Request $request, Game $game)
    {
        if (!$request->user() || $game->user_id !== $request->user()->id || $game->mode !== 'roulette') {
            abort(403);
        }

        $game->load('rouletteGame.phrase');

        return view('roulette.play', compact('game'));
    }

    public function spin(Request $request, Game $game)
    {
        if (
            !$request->user() ||
            $game->user_id !== $request->user()->id ||
            $game->mode !== 'roulette'
        ) {
            abort(403);
        }

        $roulette = $game->rouletteGame;

        if ($roulette->status !== 'playing') {
            return back();
        }

        $results = [
            'plus_50',
            'plus_100',
            'minus_50',
            'lose_life',
            'joker',
        ];

        $result = $results[array_rand($results)];

        $message = '';

        switch ($result) {

            case 'plus_50':
                $roulette->turn_points = 50;
                $message = '¡Has conseguido 50 puntos!';
                break;

            case 'plus_100':
                $roulette->turn_points = 100;
                $message = '¡Has conseguido 100 puntos!';
                break;

            case 'minus_50':
                $roulette->current_points = max(
                    0,
                    $roulette->current_points - 50
                );

                $roulette->turn_points = 0;

                $message = 'La ruleta te ha quitado 50 puntos.';
                break;

            case 'lose_life':
                $roulette->lives -= 1;
                $roulette->turn_points = 0;

                $message = 'Has perdido una vida.';

                if ($roulette->lives <= 0) {
                    $roulette->status = 'lost';
                    $game->ended_at = now();
                    $game->save();

                    $message = 'Has perdido la partida.';
                }

                break;

            case 'joker':
                $message = '¡Comodín! (próximamente desvelará una palabra)';
                $roulette->turn_points = 0;
                break;
        }

        $roulette->save();

        return back()->with('roulette_result', $message);
    }
    private function hidePhrase(string $phrase): string
    {
        $result = '';

        foreach (mb_str_split($phrase) as $char) {
            if ($char === ' ') {
                $result .= ' ';
            } else {
                $result .= '_';
            }
        }

        return $result;
    }
}
