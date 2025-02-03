<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{

    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'video_curriculum',
        'texto_curriculum'
    ];

    public static $filterColumns = [
        'id',
        'user_id',
        'video_curriculum',
        'texto_curriculum'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
