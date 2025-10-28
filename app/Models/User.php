<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'apellido',
        'segundo_apellido',
        'email',
        'telefono',
        'password',
        'foto_de_perfil', // Agregado para el perfil de usuario
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim($this->name . ' ' . $this->apellido . ' ' . ($this->segundo_apellido ?? ''));
    }

    /**
     * Relación con reservaciones
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Accessor para formatear el teléfono
     */
    public function getTelefonoFormateadoAttribute(): string
    {
        if (!$this->telefono) {
            return '';
        }

        // Si es un teléfono español (+34...)
        if (str_starts_with($this->telefono, '+34')) {
            $numero = substr($this->telefono, 3);
            return '+34 ' . substr($numero, 0, 3) . ' ' . substr($numero, 3, 3) . ' ' . substr($numero, 6);
        }

        return $this->telefono;
    }

    /**
     * Accessor para la URL de la foto de perfil
     */
    public function getFotoPerfilUrlAttribute(): string
    {
        if ($this->foto_perfil && \Storage::exists('public/' . $this->foto_perfil)) {
            return \Storage::url($this->foto_perfil);
        }
        
        // Foto por defecto basada en el género o iniciales
        return 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face';
    }

    /**
     * Mutator para limpiar el teléfono antes de guardarlo
     */
    public function setTelefonoAttribute($value)
    {
        // Limpiar espacios y caracteres especiales, mantener solo números y +
        $this->attributes['telefono'] = preg_replace('/[^\d\+]/', '', $value);
    }
}