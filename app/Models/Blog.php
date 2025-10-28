<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'imagen_destacada',
        'titulo_blog',
        'slug',
        'fecha',
        'texto_blog',
    ];
}
