{{-- resources/views/livewire/reservar-cita.blade.php --}}
<div>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .selected-day {
            background: linear-gradient(135deg, #ec4899, #f43f5e) !important;
            color: white !important;
            transform: scale(1.05);
            border-color: #be185d !important;
        }

        .available-hour {
            background: white;
            border: 2px solid #fbcfe8;
            transition: all 0.3s ease;
        }

        .available-hour:hover {
            background: #fce7f3;
            border-color: #ec4899;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2);
        }

        .selected-hour {
            background: linear-gradient(135deg, #ec4899, #f43f5e) !important;
            color: white !important;
            border-color: #be185d !important;
        }

        .occupied-hour {
            background: #f3f4f6 !important;
            color: #9ca3af !important;
            border-color: #d1d5db !important;
            cursor: not-allowed !important;
        }

        .calendar-day {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .calendar-day:hover:not(.occupied-day):not(.past-day) {
            background: #fce7f3;
            transform: translateY(-2px);
        }

        .past-day {
            background: #f9fafb !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
        }

        .occupied-day {
            background: #fef2f2 !important;
            color: #dc2626 !important;
            cursor: not-allowed !important;
        }

        .error-message {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>

    <!-- Página de reservar cita -->
    <div class="py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-6xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">

        <!-- Elementos decorativos -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-30 float-animation"></div>
            <div class="absolute top-1/2 -left-20 w-32 h-32 bg-rose-200 rounded-full opacity-20 float-animation" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 right-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-25 float-animation" style="animation-delay: 2s;"></div>
        </div>

        <!-- Contenido principal -->
        <div class="relative z-10">

            <!-- Mensaje de error -->
            @if($errorMessage)
                <div class="bg-red-50 border border-red-200 p-4 rounded-xl shadow-lg mb-6 error-message fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ $errorMessage }}</p>
                    </div>
                </div>
            @endif

            <!-- Encabezado -->
            <div class="text-center mb-12">
                <div class="inline-block relative mb-6">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-pink-200 to-rose-300 p-1 shadow-lg">
                        <div class="w-full h-full rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <h1 class="text-5xl font-bold gradient-text mb-4">Reservar Cita</h1>
                <p class="text-pink-600 font-medium text-xl">Elige el día y hora que mejor te convenga</p>
                
                @guest
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <p class="text-yellow-700">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Debes <a href="{{ route('login') }}" class="text-yellow-800 underline font-semibold">iniciar sesión</a> para reservar una cita.
                        </p>
                    </div>
                @endguest
            </div>

            <!-- Selector de mes y año -->
            <div class="bg-white/70 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-pink-100 mb-8 fade-in-up">
                <div class="flex items-center justify-between mb-6">
                    <button wire:click="previousMonth" class="p-2 rounded-full bg-pink-100 hover:bg-pink-200 transition">
                        <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                        </svg>
                    </button>
                    <h2 class="text-2xl font-semibold text-pink-700">
                        {{ $currentDate->translatedFormat('F Y') }}
                    </h2>
                    <button wire:click="nextMonth" class="p-2 rounded-full bg-pink-100 hover:bg-pink-200 transition">
                        <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Calendario -->
                <div class="grid grid-cols-7 gap-2 mb-4">
                    <div class="text-center font-semibold text-pink-600 p-2">Dom</div>
                    <div class="text-center font-semibold text-pink-600 p-2">Lun</div>
                    <div class="text-center font-semibold text-pink-600 p-2">Mar</div>
                    <div class="text-center font-semibold text-pink-600 p-2">Mié</div>
                    <div class="text-center font-semibold text-pink-600 p-2">Jue</div>
                    <div class="text-center font-semibold text-pink-600 p-2">Vie</div>
                    <div class="text-center font-semibold text-pink-600 p-2">Sáb</div>
                </div>
                
                <div class="grid grid-cols-7 gap-2">
                    @foreach($this->getCalendarDays() as $day)
                        @if($day === null)
                            <div></div>
                        @else
                            <div 
                                @if($this->isDayAvailable($day))
                                    wire:click="selectDate({{ $day }})"
                                @endif
                                class="calendar-day p-3 text-center rounded-xl font-medium
                                    @if($this->isDayPast($day))
                                        past-day
                                    @elseif($this->isDayOccupied($day))
                                        occupied-day
                                    @elseif($selectedDate && $selectedDate->day == $day)
                                        selected-day
                                    @else
                                        bg-white border-2 border-pink-100 hover:border-pink-300
                                    @endif
                                "
                                @if($this->isDayOccupied($day))
                                    title="Día no disponible"
                                @elseif($this->isDayPast($day))
                                    title="Fecha pasada"
                                @endif
                            >
                                {{ $day }}
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Horarios disponibles -->
            @if($showTimeSlots)
                <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-pink-100 mb-8 fade-in-up">
                    <h3 class="text-2xl font-semibold text-pink-700 mb-6 text-center">Horarios Disponibles</h3>
                    <p class="text-pink-600 text-center mb-6">{{ $this->getFormattedSelectedDate() }}</p>
                    
                    @if(empty($availableSlots['morning']) && empty($availableSlots['afternoon']))
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <p class="text-gray-500 text-lg">No hay horarios disponibles para este día</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @if(!empty($availableSlots['morning']))
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700 mb-3">Mañana</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        @foreach($availableSlots['morning'] as $time)
                                            <div 
                                                wire:click="selectTime('{{ $time }}')"
                                                class="p-3 text-center rounded-xl font-medium cursor-pointer
                                                    @if($selectedTime === $time)
                                                        selected-hour
                                                    @else
                                                        available-hour
                                                    @endif
                                                "
                                            >
                                                {{ $time }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @if(!empty($availableSlots['afternoon']))
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700 mb-3">Tarde</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        @foreach($availableSlots['afternoon'] as $time)
                                            <div 
                                                wire:click="selectTime('{{ $time }}')"
                                                class="p-3 text-center rounded-xl font-medium cursor-pointer
                                                    @if($selectedTime === $time)
                                                        selected-hour
                                                    @else
                                                        available-hour
                                                    @endif
                                                "
                                            >
                                                {{ $time }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            <!-- Resumen de la cita -->
            @if($showSummary)
                <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-pink-100 mb-8 fade-in-up">
                    <h3 class="text-2xl font-semibold text-pink-700 mb-6 text-center">Resumen de tu Cita</h3>
                    
                    <div class="bg-pink-50 p-6 rounded-xl mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-medium text-gray-700">Fecha:</span>
                            <span class="text-pink-600 font-semibold">{{ $this->getFormattedSelectedDate() }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-medium text-gray-700">Hora:</span>
                            <span class="text-pink-600 font-semibold">{{ $selectedTime }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-700">Duración:</span>
                            <span class="text-pink-600 font-semibold">60 minutos</span>
                        </div>
                    </div>

                    <div class="text-center space-y-4">
                        @auth
                            <button 
                                wire:click="confirmAppointment"
                                class="px-8 py-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-xl shadow-md transition duration-300"
                            >
                                Confirmar Cita
                            </button>
                        @else
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl mb-4">
                                <p class="text-yellow-700 mb-3">Debes iniciar sesión para confirmar la cita</p>
                                <a href="{{ route('login') }}" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-xl transition">
                                    Iniciar Sesión
                                </a>
                            </div>
                        @endauth
                        
                        <button 
                            wire:click="changeDateTime"
                            class="px-6 py-2 text-pink-600 hover:text-pink-700 font-medium transition block mx-auto"
                        >
                            Cambiar fecha/hora
                        </button>
                    </div>
                </div>
            @endif

            <!-- Mensaje de confirmación -->
            @if($showConfirmation)
                <div class="bg-green-50 border border-green-200 p-8 rounded-2xl shadow-lg text-center fade-in-up">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-green-700 mb-2">¡Cita Confirmada!</h3>
                    <p class="text-green-600 mb-2">Tu cita ha sido reservada exitosamente.</p>
                    <div class="bg-green-100 p-4 rounded-xl mb-4">
                        <p class="text-green-700 font-medium">{{ $this->getFormattedSelectedDate() }}</p>
                        <p class="text-green-700 font-medium">{{ $selectedTime }}</p>
                    </div>
                    <p class="text-sm text-green-600 mb-6">Recibirás un recordatorio 24 horas antes de tu cita.</p>
                    
                    <div class="space-y-3">
                        <button 
                            wire:click="resetSelection"
                            class="px-6 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-xl transition"
                        >
                            Reservar otra cita
                        </button>
                        <a href="/mis-citas" class="block px-6 py-2 text-pink-600 hover:text-pink-700 font-medium transition">
                            Ver mis citas
                        </a>
                    </div>
                </div>
            @endif

            <!-- Mensaje de cierre -->
            <div class="mt-10 text-center text-pink-700 text-sm opacity-90 fade-in-up">
                <p>Estoy emocionada de conocerte pronto. 🌸</p>
            </div>
        </div>
    </div>
</div>