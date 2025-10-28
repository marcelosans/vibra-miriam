<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class MisCitas extends Component
{
    public $showCancelModal = false;
    public $showConfirmationMessage = false;
    public $selectedCitaId = null;
    public $confirmationMessage = '';
    public $citas = [];

    public function mount()
    {
        $this->loadCitas();
    }

    public function loadCitas()
    {
        // Cargar las reservaciones del usuario autenticado ordenadas por fecha
        $this->citas = Reservation::delUsuario(Auth::id())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get()
            ->map(function ($reservacion) {
                return [
                    'id' => $reservacion->id,
                    'fecha' => $reservacion->fecha_formateada,
                    'hora' => $reservacion->hora_formateada,
                    'servicio' => 'Tratamiento de Belleza', // Valor por defecto ya que no tienes este campo
                    'estado' => $reservacion->status,
                    'duracion' => '60 minutos', // Valor por defecto
                    'puede_cancelar' => $reservacion->sePuedeCancelar(),
                    'es_hoy' => $reservacion->esHoy(),
                    'ya_paso' => $reservacion->yaPaso()
                ];
            })
            ->toArray();
    }

    public function getCitas()
    {
        return $this->citas;
    }

    public function showCancelModal($citaId)
    {
        $this->selectedCitaId = $citaId;
        $this->showCancelModal = true;
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->selectedCitaId = null;
    }

    public function confirmCancel()
    {
        try {
            // Buscar la reservación en la base de datos
            $reservation = Reservation::where('id', $this->selectedCitaId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$reservation) {
                $this->confirmationMessage = 'Error: No se encontró la cita.';
                $this->showConfirmationMessage = true;
                return;
            }

            // Verificar si se puede cancelar
            if (!$reservation->sePuedeCancelar()) {
                $this->confirmationMessage = 'Esta cita no se puede cancelar. Las citas deben cancelarse con al menos 24 horas de anticipación.';
                $this->showConfirmationMessage = true;
                $this->showCancelModal = false;
                return;
            }

            // Cancelar la cita
            $reservation->cancelar();

            // Recargar las citas
            $this->loadCitas();

            $this->showCancelModal = false;
            $this->selectedCitaId = null;
            $this->confirmationMessage = 'Tu cita ha sido cancelada exitosamente.';
            $this->showConfirmationMessage = true;

        } catch (\Exception $e) {
            $this->confirmationMessage = 'Ocurrió un error al cancelar la cita. Por favor, inténtalo nuevamente.';
            $this->showConfirmationMessage = true;
            $this->showCancelModal = false;
        }
    }

    public function nuevaCita()
    {
        // Redirigir a la página de reservar cita
        return redirect()->route('reservar-cita');
    }

    public function closeConfirmationMessage()
    {
        $this->showConfirmationMessage = false;
        $this->confirmationMessage = '';
    }

    public function render()
    {
        return view('livewire.mis-citas');
    }
}