<?php

namespace App\Http\Controllers;

use App\Models\Curso;          // Importamos el modelo Curso para trabajar con la tabla
use Illuminate\Http\Request;   // Para manejar los datos que vienen de las peticiones HTTP

class CursoController extends Controller
{
    /**
     * Listar todos los cursos
     * GET /api/cursos
     * No requiere autenticación (es pública)
     */
    public function index()
    {
        // Curso::all() consulta la tabla 'cursos' y devuelve todos los registros
        // Laravel automáticamente convierte el resultado a JSON
        return Curso::all();
    }

    /**
     * Mostrar el formulario para crear un nuevo curso
     * (Generalmente no se usa en API, es para vistas web)
     */
    public function create()
    {
        // No implementado
    }

    /**
     * Guardar un nuevo curso en la base de datos
     * POST /api/cursos
     * Requiere autenticación (debería estar protegida)
     */
    public function store(Request $request)
    {
        // Pendiente de implementar
    }

    /**
     * Mostrar un curso específico
     * GET /api/cursos/{id}
     * No requiere autenticación
     */
   public function show($id)
    {
        $curso = Curso::with('modulos.lecciones')->find($id);
        
        if (!$curso) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }
        
        return response()->json($curso);
    }
    /**
     * Mostrar el formulario para editar un curso
     * (Para API no se usa)
     */
    public function edit(Curso $curso)
    {
        // No implementado
    }

    /**
     * Actualizar un curso existente
     * PUT /api/cursos/{id}
     * Requiere autenticación (solo admin)
     */
    public function update(Request $request, Curso $curso)
    {
        // Pendiente de implementar
    }

    /**
     * Eliminar un curso
     * DELETE /api/cursos/{id}
     * Requiere autenticación (solo admin)
     */
    public function destroy(Curso $curso)
    {
        // Pendiente de implementar
    }

    /**
 * Obtener el progreso de un usuario en un curso
 * GET /api/cursos/{id}/progreso
 * Requiere autenticación
 */
public function cursoProgreso($id)
{
    $user = auth()->user();
    if (!$user) {
        return response()->json(['message' => 'No autenticado'], 401);
    }

    // Obtener el curso
    $curso = Curso::find($id);
    if (!$curso) {
        return response()->json(['message' => 'Curso no encontrado'], 404);
    }

    // Obtener todas las lecciones del curso (a través de módulos)
    $lecciones = $curso->modulos()->with('lecciones')->get()->pluck('lecciones')->flatten();

    // Obtener los IDs de las lecciones que el usuario ya vio
    $vistas = \App\Models\Progreso::where('user_id', $user->id)
        ->whereIn('leccion_id', $lecciones->pluck('id'))
        ->pluck('leccion_id')
        ->toArray();

    // Armar la respuesta
    $progreso = $lecciones->map(function ($leccion) use ($vistas) {
        return [
            'id' => $leccion->id,
            'vista' => in_array($leccion->id, $vistas),
        ];
    });

    return response()->json([
        'curso_id' => (int) $id,
        'lecciones' => $progreso,
    ]);
}
}