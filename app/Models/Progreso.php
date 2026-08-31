<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progreso extends Model
{
    protected $fillable = [
        'user_id',
        'leccion_id',
        'visto',
    ];
}