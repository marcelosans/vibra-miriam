<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    
     use HasFactory;

    protected $table = 'redes_sociales';

    protected $fillable = [
        'nombre',
        'usuario',
        'icono_svg',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accesor para obtener el usuario formateado
    public function getUsuarioFormateadoAttribute(): string
    {
        $usuario = $this->usuario;
        
        // Añadir @ si es necesario para ciertas redes sociales
        if (!str_starts_with($usuario, '@') && 
            in_array(strtolower($this->nombre), ['instagram', 'twitter', 'x', 'tiktok'])) {
            return '@' . $usuario;
        }
        
        return $usuario;
    }

    // Accesor para obtener la URL del perfil
    public function getPerfilUrlAttribute(): ?string
    {
        $usuario = ltrim($this->usuario, '@');
        
        return match (strtolower($this->nombre)) {
            'instagram' => "https://instagram.com/{$usuario}",
            'twitter', 'x' => "https://twitter.com/{$usuario}",
            'facebook' => "https://facebook.com/{$usuario}",
            'linkedin' => "https://linkedin.com/in/{$usuario}",
            'tiktok' => "https://tiktok.com/@{$usuario}",
            'youtube' => "https://youtube.com/@{$usuario}",
            'twitch' => "https://twitch.tv/{$usuario}",
            'github' => "https://github.com/{$usuario}",
            'discord' => "https://discord.com/users/{$usuario}",
            'telegram' => "https://t.me/{$usuario}",
            'whatsapp' => "https://wa.me/{$usuario}",
            default => null,
        };
    }

    // Accesor para obtener el tipo de icono
    public function getTipoIconoAttribute(): string
    {
        if (!$this->icono) return 'Sin icono';
        
        if (str_contains($this->icono, '<svg')) {
            return 'Código SVG';
        } elseif (str_starts_with($this->icono, 'fa-') || str_contains($this->icono, 'fa-')) {
            return 'FontAwesome';
        } elseif (filter_var($this->icono, FILTER_VALIDATE_URL)) {
            return 'URL de imagen';
        }
        
        return 'Código personalizado';
    }

    // Accesor para obtener el color representativo de la red social
    public function getColorRedAttribute(): string
    {
        return match (strtolower($this->nombre)) {
            'instagram' => '#E4405F',
            'facebook' => '#1877F2',
            'twitter', 'x' => '#000000',
            'linkedin' => '#0A66C2',
            'tiktok' => '#000000',
            'youtube' => '#FF0000',
            'twitch' => '#9146FF',
            'github' => '#181717',
            'discord' => '#5865F2',
            'telegram' => '#26A5E4',
            'whatsapp' => '#25D366',
            default => '#6B7280',
        };
    }

    // Scope para buscar por nombre de red social
    public function scopeByPlatform($query, $platform)
    {
        return $query->where('nombre', 'like', "%{$platform}%");
    }

    // Scope para buscar por usuario
    public function scopeByUser($query, $user)
    {
        return $query->where('usuario', 'like', "%{$user}%");
    }

    // Scope para redes sociales con icono
    public function scopeWithIcon($query)
    {
        return $query->whereNotNull('icono');
    }

    // Scope para redes sociales sin icono
    public function scopeWithoutIcon($query)
    {
        return $query->whereNull('icono');
    }

    // Scope para obtener las redes más populares
    public function scopePopular($query)
    {
        return $query->whereIn('nombre', [
            'Instagram', 'Facebook', 'Twitter', 'X', 'LinkedIn', 
            'TikTok', 'YouTube', 'WhatsApp', 'Telegram'
        ]);
    }

    // Método para validar si el usuario es válido para la plataforma
    public function isValidUser(): bool
    {
        $usuario = ltrim($this->usuario, '@');
        
        return match (strtolower($this->nombre)) {
            'instagram' => preg_match('/^[a-zA-Z0-9._]{1,30}$/', $usuario),
            'twitter', 'x' => preg_match('/^[a-zA-Z0-9_]{1,15}$/', $usuario),
            'tiktok' => preg_match('/^[a-zA-Z0-9._]{1,24}$/', $usuario),
            'youtube' => preg_match('/^[a-zA-Z0-9_-]{1,20}$/', $usuario),
            'twitch' => preg_match('/^[a-zA-Z0-9_]{4,25}$/', $usuario),
            'github' => preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9-]{0,37}[a-zA-Z0-9])?$/', $usuario),
            default => !empty($usuario),
        };
    }

    // Método estático para obtener las plataformas disponibles
    public static function getAvailablePlatforms(): array
    {
        return [
            'Instagram' => ['color' => '#E4405F', 'icon' => 'fab fa-instagram'],
            'Facebook' => ['color' => '#1877F2', 'icon' => 'fab fa-facebook'],
            'Twitter' => ['color' => '#1DA1F2', 'icon' => 'fab fa-twitter'],
            'X' => ['color' => '#000000', 'icon' => 'fab fa-x-twitter'],
            'LinkedIn' => ['color' => '#0A66C2', 'icon' => 'fab fa-linkedin'],
            'TikTok' => ['color' => '#000000', 'icon' => 'fab fa-tiktok'],
            'YouTube' => ['color' => '#FF0000', 'icon' => 'fab fa-youtube'],
            'Twitch' => ['color' => '#9146FF', 'icon' => 'fab fa-twitch'],
            'GitHub' => ['color' => '#181717', 'icon' => 'fab fa-github'],
            'Discord' => ['color' => '#5865F2', 'icon' => 'fab fa-discord'],
            'Telegram' => ['color' => '#26A5E4', 'icon' => 'fab fa-telegram'],
            'WhatsApp' => ['color' => '#25D366', 'icon' => 'fab fa-whatsapp'],
        ];
    }

    // Boot method para eventos del modelo
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Limpiar espacios en blanco
            $model->nombre = trim($model->nombre);
            $model->usuario = trim($model->usuario);
            
            // Formatear usuario automáticamente
            if (!str_starts_with($model->usuario, '@') && 
                in_array(strtolower($model->nombre), ['instagram', 'twitter', 'x', 'tiktok'])) {
                $model->usuario = '@' . ltrim($model->usuario, '@');
            }
        });
    }
}
