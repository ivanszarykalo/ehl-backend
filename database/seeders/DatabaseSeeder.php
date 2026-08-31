<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Leccion;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        $user = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Crear cursos
        $curso1 = Curso::create([
            'titulo' => 'Laravel desde Cero',
            'descripcion' => 'Aprende Laravel desde los fundamentos. Este curso te enseñará todo lo que necesitas para construir aplicaciones web modernas con Laravel.',
            'precio' => 99.99,
            'preciopromo' => 49.99,
            'imagen' => 'https://via.placeholder.com/400x300?text=Laravel+Cero',
            'publicado' => true,
            'enoferta' => true,
        ]);

        $curso2 = Curso::create([
            'titulo' => 'PHP Avanzado',
            'descripcion' => 'Domina los conceptos avanzados de PHP: namespaces, traits, closures, generadores y más.',
            'precio' => 79.99,
            'preciopromo' => 59.99,
            'imagen' => 'https://via.placeholder.com/400x300?text=PHP+Avanzado',
            'publicado' => true,
            'enoferta' => false,
        ]);

        $curso3 = Curso::create([
            'titulo' => 'React.js Fundamental',
            'descripcion' => 'Aprende a construir interfaces interactivas con React. Desde lo básico hasta aplicaciones complejas.',
            'precio' => 89.99,
            'preciopromo' => 69.99,
            'imagen' => 'https://via.placeholder.com/400x300?text=React+Fundamental',
            'publicado' => true,
            'enoferta' => true,
        ]);

        // Módulos para Curso 1
        $modulo1_1 = Modulo::create([
            'curso_id' => $curso1->id,
            'titulo' => 'Introducción a Laravel',
            'orden' => 1,
        ]);

        $modulo1_2 = Modulo::create([
            'curso_id' => $curso1->id,
            'titulo' => 'Routing y Controladores',
            'orden' => 2,
        ]);

        $modulo1_3 = Modulo::create([
            'curso_id' => $curso1->id,
            'titulo' => 'Bases de Datos y ORM Eloquent',
            'orden' => 3,
        ]);

        // Módulos para Curso 2
        $modulo2_1 = Modulo::create([
            'curso_id' => $curso2->id,
            'titulo' => 'Namespaces y Autoloading',
            'orden' => 1,
        ]);

        $modulo2_2 = Modulo::create([
            'curso_id' => $curso2->id,
            'titulo' => 'Traits y Características Avanzadas',
            'orden' => 2,
        ]);

        // Módulos para Curso 3
        $modulo3_1 = Modulo::create([
            'curso_id' => $curso3->id,
            'titulo' => 'Fundamentos de React',
            'orden' => 1,
        ]);

        $modulo3_2 = Modulo::create([
            'curso_id' => $curso3->id,
            'titulo' => 'Hooks y State Management',
            'orden' => 2,
        ]);

        // Lecciones para Módulo 1.1
        Leccion::create([
            'modulo_id' => $modulo1_1->id,
            'titulo' => '¿Qué es Laravel?',
            'descripcion' => 'Introducción a Laravel y sus características principales.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => true,
        ]);

        Leccion::create([
            'modulo_id' => $modulo1_1->id,
            'titulo' => 'Instalación y Configuración',
            'descripcion' => 'Cómo instalar Laravel y configurar tu primer proyecto.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        // Lecciones para Módulo 1.2
        Leccion::create([
            'modulo_id' => $modulo1_2->id,
            'titulo' => 'Rutas en Laravel',
            'descripcion' => 'Aprende a definir rutas en tu aplicación Laravel.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => true,
        ]);

        Leccion::create([
            'modulo_id' => $modulo1_2->id,
            'titulo' => 'Controladores',
            'descripcion' => 'Creación y uso de controladores en Laravel.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        // Lecciones para Módulo 1.3
        Leccion::create([
            'modulo_id' => $modulo1_3->id,
            'titulo' => 'Migraciones y Esquemas',
            'descripcion' => 'Trabaja con migraciones para gestionar tu base de datos.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo1_3->id,
            'titulo' => 'Eloquent ORM',
            'descripcion' => 'Domina Eloquent, el ORM de Laravel.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        // Lecciones para Módulo 2.1
        Leccion::create([
            'modulo_id' => $modulo2_1->id,
            'titulo' => 'Namespaces en PHP',
            'descripcion' => 'Organiza tu código con namespaces.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => true,
        ]);

        // Lecciones para Módulo 2.2
        Leccion::create([
            'modulo_id' => $modulo2_2->id,
            'titulo' => 'Traits',
            'descripcion' => 'Reutiliza código con traits en PHP.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        // Lecciones para Módulo 3.1
        Leccion::create([
            'modulo_id' => $modulo3_1->id,
            'titulo' => 'JSX y Componentes',
            'descripcion' => 'Introducción a JSX y cómo crear componentes en React.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => true,
        ]);

        Leccion::create([
            'modulo_id' => $modulo3_1->id,
            'titulo' => 'Props y Estado',
            'descripcion' => 'Aprende cómo pasar datos entre componentes.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        // Lecciones para Módulo 3.2
        Leccion::create([
            'modulo_id' => $modulo3_2->id,
            'titulo' => 'Hooks básicos',
            'descripcion' => 'useState y useEffect: los hooks más importantes.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => true,
        ]);

        Leccion::create([
            'modulo_id' => $modulo3_2->id,
            'titulo' => 'Context API',
            'descripcion' => 'Gestiona estado global con Context API.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        // Enrollar usuario en los cursos
        $user->cursos()->attach([
            $curso1->id => ['fecha_limite' => now()->addMonths(3)],
            $curso2->id => ['fecha_limite' => now()->addMonths(6)],
        ]);
    }
}

