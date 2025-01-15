<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = [
        'docente_id',
        'nombre',
        'dominio',
        'metadatos',
        'ciclo_id'
    ];
}
