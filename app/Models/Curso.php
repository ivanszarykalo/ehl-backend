<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'preciopromo',
        'imagen',
        'publicado',
        'enoferta',
        'fecha_inicio',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'publicado' => 'boolean',
        'enoferta' => 'boolean',
        'precio' => 'decimal:2',
        'preciopromo' => 'decimal:2',
    ];

    public function modulos()
    {
        return $this->hasMany(Modulo::class)->orderBy('orden');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getSemanaActual()
    {
        if (!$this->fecha_inicio) {
            return 1;
        }
        
        $hoy = now();
        $diasDesdeInicio = $hoy->diffInDays($this->fecha_inicio);
        $semana = floor($diasDesdeInicio / 7) + 1;
        
        return max(1, min($semana, 52));
    }

    public function estaVigente()
    {
        if (!$this->fecha_inicio) {
            return true;
        }
        
        $unAñoDespues = $this->fecha_inicio->copy()->addYear();
        
        return now()->lessThanOrEqualTo($unAñoDespues);
    }
}