<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Horario;
use App\Models\DiaLibre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmed;

class ReservarCita extends Component
{
    public $currentDate;
    public $selectedDate = null;
    public $selectedTime = null;
    public $showTimeSlots = false;
    public $showSummary = false;
    public $showConfirmation = false;
    public $errorMessage = '';

    public $availableSlots = [
        'morning' => [],
        'afternoon' => [],
    ];

    public function mount()
    {
        $this->currentDate = Carbon::now();
    }

    public function previousMonth()
    {
        $this->currentDate->subMonth();
        $this->resetSelection();
    }

    public function nextMonth()
    {
        $this->currentDate->addMonth();
        $this->resetSelection();
    }

    public function selectDate($day)
    {
        $this->selectedDate = Carbon::create(
            $this->currentDate->year,
            $this->currentDate->month,
            $day
        );

        $this->selectedTime = null;
        $this->showTimeSlots = true;
        $this->showSummary = false;
        $this->showConfirmation = false;
        $this->errorMessage = '';

        // Verificar si es día libre/festivo
        if (DiaLibre::whereDate('fecha', $this->selectedDate->format('Y-m-d'))->exists()) {
            $this->availableSlots = ['morning' => [], 'afternoon' => []];
            $this->errorMessage = 'Este día no está disponible para citas.';
            return;
        }

        // Obtener horario del día
        $diaSemana = $this->getDayOfWeekInSpanish($this->selectedDate->dayOfWeek);
        $horario = Horario::where('dia_de_la_semana', $diaSemana)->first();

        if (!$horario || !$horario->laborable) {
            $this->availableSlots = ['morning' => [], 'afternoon' => []];
            $this->errorMessage = 'Este día no es laborable.';
            return;
        }

        // Generar slots disponibles
        $this->availableSlots = [
            'morning' => $this->generateAvailableSlots($horario->horario_ini_manana, $horario->horario_final_manana),
            'afternoon' => $this->generateAvailableSlots($horario->horario_ini_tarde, $horario->horario_final_tarde),
        ];
    }

    public function selectTime($time)
    {
        // Verificar que la hora siga disponible
        if ($this->isTimeOccupied($time)) {
            $this->errorMessage = 'Esta hora ya no está disponible.';
            return;
        }

        $this->selectedTime = $time;
        $this->showSummary = true;
        $this->errorMessage = '';
    }

    public function confirmAppointment()
    {
        try {
            if (!Auth::check()) {
                $this->errorMessage = 'Debes iniciar sesión para reservar una cita.';
                return;
            }

            if ($this->isTimeOccupied($this->selectedTime)) {
                $this->errorMessage = 'Esta hora ya ha sido reservada por otro usuario.';
                $this->refreshTimeSlots();
                return;
            }

            DB::transaction(function () {
                $reservation = Reservation::create([
                    'user_id' => Auth::id(),
                    'appointment_date' => $this->selectedDate->format('Y-m-d'),
                    'appointment_time' => $this->selectedTime,
                    'status' => 'confirmado'
                ]);

                // Enviar correo al usuario
                Mail::to(Auth::user()->email)->send(
                    new AppointmentConfirmed(Auth::user(), $this->getFormattedSelectedDate(), $this->selectedTime)
                );
            });

            $this->showSummary = false;
            $this->showConfirmation = true;
            $this->errorMessage = '';

        } catch (\Exception $e) {
            $this->errorMessage = 'Ha ocurrido un error al reservar la cita. Por favor, inténtalo de nuevo.';
        }
    }

    public function changeDateTime()
    {
        $this->showSummary = false;
        $this->showTimeSlots = true;
        $this->refreshTimeSlots();
    }

    public function resetSelection()
    {
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->showTimeSlots = false;
        $this->showSummary = false;
        $this->showConfirmation = false;
        $this->errorMessage = '';
    }

    public function isDayAvailable($day)
    {
        $dayDate = Carbon::create($this->currentDate->year, $this->currentDate->month, $day);

        // No disponible si es pasado
        if ($dayDate->isPast() && !$dayDate->isToday()) {
            return false;
        }

        // No disponible si es día libre/festivo
        if (DiaLibre::whereDate('fecha', $dayDate->format('Y-m-d'))->exists()) {
            return false;
        }

        // Verificar si es día laborable
        $diaSemana = $this->getDayOfWeekInSpanish($dayDate->dayOfWeek);
        $horario = Horario::where('dia_de_la_semana', $diaSemana)->first();
        
        if (!$horario || !$horario->laborable) {
            return false;
        }

        return true;
    }

    public function isDayPast($day)
    {
        $dayDate = Carbon::create($this->currentDate->year, $this->currentDate->month, $day);
        return $dayDate->isPast() && !$dayDate->isToday();
    }

    public function isDayOccupied($day)
    {
        $dayDate = Carbon::create($this->currentDate->year, $this->currentDate->month, $day);
        
        // Verificar si es día libre/festivo
        if (DiaLibre::whereDate('fecha', $dayDate->format('Y-m-d'))->exists()) {
            return true;
        }

        // Verificar si es día no laborable
        $diaSemana = $this->getDayOfWeekInSpanish($dayDate->dayOfWeek);
        $horario = Horario::where('dia_de_la_semana', $diaSemana)->first();
        
        if (!$horario || !$horario->laborable) {
            return true;
        }

        return false;
    }

    public function isTimeOccupied($time)
    {
        if (!$this->selectedDate) {
            return false;
        }

        return Reservation::where('appointment_date', $this->selectedDate->format('Y-m-d'))
            ->where('appointment_time', $time)
            ->where('status', 'confirmado')
            ->exists();
    }

    public function getCalendarDays()
    {
        $firstDay = $this->currentDate->copy()->startOfMonth();
        $lastDay = $this->currentDate->copy()->endOfMonth();

        $days = [];

        // Ajustar para que domingo sea 0
        $startDayOfWeek = $firstDay->dayOfWeek === 0 ? 0 : $firstDay->dayOfWeek;
        
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $days[] = null;
        }

        for ($day = 1; $day <= $lastDay->day; $day++) {
            $days[] = $day;
        }

        return $days;
    }

    public function getFormattedSelectedDate()
    {
        if (!$this->selectedDate) return '';

        $days = [
            0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
            4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'
        ];

        $months = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        return $days[$this->selectedDate->dayOfWeek] . ', ' .
            $this->selectedDate->day . ' de ' .
            $months[$this->selectedDate->month] . ' de ' .
            $this->selectedDate->year;
    }

    private function generateAvailableSlots($inicio, $fin)
    {
        $slots = [];

        if (!$inicio || !$fin) {
            return $slots;
        }

        try {
            $start = Carbon::parse($inicio);
            $end = Carbon::parse($fin);

            while ($start < $end) {
                $timeSlot = $start->format('H:i');
                
                // Solo agregar si no está ocupado
                if (!$this->isTimeOccupied($timeSlot)) {
                    $slots[] = $timeSlot;
                }
                
                $start->addHour(); // Puedes cambiar a addMinutes(30) para intervalos de 30 min
            }
        } catch (\Exception $e) {
     
        }

        return $slots;
    }

    private function getDayOfWeekInSpanish($dayOfWeek)
    {
        $days = [
            0 => 'Domingo',
            1 => 'Lunes', 
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado'
        ];

        return $days[$dayOfWeek];
    }

    private function refreshTimeSlots()
    {
        if ($this->selectedDate) {
            $this->selectDate($this->selectedDate->day);
        }
    }

    public function render()
    {
        return view('livewire.reservar-cita');
    }
}

?>