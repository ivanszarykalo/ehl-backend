<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progreso extends Model
{
    use HasFactory;

    // Agregá esta línea para forzar el nombre de la tabla:
    protected $table = 'progreso';

    // ... el resto de tu modelo (fillable, casts, etc.)
}