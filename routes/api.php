<?php

// Importamos las clases que vamos a usar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\ProgresoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PagoController;


/**
 * RUTA DE PRUEBA (OPCIONAL)
 * Endpoint: GET /api/test
 * Propósito: Verificar que el archivo de rutas API está funcionando
 * No requiere autenticación
 */
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

/**
 * RUTAS PÚBLICAS
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);

/**
 * GRUPO DE RUTAS PROTEGIDAS (requieren token)
 */
Route::middleware('auth:sanctum')->group(function () {
    
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Inscripciones
    Route::post('/cursos/{id}/inscribir', [InscripcionController::class, 'inscribir']);
    Route::get('/mis-cursos', [InscripcionController::class, 'misCursos']);
    
    // Lecciones
    Route::get('/cursos/{id}/lecciones', [LeccionController::class, 'index']);
    Route::get('/lecciones/{id}', [LeccionController::class, 'show']);
    
    // Progreso
    Route::post('/lecciones/{id}/progreso', [ProgresoController::class, 'marcarVista']);
    Route::get('/cursos/{id}/progreso', [ProgresoController::class, 'progresoCurso']);
    Route::get('/lecciones/{id}/progreso', [ProgresoController::class, 'obtenerProgreso']);

    Route::post('/cursos/{id}/checkout', [PagoController::class, 'crearPreferencia']);
});