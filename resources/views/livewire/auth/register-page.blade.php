<div class="min-h-screen bg-gradient-to-br from-rose-50 via-pink-50 to-rose-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full flex items-center justify-center shadow-lg mb-6">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-extrabold text-gray-800 mb-2">Únete a Nosotros</h2>
            <p class="text-lg text-gray-600">Comienza tu proceso de transformación personal</p>
        </div>

        <!-- Status Messages -->
        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Register Form -->
        <div class="bg-white rounded-3xl shadow-xl p-10">
            <form wire:submit.prevent="register" class="space-y-6">
                
                <!-- Nombre y Primer Apellido -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input 
                                wire:model.live.debounce.300ms="nombre" 
                                id="nombre" 
                                name="nombre" 
                                type="text" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('nombre') border-red-300 @enderror"
                                placeholder="Tu nombre"
                            >
                        </div>
                        @error('nombre') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Primer Apellido -->
                    <div>
                        <label for="primer_apellido" class="block text-sm font-semibold text-gray-700 mb-2">
                            Primer Apellido
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input 
                                wire:model.live.debounce.300ms="primer_apellido" 
                                id="primer_apellido" 
                                name="primer_apellido" 
                                type="text" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('primer_apellido') border-red-300 @enderror"
                                placeholder="Primer apellido"
                            >
                        </div>
                        @error('primer_apellido') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Segundo Apellido -->
                <div>
                    <label for="segundo_apellido" class="block text-sm font-semibold text-gray-700 mb-2">
                        Segundo Apellido
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input 
                            wire:model.live.debounce.300ms="segundo_apellido" 
                            id="segundo_apellido" 
                            name="segundo_apellido" 
                            type="text" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('segundo_apellido') border-red-300 @enderror"
                            placeholder="Segundo apellido (opcional)"
                        >
                    </div>
                    @error('segundo_apellido') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input 
                            wire:model.live.debounce.500ms="email" 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('email') border-red-300 @enderror"
                            placeholder="tu@ejemplo.com"
                        >
                        @if($email && !$errors->has('email'))
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    @error('email') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                        Número de Teléfono
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input 
                            wire:model.live.debounce.300ms="telefono" 
                            id="telefono" 
                            name="telefono" 
                            type="tel" 
                            required 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('telefono') border-red-300 @enderror"
                            placeholder="+34 123 456 789"
                        >
                    </div>
                    @error('telefono') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Formato: +34XXXXXXXXX o XXXXXXXXX</p>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                wire:model.live.debounce.300ms="password" 
                                id="password" 
                                name="password" 
                                type="password" 
                                autocomplete="new-password" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('password') border-red-300 @enderror"
                                placeholder="••••••••"
                            >
                        </div>
                        @if($password)
                            <div class="mt-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs {{ $this->passwordStrength['color'] }}">
                                        {{ $this->passwordStrength['text'] }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                    <div class="h-1.5 rounded-full transition-all duration-300 
                                        @if($this->passwordStrength['strength'] == 1) bg-red-500 w-1/4
                                        @elseif($this->passwordStrength['strength'] == 2) bg-orange-500 w-2/4
                                        @elseif($this->passwordStrength['strength'] == 3) bg-yellow-500 w-3/4
                                        @elseif($this->passwordStrength['strength'] == 4) bg-green-500 w-full
                                        @else w-0 @endif">
                                    </div>
                                </div>
                            </div>
                        @endif
                        @error('password') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmar Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                wire:model.live.debounce.300ms="password_confirmation" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                autocomplete="new-password" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-colors text-gray-900 placeholder-gray-500 @error('password_confirmation') border-red-300 @enderror"
                                placeholder="••••••••"
                            >
                            @if($password_confirmation && $password === $password_confirmation)
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('password_confirmation') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            wire:model="terms" 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="h-4 w-4 text-pink-400 focus:ring-pink-400 border-gray-300 rounded @error('terms') border-red-300 @enderror"
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            Acepto los 
                            <a href="#" class="font-medium text-pink-400 hover:text-pink-500 transition-colors">
                                términos y condiciones
                            </a>
                            y la
                            <a href="#" class="font-medium text-pink-400 hover:text-pink-500 transition-colors">
                                política de privacidad
                            </a>
                        </label>
                        @error('terms') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-2xl text-white bg-gradient-to-r from-pink-400 to-rose-400 hover:from-pink-500 hover:to-rose-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        wire:loading.attr="disabled"
                        wire:target="register"
                    >
                        <span wire:loading.remove wire:target="register">
                            Crear Mi Cuenta
                        </span>
                        <span wire:loading wire:target="register" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creando cuenta...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="font-medium text-pink-400 hover:text-pink-500 transition-colors">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Message -->
        <div class="text-center">
            <p class="text-sm text-gray-500">
                Estás a un paso de comenzar tu transformación personal
            </p>
        </div>
    </div>
</div>