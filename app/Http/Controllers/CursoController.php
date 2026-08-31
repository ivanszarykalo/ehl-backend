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
        $curso = Curso::find($id);
        
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
}