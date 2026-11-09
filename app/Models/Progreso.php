<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progreso extends Model
{
    use HasFactory;

    // Forzar el nombre de la tabla en singular
    protected $table = 'progreso';

    // Permitir la asignación masiva de los campos reales
    protected $fillable = [
        'user_id',
        'leccion_id',
        'visto',
    ];
}