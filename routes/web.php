<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhraseController;

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
    Route::get('/play/{game}', [GameController::class, 'play'])->name('game.play');
    Route::post('/play/{game}/attempt', [GameController::class, 'submitAttempt'])->name('game.attempt');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('words/{word}/toggle', [WordController::class, 'toggle'])->name('words.toggle');
    Route::resource('words', WordController::class);
    Route::resource('admin/phrases', PhraseController::class);
});

Route::post(
    'admin/phrases/{phrase}/toggle',
    [PhraseController::class, 'toggle']
)->name('phrases.toggle');

require __DIR__.'/auth.php';
