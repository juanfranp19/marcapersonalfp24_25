<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Administrador extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id'
    ];

    public static $filterColumns = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'administradores';
}
