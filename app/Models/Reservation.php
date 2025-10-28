<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime'
    ];

    // Estados posibles
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_CONFIRMADO = 'confirmado';
    const ESTADO_CANCELADO = 'cancelado';
    const ESTADO_FINALIZADO = 'finalizado';

    public static function getEstados()
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_CONFIRMADO => 'Confirmado',
            self::ESTADO_CANCELADO => 'Cancelado',
            self::ESTADO_FINALIZADO => 'Finalizado'
        ];
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para reservaciones activas (no canceladas ni finalizadas)
     */
    public function scopeActivas($query)
    {
        return $query->whereNotIn('status', [self::ESTADO_CANCELADO, self::ESTADO_FINALIZADO]);
    }

    /**
     * Scope para reservaciones completadas (finalizadas)
     */
    public function scopeFinalizadas($query)
    {
        return $query->where('status', self::ESTADO_FINALIZADO);
    }

    /**
     * Scope para reservaciones del usuario actual
     */
    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para reservaciones futuras
     */
    public function scopeFuturas($query)
    {
        return $query->where('appointment_date', '>=', Carbon::today());
    }

    /**
     * Scope para reservaciones pasadas
     */
    public function scopePasadas($query)
    {
        return $query->where('appointment_date', '<', Carbon::today());
    }

    /**
     * Accessor para fecha formateada
     */
    public function getFechaFormateadaAttribute()
    {
        if (!$this->appointment_date) return '';
        
        $dias = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes', 
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];

        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $fecha = Carbon::parse($this->appointment_date);
        $diaSemana = $dias[$fecha->format('l')];
        $dia = $fecha->day;
        $mes = $meses[$fecha->month];
        $año = $fecha->year;

        return "{$diaSemana}, {$dia} de {$mes} {$año}";
    }

    /**
     * Accessor para hora formateada
     */
    public function getHoraFormateadaAttribute()
    {
        if (!$this->appointment_time) return '';
        return Carbon::parse($this->appointment_time)->format('H:i A');
    }

    /**
     * Verificar si la reservación se puede cancelar
     */
    public function sePuedeCancelar()
    {
        if (in_array($this->status, [self::ESTADO_CANCELADO, self::ESTADO_FINALIZADO])) {
            return false;
        }

        try {
            // Crear la fecha y hora completa de la cita
            $fechaCita = Carbon::parse($this->appointment_date);
            $horaCita = Carbon::parse($this->appointment_time);
            
            // Combinar fecha y hora
            $fechaHoraCita = $fechaCita->setTime($horaCita->hour, $horaCita->minute, $horaCita->second);
            $ahora = Carbon::now();
            
            // Verificar si la cita es en el futuro y quedan al menos 24 horas
            return $fechaHoraCita->isFuture() && $ahora->diffInHours($fechaHoraCita, false) >= 24;
            
        } catch (\Exception $e) {
            // En caso de error, no permitir cancelar por seguridad
            return false;
        }
    }

    /**
     * Verificar si la reservación se puede finalizar
     */
    public function sePuedeFinalizar()
    {
        // Solo se puede finalizar si está confirmada y la cita ya pasó
        return $this->status === self::ESTADO_CONFIRMADO && $this->yaPaso();
    }

    /**
     * Cancelar la reservación
     */
    public function cancelar()
    {
        $this->update(['status' => self::ESTADO_CANCELADO]);
    }

    /**
     * Finalizar la reservación
     */
    public function finalizar()
    {
        $this->update(['status' => self::ESTADO_FINALIZADO]);
    }

    /**
     * Confirmar la reservación
     */
    public function confirmar()
    {
        $this->update(['status' => self::ESTADO_CONFIRMADO]);
    }

    /**
     * Verificar si la reservación es hoy
     */
    public function esHoy()
    {
        return $this->appointment_date->isToday();
    }

    /**
     * Verificar si la reservación ya pasó
     */
    public function yaPaso()
    {
        $fechaHoraCita = Carbon::parse($this->appointment_date->format('Y-m-d') . ' ' . Carbon::parse($this->appointment_time)->format('H:i:s'));
        return $fechaHoraCita->isPast();
    }

    /**
     * Verificar si la reservación está finalizada
     */
    public function estaFinalizada()
    {
        return $this->status === self::ESTADO_FINALIZADO;
    }

    /**
     * Verificar si la reservación está cancelada
     */
    public function estaCancelada()
    {
        return $this->status === self::ESTADO_CANCELADO;
    }

    /**
     * Verificar si la reservación está confirmada
     */
    public function estaConfirmada()
    {
        return $this->status === self::ESTADO_CONFIRMADO;
    }

    /**
     * Verificar si la reservación está pendiente
     */
    public function estaPendiente()
    {
        return $this->status === self::ESTADO_PENDIENTE;
    }
}