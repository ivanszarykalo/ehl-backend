<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    // Campos que se pueden asignar masivamente (protección contra asignación masiva)
    protected $fillable = [
        'titulo',           // Título del curso
        'descripcion',      // Descripción del curso
        'precio',           // Precio original
        'preciopromo',      // Precio en oferta
        'imagen',           // URL o ruta de la imagen de portada
        'publicado',        // Boolean: si está visible o no
        'enoferta',         // Boolean: si tiene oferta activa
        'fecha_inicio',     // Fecha de inicio del curso (para liberar contenido semanal)
    ];

    /**
     * RELACIÓN UNO A MUCHOS CON MÓDULOS
     * Un curso tiene muchos módulos.
     * Ordenados por el campo 'orden' de menor a mayor.
     * 
     * Uso: $curso->modulos  → devuelve todos los módulos del curso ordenados
     */
    public function modulos()
    {
        return $this->hasMany(Modulo::class)->orderBy('orden');
    }

    /**
     * RELACIÓN MUCHOS A MUCHOS CON USUARIOS
     * Un curso puede tener muchos usuarios inscritos.
     * Un usuario puede estar inscrito en muchos cursos.
     * Tabla pivote: curso_user (guarda user_id, curso_id y timestamps)
     * 
     * Uso: $curso->usuarios  → devuelve los usuarios inscriptos en este curso
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * MÉTODO: Obtener la semana actual del curso
     * 
     * Calcula en qué semana del curso estamos, basado en la fecha de inicio.
     * Si no hay fecha de inicio, devuelve 1 (todo liberado desde el principio).
     * 
     * @return int Semana actual (1-52)
     */
    public function getSemanaActual()
    {
        // Si no hay fecha de inicio, no hay liberación progresiva
        if (!$this->fecha_inicio) {
            return 1; // Semana 1 = todo liberado
        }
        
        $hoy = now();                                    // Fecha actual
        $diasDesdeInicio = $hoy->diffInDays($this->fecha_inicio);  // Días desde que empezó el curso
        $semana = floor($diasDesdeInicio / 7) + 1;       // Convertir días a semanas (empezando en semana 1)
        
        // Asegurar que la semana esté entre 1 y 52 (máximo un año)
        return max(1, min($semana, 52));
    }

    /**
     * MÉTODO: Verificar si el curso está vigente
     * 
     * Un curso es vigente si:
     * - No tiene fecha de inicio (siempre vigente) O
     * - No pasó más de 1 año desde la fecha de inicio
     * 
     * @return bool True si el curso sigue activo
     */
    public function estaVigente()
    {
        // Sin fecha de inicio, siempre vigente
        if (!$this->fecha_inicio) {
            return true;
        }
        
        // Calculamos la fecha de expiración (1 año después del inicio)
        $unAñoDespues = $this->fecha_inicio->copy()->addYear();
        
        // El curso es vigente si la fecha actual es menor o igual a la fecha de expiración
        return now()->lessThanOrEqualTo($unAñoDespues);
    }
}