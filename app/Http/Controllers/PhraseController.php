<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use Illuminate\Http\Request;

class PhraseController extends Controller
{
    public function index()
    {
        $phrases = Phrase::latest()->paginate(10);

        return view('phrases.index', compact('phrases'));
    }

    public function create()
    {
        return view('phrases.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|unique:phrases,text',
        ]);

        Phrase::create([
            'text' => $request->text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('phrases.index')
            ->with('success', 'Frase creada correctamente.');
    }

    public function edit(Phrase $phrase)
    {
        return view('phrases.edit', compact('phrase'));
    }

    public function update(Request $request, Phrase $phrase)
    {
        $request->validate([
            'text' => 'required|string|unique:phrases,text,' . $phrase->id,
        ]);

        $phrase->update([
            'text' => $request->text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('phrases.index')
            ->with('success', 'Frase actualizada.');
    }

    public function destroy(Phrase $phrase)
{
    Phrase::destroy($phrase->id);

    return redirect()
        ->route('phrases.index')
        ->with('success', 'Frase eliminada.');
}

    public function toggle(Phrase $phrase)
    {
        $phrase->update([
            'is_active' => !$phrase->is_active,
        ]);

        return back();
    }
}
