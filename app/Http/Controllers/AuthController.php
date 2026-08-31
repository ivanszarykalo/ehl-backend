<?php

namespace App\Http\Controllers;

// Importamos los modelos y clases necesarias
use App\Models\User;                    // Modelo de usuario para crear y consultar
use Illuminate\Http\Request;             // Clase para manejar datos de la petición HTTP
use Illuminate\Support\Facades\Hash;     // Para encriptar contraseñas
use Illuminate\Support\Facades\Auth;     // Para autenticar usuarios
use Illuminate\Validation\Rules\Password;// Reglas de validación para contraseñas

class AuthController extends Controller
{
    /**
     * REGISTRO de nuevo usuario
     * Endpoint: POST /api/register
     * Recibe: name, email, password, password_confirmation
     * Devuelve: usuario creado + token de acceso
     */
    public function register(Request $request)
    {
        // Validar los datos que llegan del formulario/JSON
        $request->validate([
            'name' => ['required', 'string', 'max:255'],              // Obligatorio, texto, máx 255
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email único en tabla users
            'password' => ['required', 'confirmed', Password::defaults()], // Obligatorio, con confirmación, reglas por defecto
        ]);

        // Crear el usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar contraseña antes de guardar
        ]);

        // Generar un token de acceso para el usuario (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver respuesta JSON con código 201 (creado)
        return response()->json([
            'user' => $user,           // Datos del usuario
            'token' => $token,          // Token para autenticar próximas peticiones
            'token_type' => 'Bearer',   // Tipo de token (formato estándar)
        ], 201);
    }

    /**
     * LOGIN de usuario existente
     * Endpoint: POST /api/login
     * Recibe: email, password
     * Devuelve: usuario + token si las credenciales son válidas
     */
    public function login(Request $request)
    {
        // Validar que email y password estén presentes
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar con las credenciales
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Si falla, devolver error 401 (No autorizado)
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Obtener el usuario autenticado
        $user = User::where('email', $request->email)->firstOrFail();
        
        // Generar token nuevo para esta sesión
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver usuario y token
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * LOGOUT (cerrar sesión)
     * Endpoint: POST /api/logout (requiere token)
     * Recibe: token en header Authorization
     * Devuelve: mensaje de confirmación
     */
    public function logout(Request $request)
    {
        // Eliminar el token actual (el que se usó en esta petición)
        $request->user()->currentAccessToken()->delete();

        // Confirmar que se cerró sesión
        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}