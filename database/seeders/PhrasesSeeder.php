<?php

namespace Database\Seeders;

use App\Models\Phrase;
use Illuminate\Database\Seeder;

class PhrasesSeeder extends Seeder
{
    public function run(): void
    {
        $phrases = [
            'Este TFG de Mario Zarco está más que aprobado, enhorabuena!',
            'Espero que no se te olvide (es complicado).',
            'Y entonces me dijo "Tú sabrás", yo flipo macho.',
            'He comprado camiseta azul, jersey rosa y gorra sin visera. ¡Todo muy barato!',
            'La inteligencia artificial está cambiando la forma en la que programamos aplicaciones.',
            'Nunca pensé que aprender Laravel fuese tan entretenido.',
            'El coche derrapó ligeramente al entrar demasiado rápido en la curva.',
            'Ayer terminé el proyecto a las tres de la madrugada y sigo vivo.',
            'No olvides subir los cambios a GitHub antes de apagar el ordenador.',
            'El teclado mecánico hace muchísimo ruido cuando escribes rápido.',
            'La lluvia golpeaba las ventanas mientras terminaba el código del backend.',
            'Mi profesor dijo que la presentación había quedado muy profesional.',
            'He perdido las llaves otra vez y ya no sé dónde buscarlas.',
            'Programar con música de fondo hace que me concentre mucho más.',
            'La pantalla del portátil estaba llena de pestañas abiertas y errores.',
            'El servidor dejó de funcionar justo antes de enseñar el proyecto.',
            'Me gustaría viajar a Japón y recorrer Tokio de noche.',
            'Cada vez que compilo el proyecto aparecen errores diferentes.',
            'El café estaba demasiado caliente pero necesitaba terminar la práctica.',
            'La ruleta decidió quitarme una vida justo cuando iba ganando.',
        ];

        foreach ($phrases as $phrase) {
            Phrase::updateOrCreate(
                ['text' => $phrase],
                ['is_active' => true]
            );
        }
    }
}
