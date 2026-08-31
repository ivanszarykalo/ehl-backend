<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    protected $table = 'lecciones';  // ← AGREGAR ESTA LÍNEA

    protected $fillable = [
        'modulo_id',
        'titulo',
        'descripcion',
        'video_url',
        'orden',
        'gratis',
    ];

    protected $casts = [
        'gratis' => 'boolean',
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function progreso()
    {
        return $this->hasMany(Progreso::class);
    }
}