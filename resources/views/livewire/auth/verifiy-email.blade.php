<div class="min-h-screen bg-gradient-to-br from-rose-50 via-pink-50 to-rose-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full flex items-center justify-center shadow-lg mb-6">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-extrabold text-gray-800 mb-2">Verifica tu Correo</h2>
            <p class="text-lg text-gray-600">Te hemos enviado un enlace de verificación</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-xl p-10">
            <!-- Success Message -->
            @if (session('resent'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-green-700 font-medium">
                            ¡Correo enviado! Revisa tu bandeja de entrada.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Verification Info -->
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-10 w-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    Antes de continuar, por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar.
                </p>
            </div>

            <!-- Email Check Instructions -->
            <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Revisa tu correo:</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-pink-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span>Busca un correo de nuestro equipo</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-pink-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span>Revisa tu carpeta de spam si no lo encuentras</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-pink-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span>Haz clic en el enlace de verificación</span>
                    </li>
                </ul>
            </div>

            <!-- Resend Email Form -->
            <div class="space-y-4">
                <p class="text-sm text-gray-600 text-center">
                    ¿No recibiste el correo?
                </p>
                
                <form wire:submit.prevent="resend">
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-2xl text-white bg-gradient-to-r from-pink-400 to-rose-400 hover:from-pink-500 hover:to-rose-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reenviar Correo de Verificación
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Enviando...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">o</span>
                </div>
            </div>

            <!-- Logout Link -->
            <div class="text-center">
                <form wire:submit.prevent="logout" class="inline">
                    <button 
                        type="submit"
                        class="text-sm font-medium text-pink-400 hover:text-pink-500 transition-colors"
                    >
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Message -->
        <div class="text-center">
            <p class="text-sm text-gray-500">
                Estamos emocionados de tenerte con nosotros
            </p>
        </div>
    </div>
</div>
