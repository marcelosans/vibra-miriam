<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';

    protected $fillable = [
        'correo',
        'movil',
        'ubicacion',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accesor para formatear el teléfono móvil
    public function getMovilFormattedAttribute(): string
    {
        $movil = $this->movil;
        
        // Si es un número español (empieza por +34 o 6/7/8/9)
        if (preg_match('/^\+?34?([67890]\d{8})$/', $movil, $matches)) {
            return '+34 ' . substr($matches[1], 0, 3) . ' ' . substr($matches[1], 3, 3) . ' ' . substr($matches[1], 6, 3);
        }
        
        return $movil;
    }

    // Scope para buscar por correo
    public function scopeByEmail($query, $email)
    {
        return $query->where('correo', 'like', "%{$email}%");
    }

    // Scope para buscar por teléfono
    public function scopeByPhone($query, $phone)
    {
        return $query->where('movil', 'like', "%{$phone}%");
    }

    // Scope para contactos con ubicación
    public function scopeWithLocation($query)
    {
        return $query->whereNotNull('ubicacion');
    }

    // Scope para contactos sin ubicación
    public function scopeWithoutLocation($query)
    {
        return $query->whereNull('ubicacion');
    }
}
