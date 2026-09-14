<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Leccion;
use Illuminate\Database\Seeder;

class CursoRealSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el curso
        $curso = Curso::create([
            'titulo' => 'Curso de Herrería y Soldadura MMA - Nivel Inicial',
            'descripcion' => 'Un recorrido completo desde los básicos hasta la teoría del proceso MMA. Aprendé a soldar con electrodo revestido desde cero, con ejercicios prácticos, errores comunes y acompañamiento de tutores.',
            'precio' => 80000,
            'preciopromo' => 80000,
            'publicado' => true,
            'enoferta' => false,
            'fecha_inicio' => now(),
        ]);

        // 2. Módulo 1
        $modulo1 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Módulo 1: Primero lo primero',
            'orden' => 1,
            'semana' => 1,
        ]);

        $leccionesModulo1 = [
            ['titulo' => '1.0 Introducción', 'orden' => 1],
            ['titulo' => '1.1 Herramientas necesarias para un taller de herrería', 'orden' => 2],
            ['titulo' => '1.2 Elementos de protección personal (EPP)', 'orden' => 3],
            ['titulo' => '1.2.1 Delantal y ropa de trabajo', 'orden' => 4],
            ['titulo' => '1.2.2 Calzado y polainas', 'orden' => 5],
            ['titulo' => '1.2.3 Guantes de cuero', 'orden' => 6],
            ['titulo' => '1.2.4 Máscara de soldar', 'orden' => 7],
            ['titulo' => '1.2.5 Protecciones auditivas', 'orden' => 8],
            ['titulo' => '1.2.6 Protecciones respiratorias', 'orden' => 9],
            ['titulo' => '1.2.7 Protecciones visuales', 'orden' => 10],
            ['titulo' => '1.3 Herramientas no tan necesarias para tu taller (pero que quizás quieras tener)', 'orden' => 11],
            ['titulo' => '1.4 Preguntas frecuentes', 'orden' => 12],
            ['titulo' => '1.4.1 ¿MMA inverter o de bobina?', 'orden' => 13],
            ['titulo' => '1.4.2 ¿Qué amperaje de máquina elijo para comprar?', 'orden' => 14],
            ['titulo' => '1.4.3 ¿Qué elementos puedo usar para marcar los hierros?', 'orden' => 15],
        ];

        foreach ($leccionesModulo1 as $leccion) {
            Leccion::create([
                'modulo_id' => $modulo1->id,
                'titulo' => $leccion['titulo'],
                'orden' => $leccion['orden'],
                'gratis' => false,
                'descripcion' => null,
                'video_url' => null,
            ]);
        }

        // 3. Módulo 2
        $modulo2 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Módulo 2: ¡Manos a la obra!',
            'orden' => 2,
            'semana' => 1,
        ]);

        $leccionesModulo2 = [
            ['titulo' => '2.0 Introducción', 'orden' => 1],
            ['titulo' => '2.0.1 Calentar el electrodo', 'orden' => 2],
            ['titulo' => '2.0.2 Error común: ¿por qué se pega el electrodo?', 'orden' => 3],
            ['titulo' => '2.0.3 Error común: el electrodo no arranca', 'orden' => 4],
            ['titulo' => '2.1 El punto de soldadura', 'orden' => 5],
            ['titulo' => '2.1.1 Anexo: pulso y estabilidad al soldar', 'orden' => 6],
            ['titulo' => '2.1.2 Error común: se pega el electrodo al tocar a la planchuela', 'orden' => 7],
            ['titulo' => '2.1.3 Error común: los puntos quedan desparejos', 'orden' => 8],
            ['titulo' => '2.2 Introducción a la costura', 'orden' => 9],
            ['titulo' => '2.2.1 Distintas caligrafías', 'orden' => 10],
            ['titulo' => '2.2.2 El retroceso de electrodo', 'orden' => 11],
            ['titulo' => '2.2.3 El cordón', 'orden' => 12],
            ['titulo' => '2.2.4 Error común: el cordón es muy ancho o desparejo', 'orden' => 13],
            ['titulo' => '2.2.5 Error común: el electrodo queda muy lejos', 'orden' => 14],
            ['titulo' => '2.3 Uniendo dos piezas con un cordón', 'orden' => 15],
            ['titulo' => '2.4 Soldadura a 90°', 'orden' => 16],
            ['titulo' => '2.5 Espesores finos', 'orden' => 17],
            ['titulo' => '2.5.1 Espesores finos en plano', 'orden' => 18],
            ['titulo' => '2.5.2 Espesores finos a 90°', 'orden' => 19],
            ['titulo' => '2.5.3 Error común: se perfora la pieza soldando a 90°', 'orden' => 20],
        ];

        foreach ($leccionesModulo2 as $leccion) {
            Leccion::create([
                'modulo_id' => $modulo2->id,
                'titulo' => $leccion['titulo'],
                'orden' => $leccion['orden'],
                'gratis' => false,
                'descripcion' => null,
                'video_url' => null,
            ]);
        }

        // 4. Módulo 3
        $modulo3 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Módulo 3: Cerebro… ¡a trabajar!',
            'orden' => 3,
            'semana' => 1,
        ]);

        $leccionesModulo3 = [
            ['titulo' => '3.1 Acerca del arco eléctrico', 'orden' => 1],
            ['titulo' => '3.2 Polaridad directa e inversa', 'orden' => 2],
            ['titulo' => '3.3 Ciclo de trabajo y factor de servicio', 'orden' => 3],
            ['titulo' => '3.4 Calibración de amperaje', 'orden' => 4],
            ['titulo' => '3.5 Otros procesos de soldadura', 'orden' => 5],
        ];

        foreach ($leccionesModulo3 as $leccion) {
            Leccion::create([
                'modulo_id' => $modulo3->id,
                'titulo' => $leccion['titulo'],
                'orden' => $leccion['orden'],
                'gratis' => false,
                'descripcion' => null,
                'video_url' => null,
            ]);
        }

        // 5. Módulo 4
        $modulo4 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Módulo 4: ¡Ayuda! Me vi todo el curso y tengo preguntas.',
            'orden' => 4,
            'semana' => 1,
        ]);

        Leccion::create([
            'modulo_id' => $modulo4->id,
            'titulo' => '4.1 Un encuentro para resolver dudas (Link del meet)',
            'orden' => 1,
            'gratis' => false,
            'descripcion' => null,
            'video_url' => null,
        ]);

        $this->command->info('✅ Curso real creado con éxito.');
        $this->command->info('   Curso: ' . $curso->titulo);
        $this->command->info('   Módulos: 4');
        $this->command->info('   Lecciones: ' . Leccion::whereHas('modulo', function ($q) use ($curso) {
            $q->where('curso_id', $curso->id);
        })->count());
    }
}