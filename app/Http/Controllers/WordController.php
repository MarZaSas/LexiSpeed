<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::orderBy('id', 'desc')->get();
        return view('admin.words.index', compact('words'));
    }

    public function create()
    {
        return view('admin.words.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|unique:words,text',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        Word::create([
            'text' => strtolower(trim($request->text)),
            'difficulty' => $request->difficulty,
            'length' => strlen(trim($request->text)),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('words.index')->with('success', 'Palabra creada correctamente.');
    }

    public function edit(Word $word)
    {
        return view('admin.words.edit', compact('word'));
    }

    public function update(Request $request, Word $word)
    {
        $request->validate([
            'text' => 'required|string|unique:words,text,' . $word->id,
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $cleanText = strtolower(trim($request->text));

        $word->update([
            'text' => $cleanText,
            'difficulty' => $request->difficulty,
            'length' => strlen($cleanText),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('words.index')->with('success', 'Palabra actualizada correctamente.');
    }

    public function destroy(Word $word)
    {
        $word->delete();

        return redirect()->route('words.index')->with('success', 'Palabra eliminada correctamente.');
    }

    public function toggle(Word $word)
    {
        $word->update([
            'is_active' => !$word->is_active
        ]);

        return redirect()->route('words.index')->with('success', 'Estado de la palabra actualizado correctamente.');
    }
}