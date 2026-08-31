<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Leccion;
use Illuminate\Http\Request;

class LeccionController extends Controller
{
    /**
     * Listar las lecciones de un curso (solo las liberadas según la semana)
     * GET /api/cursos/{id}/lecciones
     */
    public function index(Request $request, $cursoId)
    {
        $user = $request->user();

        $curso = Curso::findOrFail($cursoId);

        // Verificar inscripción
        $inscripcion = $user->cursos()->where('curso_id', $cursoId)->first();
        if (!$inscripcion) {
            return response()->json(['message' => 'No estás inscrito en este curso'], 403);
        }

        // Verificar vigencia
        if ($inscripcion->pivot->fecha_limite && now()->greaterThan($inscripcion->pivot->fecha_limite)) {
            return response()->json(['message' => 'Tu acceso a este curso ha expirado'], 403);
        }

        $semanaActual = $curso->getSemanaActual();

        // Obtener módulos liberados
        $modulos = Modulo::where('curso_id', $cursoId)
            ->where('semana', '<=', $semanaActual)
            ->orderBy('orden')
            ->get();

        // Cargar las lecciones de cada módulo
        $modulos->load('lecciones');

        //dd($modulos->first()->lecciones);

        // Formatear la respuesta
        $modulosConLecciones = $modulos->map(function ($modulo) {
            return [
                'id' => $modulo->id,
                'curso_id' => $modulo->curso_id,
                'titulo' => $modulo->titulo,
                'orden' => $modulo->orden,
                'semana' => $modulo->semana,
                'created_at' => $modulo->created_at,
                'updated_at' => $modulo->updated_at,
                'lecciones' => $modulo->lecciones->toArray(),
            ];
        });

        // Próximos módulos (para informar)
        $proximosModulos = Modulo::where('curso_id', $cursoId)
            ->where('semana', '>', $semanaActual)
            ->orderBy('semana')
            ->get();

        return response()->json([
            'curso' => [
                'id' => $curso->id,
                'titulo' => $curso->titulo,
                'fecha_inicio' => $curso->fecha_inicio,
                'fecha_limite' => $inscripcion->pivot->fecha_limite,
            ],
            'semana_actual' => $semanaActual,
            'modulos' => $modulosConLecciones,
            'proximos_modulos' => $proximosModulos->groupBy('semana')->map(function ($modulos, $semana) {
                return [
                    'semana' => $semana,
                    'modulos' => $modulos->pluck('titulo')
                ];
            })->values()
        ]);
    }

    /**
     * Mostrar una lección específica (verificar acceso)
     * GET /api/lecciones/{id}
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        // Buscar la lección con su módulo y curso
        $leccion = Leccion::with('modulo.curso')->findOrFail($id);

        $curso = $leccion->modulo->curso;
        $semanaActual = $curso->getSemanaActual();

        // Verificar que el módulo esté liberado
        if ($leccion->modulo->semana > $semanaActual) {
            return response()->json([
                'message' => 'Esta lección aún no está disponible'
            ], 403);
        }

        // Verificar inscripción
        $inscripcion = $user->cursos()->where('curso_id', $curso->id)->first();
        if (!$inscripcion) {
            return response()->json([
                'message' => 'No estás inscrito en este curso'
            ], 403);
        }

        // Verificar vigencia
        if ($inscripcion->pivot->fecha_limite && now()->greaterThan($inscripcion->pivot->fecha_limite)) {
            return response()->json([
                'message' => 'Tu acceso a este curso ha expirado'
            ], 403);
        }

        return $leccion;
    }
}