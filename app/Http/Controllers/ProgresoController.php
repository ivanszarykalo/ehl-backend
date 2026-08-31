<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Leccion;
use App\Models\Progreso;
use Illuminate\Http\Request;

class ProgresoController extends Controller
{
    /**
     * Marcar una lección como vista
     * POST /api/lecciones/{id}/progreso
     */
    public function marcarVista(Request $request, $leccionId)
    {
        $user = $request->user();
        $leccion = Leccion::findOrFail($leccionId);

        // Verificar que el usuario esté inscrito en el curso de esta lección
        $cursoId = $leccion->modulo->curso_id;
        if (!$user->cursos()->where('curso_id', $cursoId)->exists()) {
            return response()->json([
                'message' => 'No estás inscrito en este curso'
            ], 403);
        }

        // Crear o actualizar el progreso
        $progreso = Progreso::updateOrCreate(
            ['user_id' => $user->id, 'leccion_id' => $leccionId],
            ['visto' => true]
        );

        return response()->json([
            'message' => 'Lección marcada como vista',
            'progreso' => $progreso
        ]);
    }

    /**
     * Obtener el progreso del usuario en un curso
     * GET /api/cursos/{id}/progreso
     */
    public function progresoCurso(Request $request, $cursoId)
    {
        $user = $request->user();
        $curso = Curso::findOrFail($cursoId);

        // Verificar inscripción
        if (!$user->cursos()->where('curso_id', $cursoId)->exists()) {
            return response()->json([
                'message' => 'No estás inscrito en este curso'
            ], 403);
        }

        // Cargar módulos y lecciones
        $curso->load(['modulos.lecciones']);

        // Contar lecciones totales
        $totalLecciones = 0;
        foreach ($curso->modulos as $modulo) {
            $totalLecciones += $modulo->lecciones->count();
        }

        // Contar lecciones vistas
        $leccionesVistas = Progreso::where('user_id', $user->id)
            ->whereIn('leccion_id', $curso->modulos->flatMap->lecciones->pluck('id'))
            ->where('visto', true)
            ->count();

        return response()->json([
            'curso' => $curso->titulo,
            'total_lecciones' => $totalLecciones,
            'lecciones_vistas' => $leccionesVistas,
            'porcentaje' => $totalLecciones > 0 ? round(($leccionesVistas / $totalLecciones) * 100) : 0,
            'modulos' => $curso->modulos
        ]);
    }
    /**
     * Obtener el progreso de una lección específica para el usuario autenticado
     * GET /api/lecciones/{id}/progreso
     */
    public function obtenerProgreso(Request $request, $leccionId)
    {
        $user = $request->user();

        $progreso = Progreso::where('user_id', $user->id)
            ->where('leccion_id', $leccionId)
            ->first();

        if (!$progreso) {
            return response()->json([
                'visto' => false,
                'message' => 'No hay registro de progreso para esta lección'
            ], 404);
        }

        return response()->json([
            'visto' => (bool) $progreso->visto,
            'created_at' => $progreso->created_at,
            'updated_at' => $progreso->updated_at
        ]);
    }
}