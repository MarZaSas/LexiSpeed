<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
{
    $user = $request->user();

    $selectedMode = $request->get('mode', 'all');

    $allGames = $user->games()
        ->whereNotNull('ended_at')
        ->latest()
        ->get();

    $filteredGames = $selectedMode === 'all'
        ? $allGames
        : $allGames->where('mode', $selectedMode);

    $stats = [
        'total_games' => $filteredGames->count(),
        'best_score' => $filteredGames->max('total_score') ?? 0,
        'average_score' => round($filteredGames->avg('total_score') ?? 0),
        'total_errors' => $filteredGames->sum('total_errors'),
        'classic_games' => $allGames->where('mode', 'classic')->count(),
        'ghost_games' => $allGames->where('mode', 'ghost')->count(),
        'roulette_games' => $allGames->where('mode', 'roulette')->count(),
    ];

    $latestGames = $filteredGames->take(10);

    return view('profile.edit', compact('user', 'stats', 'latestGames', 'selectedMode'));
}

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
