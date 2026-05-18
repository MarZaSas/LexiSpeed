<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhraseController;
use App\Http\Controllers\GhostGameController;
use App\Http\Controllers\RoulettePhraseController;
use App\Http\Controllers\RouletteGameController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/play', [GameController::class, 'difficulty'])->name('game.difficulty');
    Route::post('/play/start', [GameController::class, 'start'])->name('game.start');
    Route::get('/play/modes', [GameController::class, 'modes'])->name('game.modes');
    Route::post('/ghost/start', [GhostGameController::class, 'start'])->name('ghost.start');
    Route::get('/ghost/{game}', [GhostGameController::class, 'play'])->name('ghost.play');
    Route::post('/ghost/{game}/attempt', [GhostGameController::class, 'submitAttempt'])->name('ghost.attempt');
    Route::get('/play/{game}', [GameController::class, 'play'])->name('game.play');
    Route::post('/play/{game}/attempt', [GameController::class, 'submitAttempt'])->name('game.attempt');

    Route::post('/roulette/start', [RouletteGameController::class, 'start'])->name('roulette.start');
    Route::get('/roulette/{game}', [RouletteGameController::class, 'play'])->name('roulette.play');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('words/{word}/toggle', [WordController::class, 'toggle'])->name('words.toggle');
    Route::resource('words', WordController::class);
    Route::resource('admin/phrases', PhraseController::class);
    Route::resource('admin/roulette-phrases', RoulettePhraseController::class);

    Route::post(
        'admin/roulette-phrases/{roulettePhrase}/toggle',
        [RoulettePhraseController::class, 'toggle']
    )->name('roulette-phrases.toggle');
});

Route::post(
    'admin/phrases/{phrase}/toggle',
    [PhraseController::class, 'toggle']
)->name('phrases.toggle');

Route::post('/roulette/{game}/spin', [RouletteGameController::class, 'spin'])
    ->name('roulette.spin');
require __DIR__.'/auth.php';
