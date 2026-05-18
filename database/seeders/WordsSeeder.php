<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;

class WordsSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
             ['text' => 'pepinillo', 'difficulty' => 'easy'],
            ['text' => 'libro', 'difficulty' => 'easy'],
            ['text' => 'grillo', 'difficulty' => 'easy'],
            ['text' => 'valiente', 'difficulty' => 'easy'],
            ['text' => 'persona', 'difficulty' => 'easy'],
            ['text' => 'buceador', 'difficulty' => 'easy'],
            ['text' => 'pastilla', 'difficulty' => 'easy'],
            ['text' => 'televisor', 'difficulty' => 'easy'],
            ['text' => 'guindilla', 'difficulty' => 'easy'],
            ['text' => 'flautista', 'difficulty' => 'easy'],
            ['text' => 'repaso', 'difficulty' => 'easy'],
            ['text' => 'tornillo', 'difficulty' => 'easy'],

            // Intermedio
            ['text' => 'vegetariano', 'difficulty' => 'medium'],
            ['text' => 'introspectivo', 'difficulty' => 'medium'],
            ['text' => 'fundación', 'difficulty' => 'medium'],
            ['text' => 'condición', 'difficulty' => 'medium'],
            ['text' => 'autonomía', 'difficulty' => 'medium'],
            ['text' => 'glándulas', 'difficulty' => 'medium'],
            ['text' => 'artística', 'difficulty' => 'medium'],
            ['text' => 'longitudinal', 'difficulty' => 'medium'],
            ['text' => 'palíndromo', 'difficulty' => 'medium'],
            ['text' => 'retrospectiva', 'difficulty' => 'medium'],
            ['text' => 'estupefaciente', 'difficulty' => 'medium'],
            ['text' => 'corrección', 'difficulty' => 'medium'],
            ['text' => 'personificado', 'difficulty' => 'medium'],
            ['text' => 'guitarrista', 'difficulty' => 'medium'],
            ['text' => 'explícito', 'difficulty' => 'medium'],

            // Difícil
            ['text' => 'otorrinolaringólogo', 'difficulty' => 'hard'],
            ['text' => 'electroencefalograma', 'difficulty' => 'hard'],
            ['text' => 'desoxirribonucleico', 'difficulty' => 'hard'],
            ['text' => 'paralelepípedo', 'difficulty' => 'hard'],
            ['text' => 'inconstitucionalidad', 'difficulty' => 'hard'],
            ['text' => 'anticonstitucional', 'difficulty' => 'hard'],
            ['text' => 'esternocleidomastoideo', 'difficulty' => 'hard'],
            ['text' => 'hipopotomonstrosesquipedaliofobia', 'difficulty' => 'hard'],
            ['text' => 'interdisciplinariedad', 'difficulty' => 'hard'],
            ['text' => 'contrarrevolucionario', 'difficulty' => 'hard'],
            ['text' => 'desproporcionadamente', 'difficulty' => 'hard'],
            ['text' => 'responsabilización', 'difficulty' => 'hard'],
            ['text' => 'extraordinariamente', 'difficulty' => 'hard'],
            ['text' => 'circunstancialmente', 'difficulty' => 'hard'],
            ['text' => 'institucionalización', 'difficulty' => 'hard'],
            ['text' => 'descontextualización', 'difficulty' => 'hard'],
            ['text' => 'electrodoméstico', 'difficulty' => 'hard'],
            ['text' => 'internacionalización', 'difficulty' => 'hard'],
            ['text' => 'desafortunadamente', 'difficulty' => 'hard'],
            ['text' => 'característicamente', 'difficulty' => 'hard'],
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
