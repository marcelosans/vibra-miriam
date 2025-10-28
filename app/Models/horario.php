<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
     protected $primaryKey = 'dia_de_la_semana';
    public $incrementing = false; // porque la PK es string
    protected $keyType = 'string';

    protected $fillable = [
        'dia_de_la_semana',
        'horario_ini_manana',
        'horario_final_manana',
        'horario_ini_tarde',
        'horario_final_tarde',
        'laborable',
    ];
}
