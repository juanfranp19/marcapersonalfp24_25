<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nif',
        'nombre',
        'email',
        'token',
        'user_id',
    ];

    public static $filterColumns = ['nif', 'nombre', 'email', 'token'];

}
