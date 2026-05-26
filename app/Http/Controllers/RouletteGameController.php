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

    $request->validate([
        'result' => 'required|in:plus_50,plus_100,minus_50,joker,lose_life',
    ]);

    $roulette = $game->rouletteGame()->with('phrase')->first();

    if ($roulette->status !== 'playing') {
        return back();
    }

    if ($roulette->turn_points > 0) {
        return back()->with('roulette_result', 'Debes comprar una letra o ahorrar los puntos antes de volver a girar.');
    }

    $result = $request->result;
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
            $roulette->current_points = max(0, $roulette->current_points - 50);
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
            $roulette->turn_points = 0;

            $roulette->revealed_text = $this->revealRandomWord(
                $roulette->phrase->text,
                $roulette->revealed_text
            );

            $message = '¡Comodín! Se ha desvelado una palabra del panel.';

            if (!$this->hasHiddenLetters($roulette->revealed_text)) {
                $roulette->status = 'won';

                $game->completed_words = 1;
                $game->total_score = $roulette->current_points;
                $game->ended_at = now();
                $game->save();

                $message = '¡Comodín! Has completado la frase.';
            }

            break;
    }

    $roulette->save();

    return back()->with('roulette_result', $message);
}

public function savePoints(Request $request, Game $game)
{
    if (!$this->canAccessRoulette($request, $game)) {
        abort(403);
    }

    $roulette = $game->rouletteGame;

    if ($roulette->status !== 'playing' || $roulette->turn_points <= 0) {
        return back();
    }

    $roulette->current_points += $roulette->turn_points;
    $roulette->turn_points = 0;
    $roulette->save();

    return back()->with('roulette_result', 'Has ahorrado los puntos de la tirada.');
}

public function buyLetter(Request $request, Game $game)
{
    if (!$this->canAccessRoulette($request, $game)) {
        abort(403);
    }

    $request->validate([
        'letter' => 'required|string|size:1',
    ]);

    $roulette = $game->rouletteGame()->with('phrase')->first();

    if ($roulette->status !== 'playing') {
        return back();
    }

    $letter = mb_strtolower($request->letter);
    $usedLetters = $roulette->used_letters ?? [];

    if (in_array($letter, $usedLetters)) {
        return back()->with('roulette_result', 'Esa letra ya ha sido utilizada.');
    }

    $vowels = ['a', 'e', 'i', 'o', 'u', 'á', 'é', 'í', 'ó', 'ú'];
    $cost = in_array($letter, $vowels) ? 100 : 50;

    $availablePoints = $roulette->current_points + $roulette->turn_points;

    if ($availablePoints < $cost) {
        return back()->with('roulette_result', 'No tienes puntos suficientes para comprar esa letra.');
    }

    $phrase = mb_strtolower($roulette->phrase->text);

    $usedLetters[] = $letter;

    $letterAppears = mb_strpos($phrase, $letter) !== false;

    if ($letterAppears) {
        $roulette->revealed_text = $this->revealLetter(
            $roulette->phrase->text,
            $roulette->revealed_text,
            $letter
        );

        $this->discountPoints($roulette, $cost);

        $message = 'La letra aparece en la frase.';

        if (!$this->hasHiddenLetters($roulette->revealed_text)) {
            $roulette->status = 'won';
            $game->ended_at = now();
            $game->completed_words = 1;
            $game->total_score = $roulette->current_points + $roulette->turn_points;
            $game->save();

            $message = '¡Has completado la frase!';
        }
    } else {
        $roulette->turn_points = 0;
        $message = 'La letra no aparece. Pierdes los puntos de esta tirada.';
    }

    $roulette->used_letters = $usedLetters;
    $roulette->save();

    return back()->with('roulette_result', $message);
}

public function solve(Request $request, Game $game)
{
    if (!$this->canAccessRoulette($request, $game)) {
        abort(403);
    }

    $request->validate([
        'solution' => 'required|string',
    ]);

    $roulette = $game->rouletteGame()->with('phrase')->first();

    if ($roulette->status !== 'playing') {
        return back();
    }

    $solution = $this->normalizeText($request->solution);
    $original = $this->normalizeText($roulette->phrase->text);

    if ($solution === $original) {
        $roulette->revealed_text = $roulette->phrase->text;
        $roulette->status = 'won';

        $roulette->current_points += $roulette->turn_points;
        $roulette->turn_points = 0;

        $game->completed_words = 1;
        $game->total_score = $roulette->current_points;
        $game->ended_at = now();

        $roulette->save();
        $game->save();

        return back()->with('roulette_result', '¡Correcto! Has resuelto la frase.');
    }

    $roulette->lives -= 1;

    if ($roulette->lives <= 0) {
        $roulette->status = 'lost';
        $game->ended_at = now();
        $game->save();

        $roulette->save();

        return back()->with('roulette_result', 'Respuesta incorrecta. Has perdido la partida.');
    }

    $roulette->save();

    return back()->with('roulette_result', 'Respuesta incorrecta. Pierdes una vida.');
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
    private function canAccessRoulette(Request $request, Game $game): bool
{
    return $request->user()
        && $game->user_id === $request->user()->id
        && $game->mode === 'roulette';
}

private function normalizeText(string $text): string
{
    $text = mb_strtolower(trim($text));
    $text = preg_replace('/\s+/', ' ', $text);

    return $text;
}

private function revealLetter(string $originalPhrase, string $revealedText, string $letter): string
{
    $result = '';
    $originalChars = mb_str_split($originalPhrase);
    $revealedChars = mb_str_split($revealedText);

    foreach ($originalChars as $index => $char) {
        if ($char === ' ') {
            $result .= ' ';
            continue;
        }

        if ($this->normalizeLetter($char) === $this->normalizeLetter($letter)) {
            $result .= $char;
        } else {
            $result .= $revealedChars[$index] ?? '_';
        }
    }

    return $result;
}

private function normalizeLetter(string $letter): string
{
    $letter = mb_strtolower($letter);

    return strtr($letter, [
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ñ' => 'n',
    ]);
}

private function hasHiddenLetters(string $revealedText): bool
{
    return str_contains($revealedText, '_');
}

private function discountPoints(RouletteGame $roulette, int $cost): void
{
    if ($roulette->turn_points >= $cost) {
        $roulette->turn_points -= $cost;
        return;
    }

    $remainingCost = $cost - $roulette->turn_points;
    $roulette->turn_points = 0;
    $roulette->current_points = max(0, $roulette->current_points - $remainingCost);
}

private function revealRandomWord(string $originalPhrase, string $revealedText): string
{
    $originalWords = explode(' ', $originalPhrase);
    $revealedWords = explode(' ', $revealedText);

    $hiddenWordIndexes = [];

    foreach ($originalWords as $index => $word) {
        $revealedWord = $revealedWords[$index] ?? '';

        if (str_contains($revealedWord, '_')) {
            $hiddenWordIndexes[] = $index;
        }
    }

    if (empty($hiddenWordIndexes)) {
        return $revealedText;
    }

    $randomIndex = $hiddenWordIndexes[array_rand($hiddenWordIndexes)];

    $revealedWords[$randomIndex] = $originalWords[$randomIndex];

    return implode(' ', $revealedWords);
}
}
