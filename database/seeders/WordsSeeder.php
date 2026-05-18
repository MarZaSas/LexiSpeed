<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;

class WordsSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            ['text' => 'pepinillo', 'difficulty' => 'easy', 'length' => 9],
            ['text' => 'libro', 'difficulty' => 'easy', 'length' => 5],
            ['text' => 'grillo', 'difficulty' => 'easy', 'length' => 6],
            ['text' => 'vegetariano', 'difficulty' => 'medium', 'length' => 11],
            ['text' => 'introspectivo', 'difficulty' => 'medium', 'length' => 13],
        ];

        foreach ($words as $word) {
            Word::updateOrCreate(
                ['text' => $word['text']],
                [
                    'difficulty' => $word['difficulty'],
                    'length' => $word['length'],
                    'is_active' => true,
                ]
            );
        }
    }
}
