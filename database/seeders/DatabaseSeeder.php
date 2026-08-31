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
            'name' => 'Estudiante de Herrería',
            'email' => 'estudiante@herreriaLesbiana.com',
            'password' => Hash::make('herreria2024'),
        ]);

        // Crear el curso de Herrería con Electrodo Revestido
        $curso = Curso::create([
            'titulo' => 'Soldadura con Electrodo Revestido',
            'descripcion' => 'Aprende las técnicas fundamentales de soldadura con electrodo revestido. Un curso completo que te capacitará en los conocimientos teóricos y prácticos necesarios para dominar esta técnica esencial en la herrería moderna.',
            'precio' => 150.00,
            'preciopromo' => 120.00,
            'imagen' => 'https://via.placeholder.com/400x300?text=Electrodo+Revestido',
            'publicado' => true,
            'enoferta' => true,
        ]);

        // Módulo 1: Fundamentos de la Soldadura
        $modulo1 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Fundamentos de la Soldadura',
            'orden' => 1,
        ]);

        Leccion::create([
            'modulo_id' => $modulo1->id,
            'titulo' => 'Introducción a la Herrería',
            'descripcion' => 'Historia y evolución de la herrería. Conoce los orígenes de esta noble profesión y su importancia en la construcción moderna.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => true,
        ]);

        Leccion::create([
            'modulo_id' => $modulo1->id,
            'titulo' => '¿Qué es la Soldadura?',
            'descripcion' => 'Concepto básico de soldadura, procesos y aplicaciones en herrería y construcción metálica.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => true,
        ]);

        Leccion::create([
            'modulo_id' => $modulo1->id,
            'titulo' => 'Seguridad en el Taller de Soldadura',
            'descripcion' => 'Normas de seguridad, uso de equipos de protección personal (EPP) y prevención de accidentes.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 3,
            'gratis' => true,
        ]);

        // Módulo 2: Equipo y Materiales
        $modulo2 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Equipo y Materiales',
            'orden' => 2,
        ]);

        Leccion::create([
            'modulo_id' => $modulo2->id,
            'titulo' => 'Tipos de Máquinas de Soldar',
            'descripcion' => 'Máquinas transformadoras, rectificadoras e inversoras. Características y aplicaciones de cada una.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo2->id,
            'titulo' => 'Electrodos Revestidos: Clasificación y Selección',
            'descripcion' => 'Aprende a identificar y seleccionar el electrodo correcto según el material y la aplicación. Códigos AWS y especificaciones técnicas.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo2->id,
            'titulo' => 'Metales Base y Metales de Aporte',
            'descripcion' => 'Características de aceros, hierro y otros metales. Propiedades mecánicas y químicas importantes.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 3,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo2->id,
            'titulo' => 'Herramientas y Equipos de Protección',
            'descripcion' => 'Herramientas manuales, EPP específico: casco, guantes, mandil, polainas y calzado de seguridad.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 4,
            'gratis' => false,
        ]);

        // Módulo 3: Técnicas Básicas
        $modulo3 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Técnicas Básicas de Soldadura',
            'orden' => 3,
        ]);

        Leccion::create([
            'modulo_id' => $modulo3->id,
            'titulo' => 'Posición de Trabajo y Comodidad',
            'descripcion' => 'Cómo posicionarse correctamente para maximizar la calidad del trabajo y evitar lesiones.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo3->id,
            'titulo' => 'El Arco Eléctrico',
            'descripcion' => 'Creación y mantenimiento del arco. Distancia y ángulo correcto del electrodo. Práctica inicial.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo3->id,
            'titulo' => 'Pasadas de Soldadura',
            'descripcion' => 'Técnicas de pasadas: primera, segunda y posteriores. Control de penetración y recubrimiento.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 3,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo3->id,
            'titulo' => 'Velocidad y Temperatura de Trabajo',
            'descripcion' => 'Ajuste de amperaje según el tipo de electrodo. Identificación de temperaturas correctas por coloración.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 4,
            'gratis' => false,
        ]);

        // Módulo 4: Posiciones de Soldadura
        $modulo4 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Posiciones de Soldadura',
            'orden' => 4,
        ]);

        Leccion::create([
            'modulo_id' => $modulo4->id,
            'titulo' => 'Posición Plana (1G)',
            'descripcion' => 'La más fácil y accesible. Técnicas para obtener soldaduras perfectas en horizontal.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo4->id,
            'titulo' => 'Posición Vertical (2G/3G)',
            'descripcion' => 'Soldadura de abajo hacia arriba y técnicas especiales. Control de la gravedad y derrames.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo4->id,
            'titulo' => 'Posición Horizontal (4G)',
            'descripcion' => 'Soldadura en posición overhead. Técnicas para mantener el control y evitar derrames.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 3,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo4->id,
            'titulo' => 'Soldadura en Tubería (5G)',
            'descripcion' => 'Técnicas especializadas para soldadura en tubos y tuberías. Aplicaciones en herrería industrial.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 4,
            'gratis' => false,
        ]);

        // Módulo 5: Control de Calidad
        $modulo5 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Control de Calidad y Defectos',
            'orden' => 5,
        ]);

        Leccion::create([
            'modulo_id' => $modulo5->id,
            'titulo' => 'Defectos Comunes en la Soldadura',
            'descripcion' => 'Porosidad, grietas, falta de fusión, socavones y otros defectos. Cómo identificarlos.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo5->id,
            'titulo' => 'Inspección Visual de Soldaduras',
            'descripcion' => 'Estándares de calidad. Cómo evaluar una soldadura a simple vista.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo5->id,
            'titulo' => 'Pruebas No Destructivas (NDT)',
            'descripcion' => 'Radiografía, ultrasonido y otras pruebas para verificar la calidad interna de las soldaduras.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 3,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo5->id,
            'titulo' => 'Normas y Estándares de Soldadura',
            'descripcion' => 'AWS, ISO, ASME. Especificaciones técnicas que debes cumplir en tus trabajos.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 4,
            'gratis' => false,
        ]);

        // Módulo 6: Aplicaciones Prácticas
        $modulo6 = Modulo::create([
            'curso_id' => $curso->id,
            'titulo' => 'Aplicaciones Prácticas en Herrería',
            'orden' => 6,
        ]);

        Leccion::create([
            'modulo_id' => $modulo6->id,
            'titulo' => 'Proyectos de Herrería: Rejas y Barandas',
            'descripcion' => 'Casos prácticos de soldadura en proyectos decorativos y funcionales.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 1,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo6->id,
            'titulo' => 'Estructuras Metálicas Básicas',
            'descripcion' => 'Cómo soldar marcos, vigas y estructuras básicas. Consideraciones de resistencia.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 2,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo6->id,
            'titulo' => 'Mantenimiento del Equipo',
            'descripcion' => 'Cuidado y mantenimiento preventivo de máquinas de soldar para máxima durabilidad.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 3,
            'gratis' => false,
        ]);

        Leccion::create([
            'modulo_id' => $modulo6->id,
            'titulo' => 'De Aprendiz a Herrrera Profesional',
            'descripcion' => 'Consejos para desarrollar tu carrera, mejora continua y oportunidades en la herrería.',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'orden' => 4,
            'gratis' => true,
        ]);

        // Inscribir usuario en el curso
        $user->cursos()->attach([
            $curso->id => ['fecha_limite' => now()->addMonths(6)],
        ]);
    }
}

