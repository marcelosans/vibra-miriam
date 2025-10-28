<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'minatura',
      
    ];
}
