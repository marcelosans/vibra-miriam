{{-- resources/views/livewire/mis-citas.blade.php --}}
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

        .status-confirmado {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .status-pendiente {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .status-cancelado {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(236, 72, 153, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);
        }

        .btn-secondary {
            background: white;
            border: 2px solid #fbcfe8;
            color: #ec4899;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #fce7f3;
            border-color: #ec4899;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .badge-hoy {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        .cita-pasada {
            opacity: 0.6;
        }
    </style>

    <!-- Página de gestionar citas -->
    <div class="py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-6xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">

        <!-- Elementos decorativos -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-30 float-animation"></div>
            <div class="absolute top-1/2 -left-20 w-32 h-32 bg-rose-200 rounded-full opacity-20 float-animation" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 right-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-25 float-animation" style="animation-delay: 2s;"></div>
        </div>

        <!-- Contenido principal -->
        <div class="relative z-10">

            <!-- Encabezado -->
            <div class="text-center mb-12">
                <div class="inline-block relative mb-6">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-pink-200 to-rose-300 p-1 shadow-lg">
                        <div class="w-full h-full rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <h1 class="text-5xl font-bold gradient-text mb-4">Mis Citas</h1>
                <p class="text-pink-600 font-medium text-xl">Gestiona tus citas programadas</p>
            </div>

            <!-- Lista de citas -->
            @if(empty($this->getCitas()))
                <div class="text-center py-12">
                    <div class="w-32 h-32 mx-auto mb-6 bg-pink-100 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-pink-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">No tienes citas programadas</h3>
                    
                </div>
            @else
                <div class="space-y-6 mb-8">
                    @foreach($this->getCitas() as $cita)
                        <div class="bg-white/70 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-pink-100 card-hover fade-in-up {{ $cita['ya_paso'] ? 'cita-pasada' : '' }}">
                            <div class="flex flex-col md:flex-row md:items-center justify-between">
                                <!-- Información de la cita -->
                                <div class="flex-1 mb-4 md:mb-0">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-pink-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                        </svg>
                                        <span class="text-lg font-semibold text-gray-800">{{ $cita['fecha'] }}</span>
                                        @if($cita['es_hoy'])
                                            <span class="ml-2 badge-hoy">¡HOY!</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-pink-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm1-11h-2v6l5.25 3.15.75-1.23L13 14.75V7z"/>
                                        </svg>
                                        <span class="text-gray-600 font-medium">{{ $cita['hora'] }}</span>
                                        <span class="ml-3 text-sm text-gray-500">({{ $cita['duracion'] }})</span>
                                    </div>
                                </div>

                                <!-- Estado y acciones -->
                                <div class="flex items-center justify-between md:flex-col md:items-end md:justify-center space-y-0 md:space-y-3">
                                    <div class="px-4 py-2 rounded-full text-sm font-semibold status-{{ $cita['estado'] }}">
                                        @if($cita['estado'] === 'confirmado')
                                            ✓ Confirmada
                                        @elseif($cita['estado'] === 'pendiente')
                                            ⏳ Pendiente
                                        @else
                                            ✕ Cancelada
                                        @endif
                                    </div>

                                    <!-- Botón de cancelar -->
                                    @if($cita['estado'] !== 'cancelado')
                                        <div class="flex space-x-2">
                                            @if($cita['puede_cancelar'])
                                                <button 
                                                  wire:click="showCancelModal({{ $cita['id'] }})"
                                                    class="px-4 py-2 btn-danger text-white text-sm font-medium rounded-xl"
                                                >
                                                    Cancelar Cita
                                                </button>
                                            @else
                                                <div class="px-4 py-2 bg-gray-100 text-gray-500 text-sm font-medium rounded-xl cursor-not-allowed">
                                                    No se puede cancelar
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Información adicional para citas que no se pueden cancelar -->
                            @if($cita['estado'] !== 'cancelado' && !$cita['puede_cancelar'])
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                                    <p class="text-yellow-700 text-sm">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                        Las cancelaciones deben realizarse con al menos 24 horas de anticipación.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Botón para nueva cita -->
            <div class="text-center mb-10">
                <button 
                    wire:click="nuevaCita"
                    class="px-8 py-4 btn-primary text-white font-semibold rounded-xl shadow-lg"
                >
                    + Reservar Nueva Cita
                </button>
            </div>

            <!-- Modal de cancelar cita -->
            @if($showCancelModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop">
                    <div class="bg-white rounded-2xl p-8 mx-4 max-w-md w-full shadow-2xl transform transition-all">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Cancelar Cita</h3>
                            <p class="text-gray-600">¿Estás segura de que quieres cancelar esta cita?</p>
                        </div>

                        <div class="bg-red-50 p-4 rounded-xl mb-6 border border-red-200">
                            <p class="text-red-700 text-sm">
                                <strong>Nota:</strong> Una vez cancelada, la cita no se puede recuperar. Deberás reservar una nueva cita si cambias de opinión.
                            </p>
                        </div>

                        <div class="flex space-x-3">
                            <button 
                                wire:click="closeCancelModal"
                                class="flex-1 px-4 py-3 btn-secondary font-medium rounded-xl"
                            >
                                No, mantener
                            </button>
                            <button 
                                wire:click="confirmCancel"
                                class="flex-1 px-4 py-3 btn-danger text-white font-medium rounded-xl"
                            >
                                Sí, cancelar
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mensaje de confirmación -->
            @if($showConfirmationMessage)
                <div class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop">
                    <div class="bg-white rounded-2xl p-8 mx-4 max-w-md w-full shadow-2xl transform transition-all">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-green-700 mb-2">¡Listo!</h3>
                            <p class="text-green-600 mb-6">{{ $confirmationMessage }}</p>
                            
                            <button 
                                wire:click="closeConfirmationMessage"
                                class="px-6 py-3 btn-primary text-white font-semibold rounded-xl"
                            >
                                Entendido
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mensaje de cierre -->
            <div class="mt-10 text-center text-pink-700 text-sm opacity-90 fade-in-up">
                <p>¡Siempre estoy aquí para cuidar de tu belleza! 🌸</p>
            </div>
        </div>
    </div>
</div>