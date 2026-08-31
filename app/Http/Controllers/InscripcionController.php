<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Inscribir a lx usuarix autenticadx en un curso
     * POST /api/cursos/{id}/inscribir
     * 
     * @param Request $request
     * @param int $cursoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function inscribir(Request $request, $cursoId)
    {
        // Obtener lx usuarix autenticadx desde el token (middleware auth:sanctum)
        $user = $request->user();
        
        // Buscar el curso por ID, si no existe devuelve error 404 automáticamente
        $curso = Curso::findOrFail($cursoId);
        
        // Verificar si lx usuarix ya está inscritx en este curso
        // cursos() es la relación many-to-many definida en User.php
        if ($user->cursos()->where('curso_id', $cursoId)->exists()) {
            return response()->json([
                'message' => 'Ya estás inscritx en este curso'
            ], 400);
        }
        
        // Calcular fecha límite de acceso (1 año desde la fecha de inicio del curso)
        $fechaLimite = null;
        if ($curso->fecha_inicio) {
            // copy() crea una copia para no modificar el objeto original
            $fechaLimite = $curso->fecha_inicio->copy()->addYear();
        }
        
        // Inscribir a lx usuarix: agrega registro en la tabla pivote 'curso_user'
        // attach() recibe el ID del curso y un array con datos adicionales para la tabla pivote
        $user->cursos()->attach($cursoId, ['fecha_limite' => $fechaLimite]);
        
        // Respuesta exitosa con código 200 (default)
        return response()->json([
            'message' => 'Te has inscrito correctamente',
            'curso' => $curso,
            'fecha_limite' => $fechaLimite
        ]);
    }
    
    /**
     * Ver los cursos de lx usuarix autenticadx
     * GET /api/mis-cursos
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function misCursos(Request $request)
    {
        // Obtener lx usuarix autenticadx
        $user = $request->user();
        
        // Obtener todos los cursos donde lx usuarix está inscritx
        // La relación cursos() incluye automáticamente los datos de la tabla pivote (fecha_limite, timestamps)
        $cursos = $user->cursos;
        
        return response()->json([
            'cursos' => $cursos
        ]);
    }
}