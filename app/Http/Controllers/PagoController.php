<?php

namespace App\Http\Controllers;

// Importamos los modelos que vamos a usar
use App\Models\Curso;      // Para obtener datos del curso que se está comprando
use App\Models\User;       // Para encontrar al usuario después del pago
use Illuminate\Http\Request;
// Clientes del SDK de MercadoPago
use MercadoPago\SDK;        // Configura la conexión con MercadoPago
use MercadoPago\Preference; // Representa una preferencia de pago (lo que el cliente ve)
use MercadoPago\Item;       // Cada producto/servicio dentro de la preferencia

class PagoController extends Controller
{
    /**
     * CONSTRUCTOR
     * Se ejecuta cada vez que se crea una instancia de este controlador
     * Configura el Access Token de MercadoPago para todas las peticiones
     */
    public function __construct()
    {
        // Toma el token desde config/mercadopago.php (que a su vez lo lee del .env)
        SDK::setAccessToken(config('mercadopago.access_token'));
    }

    /**
     * 1. CREAR PREFERENCIA DE PAGO
     * POST /api/cursos/{id}/checkout
     * 
     * Esto le dice a MercadoPago: "preparame una ventana de pago para este curso"
     * Devuelve una URL (init_point) a donde redirigir al usuario para pagar
     */
    public function crearPreferencia(Request $request, $cursoId)
    {
        // 1. Obtener usuario autenticado (desde el token)
        $user = $request->user();
        
        // 2. Buscar el curso en la base de datos (si no existe, error 404)
        $curso = Curso::findOrFail($cursoId);

        // 3. Crear el ítem (producto) que se va a pagar
        $item = new Item();
        $item->id = $curso->id;                      // ID interno del curso
        $item->title = $curso->titulo;                // Título que verá el comprador
        $item->quantity = 1;                         // Cantidad (1 curso)
        $item->unit_price = (float) $curso->preciopromo; // Precio del curso (en ARS)
        $item->currency_id = "ARS";                  // Moneda: peso argentino

        // 4. Crear la preferencia de pago (la configuración completa)
        $preference = new Preference();
        $preference->items = [$item];                // Los productos a pagar
        
        // URLs a donde redirigir después del pago (éxito, error, pendiente)
        $preference->back_urls = [
            'success' => "http://localhost:3000/cursos/{$cursoId}",
            'failure' => "http://localhost:3000/cursos/{$cursoId}",
            'pending' => "http://localhost:3000/cursos/{$cursoId}"
        ];
        
        $preference->auto_return = "approved";       // Vuelve automáticamente si el pago se aprueba
        
        // Dato que sirve para identificar el pago cuando llegue el webhook
        // Guardamos "id_del_usuario_id_del_curso" para saber quién compró qué
        $preference->external_reference = "{$user->id}_{$curso->id}";

        // 5. Enviar la preferencia a MercadoPago (esto hace la API real)
        $preference->save();

        // 6. Devolver la URL de pago (init_point) y el ID de preferencia
        return response()->json([
            'init_point' => $preference->init_point,     // URL para pagar
            'preference_id' => $preference->id          // ID interno de MercadoPago
        ]);
    }

    /**
     * 2. WEBHOOK
     * POST /api/webhook/mercadopago
     * 
     * MercadoPago llama a esta URL automáticamente cuando un pago cambia de estado.
     * Acá procesamos la confirmación y damos acceso al curso.
     * NO necesita autenticación (es llamada por MercadoPago, no por un usuario).
     */
    public function webhook(Request $request)
    {
        // Obtener todos los datos que envió MercadoPago
        $data = $request->all();

        // Verificamos que la notificación sea de un pago (no de otro tipo de evento)
        if ($data['type'] === 'payment') {
            $paymentId = $data['data']['id'];       // ID del pago en MercadoPago (podríamos usarlo para consultar el estado)
            
            // Recuperar el external_reference que guardamos en la preferencia
            $externalReference = $data['external_reference'] ?? '';
            
            // Descomponer "user_id_curso_id" en dos partes
            $parts = explode('_', $externalReference);
            
            if (count($parts) === 2) {
                $userId = $parts[0];   // ID del usuario que compró
                $cursoId = $parts[1];  // ID del curso comprado
                
                // Buscar el usuario en la base de datos
                $user = User::find($userId);
                
                // Si el usuario existe y todavía no está inscripto en el curso...
                if ($user && !$user->cursos()->where('curso_id', $cursoId)->exists()) {
                    // Inscribirlo (agregar registro en la tabla pivote `curso_user`)
                    $user->cursos()->attach($cursoId);
                }
            }
        }
        
        // Responder OK para que MercadoPago no reintente la notificación
        return response()->json(['status' => 'ok'], 200);
    }
}