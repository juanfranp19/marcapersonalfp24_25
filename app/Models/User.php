<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nombre',
        'apellidos',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static $filterColumns = [
        'name', 'nombre', 'apellidos', 'email',
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

    public function curriculo()
    {
        return $this->hasOne(Curriculo::class);
    }

    public function actividadesComoEstudiante(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class, 'reconocimientos', 'estudiante_id', 'actividad_id')
            ->withPivot('documento', 'docente_validador');
    }

    public function actividadesComoDocente(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class, 'reconocimientos', 'docente_validador', 'actividad_id')
            ->withPivot('documento', 'estudiante_id');
    }

    public function competencias ()
    {
        return $this->belongsToMany(Competencia::class, 'users_competencias')
                ->withPivot('docente_validador');
    }

    public function ciclos(): BelongsToMany
    {
        return $this->belongsToMany(Ciclo::class, 'users_ciclos', 'user_id', 'ciclo_id');
    }

    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'participantes_proyectos', 'user_id', 'proyecto_id');
    }
}
