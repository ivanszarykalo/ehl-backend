<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /** @use HasFactory<\Database\Factories\UserFactory> */

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: Un usuario tiene muchos cursos inscritos
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class)
                ->withPivot('fecha_limite')
                ->withTimestamps();
    }

    /**
     * RELACIÓN UNO A MUCHOS CON PROGRESO
     * Un usuario tiene muchos registros de progreso (una por cada lección que interactuó)
     * 
     * Uso: $user->progreso
     */
    public function progreso()
    {
        return $this->hasMany(Progreso::class);
    }

    /**
     * RELACIÓN MUCHOS A MUCHOS CON LECCIONES (SOLO LAS VISTAS)
     * Un usuario puede ver muchas lecciones
     * Una lección puede ser vista por muchos usuarios
     * 
     * Parámetros de belongsToMany:
     * - Leccion::class: modelo relacionado
     * - 'progreso': nombre de la tabla pivote
     * - 'user_id': columna en pivote que referencia a User
     * - 'leccion_id': columna en pivote que referencia a Leccion
     * 
     * withPivot('visto'): trae también la columna 'visto' de la tabla pivote
     * wherePivot('visto', true): filtra SOLO las lecciones marcadas como vistas
     * 
     * Uso: $user->leccionesVistas
     */
    public function leccionesVistas()
    {
        return $this->belongsToMany(Leccion::class, 'progreso', 'user_id', 'leccion_id')
                    ->withPivot('visto')
                    ->wherePivot('visto', true);
    }
}
