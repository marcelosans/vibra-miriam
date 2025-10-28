<div class="py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-5xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">

    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-30 animate-pulse"></div>
        <div class="absolute top-1/2 -left-20 w-32 h-32 bg-rose-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 right-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-25 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Contenido principal -->
    <div class="relative z-10">

        <!-- Encabezado -->
        <div class="text-center mb-12">
            <div class="inline-block relative mb-6">
                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-pink-200 to-rose-300 p-1 shadow-lg">
                    <div class="w-full h-full rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-pink-500 to-rose-600 bg-clip-text text-transparent mb-4">
                Mi Perfil
            </h1>
            <p class="text-pink-600 font-medium text-xl">Gestiona tu información personal</p>
        </div>

        <!-- Mensajes de éxito/error -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-xl text-center animate-bounce">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Pestañas -->
        <div class="mb-8">
            <div class="flex justify-center">
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-2 shadow-lg border border-pink-100">
                    <div class="flex space-x-2">
                        <button wire:click="switchTab('profile')" 
                                class="px-6 py-3 rounded-xl font-semibold transition duration-300 flex items-center space-x-2 {{ $activeTab === 'profile' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white' : 'text-gray-600 hover:text-pink-500' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span>Información Personal</span>
                        </button>
                        <button wire:click="switchTab('password')" 
                                class="px-6 py-3 rounded-xl font-semibold transition duration-300 flex items-center space-x-2 {{ $activeTab === 'password' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white' : 'text-gray-600 hover:text-pink-500' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18,8h-1V6c0-2.76-2.24-5-5-5S7,3.24,7,6v2H6c-1.1,0-2,0.9-2,2v10c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V10C20,8.9,19.1,8,18,8z M12,17c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S13.1,17,12,17z M15.1,8H8.9V6c0-1.71,1.39-3.1,3.1-3.1s3.1,1.39,3.1,3.1V8z"/>
                            </svg>
                            <span>Seguridad</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido de la pestaña Perfil -->
        <div class="{{ $activeTab === 'profile' ? 'block' : 'hidden' }}">
            <form wire:submit.prevent="guardarPerfil" class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-pink-100 space-y-6 mb-8">
                
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre *</label>
                    <input type="text" id="nombre" wire:model="nombre"
                           class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('nombre') border-red-500 @enderror"
                           placeholder="Tu nombre" required>
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Apellidos en una fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="primerApellido" class="block text-sm font-semibold text-gray-700 mb-1">Primer apellido *</label>
                        <input type="text" id="primerApellido" wire:model="primerApellido"
                               class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('primerApellido') border-red-500 @enderror"
                               placeholder="Primer apellido" required>
                        @error('primerApellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="segundoApellido" class="block text-sm font-semibold text-gray-700 mb-1">Segundo apellido </label>
                        <input type="text" id="segundoApellido" wire:model="segundoApellido"
                               class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('segundoApellido') border-red-500 @enderror"
                               placeholder="Segundo apellido" >
                        @error('segundoApellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Email y teléfono en una fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico *</label>
                        <input type="email" id="email" wire:model="email"
                               class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('email') border-red-500 @enderror"
                               placeholder="ejemplo@correo.com" required>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-1">Número de teléfono *</label>
                        <input type="tel" id="telefono" wire:model="telefono"
                               class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('telefono') border-red-500 @enderror"
                               placeholder="+34 612 345 678" required>
                        @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-center gap-4 pt-4">
                    <button type="button"
                            class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md transition duration-300"
                            onclick="window.history.back()">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-semibold rounded-xl shadow-md transition duration-300 transform hover:scale-105"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Guardar cambios</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Contenido de la pestaña Contraseña -->
        <div class="{{ $activeTab === 'password' ? 'block' : 'hidden' }}">
            <form wire:submit.prevent="cambiarContrasena" class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-pink-100 space-y-6 mb-8">
                
                <!-- Información de seguridad -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,17A1.5,1.5 0 0,1 10.5,15.5A1.5,1.5 0 0,1 12,14A1.5,1.5 0 0,1 13.5,15.5A1.5,1.5 0 0,1 12,17M12,10.5A1.5,1.5 0 0,1 10.5,9A1.5,1.5 0 0,1 12,7.5A1.5,1.5 0 0,1 13.5,9A1.5,1.5 0 0,1 12,10.5Z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-blue-800 mb-1">Consejos para una contraseña segura:</h3>
                            <ul class="text-blue-700 text-sm space-y-1">
                                <li>• Al menos 8 caracteres de longitud</li>
                                <li>• Incluye mayúsculas, minúsculas, números y símbolos</li>
                                <li>• Evita información personal fácil de adivinar</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contraseña actual -->
                <div>
                    <label for="currentPassword" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña actual *</label>
                    <div class="relative">
                        <input type="password" id="currentPassword" wire:model="currentPassword"
                               class="w-full px-4 py-3 pr-12 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('currentPassword') border-red-500 @enderror"
                               placeholder="Ingresa tu contraseña actual" required>
                        <button type="button" onclick="togglePasswordVisibility('currentPassword')" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-400 hover:text-pink-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                            </svg>
                        </button>
                    </div>
                    @error('currentPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Nueva contraseña -->
                <div>
                    <label for="newPassword" class="block text-sm font-semibold text-gray-700 mb-1">Nueva contraseña *</label>
                    <div class="relative">
                        <input type="password" id="newPassword" wire:model.lazy="newPassword"
                               class="w-full px-4 py-3 pr-12 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('newPassword') border-red-500 @enderror"
                               placeholder="Ingresa tu nueva contraseña" required>
                        <button type="button" onclick="togglePasswordVisibility('newPassword')" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-400 hover:text-pink-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Indicador de fortaleza de contraseña -->
                    <div class="mt-2">
                        <div class="flex space-x-1">
                            @php
                                $strength = $this->getPasswordStrength();
                                $color = $this->getPasswordStrengthColor();
                            @endphp
                            @for($i = 1; $i <= 4; $i++)
                                <div class="h-2 w-1/4 rounded-full transition-colors duration-300 
                                    @if($strength >= $i * 25) 
                                        @if($color === 'red') bg-red-500
                                        @elseif($color === 'orange') bg-orange-500
                                        @elseif($color === 'yellow') bg-yellow-500
                                        @elseif($color === 'green') bg-green-500
                                        @else bg-gray-200
                                        @endif
                                    @else bg-gray-200
                                    @endif">
                                </div>
                            @endfor
                        </div>
                        <p class="text-xs mt-1 
                            @if($color === 'red') text-red-600
                            @elseif($color === 'orange') text-orange-600
                            @elseif($color === 'yellow') text-yellow-600
                            @elseif($color === 'green') text-green-600
                            @else text-gray-500
                            @endif">
                            {{ $this->getPasswordStrengthText() }}
                        </p>
                    </div>
                    @error('newPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Confirmar nueva contraseña -->
                <div>
                    <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar nueva contraseña *</label>
                    <div class="relative">
                        <input type="password" id="confirmPassword" wire:model="newPasswordConfirmation"
                               class="w-full px-4 py-3 pr-12 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition duration-300 @error('newPasswordConfirmation') border-red-500 @enderror"
                               placeholder="Confirma tu nueva contraseña" required>
                        <button type="button" onclick="togglePasswordVisibility('confirmPassword')" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-400 hover:text-pink-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                            </svg>
                        </button>
                    </div>
                    @if($newPassword && $newPasswordConfirmation)
                        @if($newPassword === $newPasswordConfirmation)
                            <p class="text-xs text-green-600 mt-1">✓ Las contraseñas coinciden</p>
                        @else
                            <p class="text-xs text-red-600 mt-1">✗ Las contraseñas no coinciden</p>
                        @endif
                    @endif
                    @error('newPasswordConfirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-center gap-4 pt-4">
                    <button type="button" wire:click="switchTab('profile')"
                            class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md transition duration-300">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-semibold rounded-xl shadow-md transition duration-300 transform hover:scale-105"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Cambiar contraseña</span>
                        <span wire:loading>Cambiando...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Información adicional -->
        <div class="text-center text-pink-600 text-sm opacity-90">
            <p class="mb-2">Los campos marcados con (*) son obligatorios</p>
            <p>Tu información está segura con nosotros 🌸</p>
        </div>
    </div>

    <script>
        // Función para alternar visibilidad de contraseña
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>
</div>