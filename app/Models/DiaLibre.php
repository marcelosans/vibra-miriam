<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaLibre extends Model
{
    protected $table = 'dias_libres';
    protected $fillable = ['fecha', 'motivo'];
    protected $dates = ['fecha'];
}
