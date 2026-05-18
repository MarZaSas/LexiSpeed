<?php

namespace App\Http\Controllers;

use App\Models\RoulettePhrase;
use Illuminate\Http\Request;

class RoulettePhraseController extends Controller
{
    public function index()
    {
        $roulettePhrases = RoulettePhrase::latest()->paginate(10);

        return view('roulette_phrases.index', compact('roulettePhrases'));
    }

    public function create()
    {
        return view('roulette_phrases.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|unique:roulette_phrases,text',
        ]);

        RoulettePhrase::create([
            'text' => $request->text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('roulette-phrases.index')
            ->with('success', 'Frase de ruleta creada correctamente.');
    }

    public function edit(RoulettePhrase $roulettePhrase)
    {
        return view('roulette_phrases.edit', compact('roulettePhrase'));
    }

    public function update(Request $request, RoulettePhrase $roulettePhrase)
    {
        $request->validate([
            'text' => 'required|string|unique:roulette_phrases,text,' . $roulettePhrase->id,
        ]);

        $roulettePhrase->update([
            'text' => $request->text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('roulette-phrases.index')
            ->with('success', 'Frase de ruleta actualizada.');
    }

    public function destroy(RoulettePhrase $roulettePhrase)
    {
        RoulettePhrase::destroy($roulettePhrase->id);

        return redirect()
            ->route('roulette-phrases.index')
            ->with('success', 'Frase de ruleta eliminada.');
    }

    public function toggle(RoulettePhrase $roulettePhrase)
    {
        $roulettePhrase->update([
            'is_active' => !$roulettePhrase->is_active,
        ]);

        return back();
    }
}
