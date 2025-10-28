<!-- Página de contacto -->
<div class="py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-4xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">

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
                            <path d="M21 8V7l-3 2-2-2-3 3-2-2-6 6v3h18V8z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <h1 class="text-5xl font-bold gradient-text mb-4">Contacto</h1>
            <p class="text-pink-600 font-medium text-xl">Estoy aquí para escucharte. ¿Hablamos?</p>
        </div>

        <!-- Formulario -->
        <form wire:submit.prevent="enviar" class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-pink-100 space-y-6 mb-16">

    <div>
        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
        <input type="text" id="nombre" wire:model="nombre"
               class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent">
        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
        <input type="email" id="email" wire:model="email"
               class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="mensaje" class="block text-sm font-semibold text-gray-700 mb-1">Mensaje</label>
        <textarea id="mensaje" wire:model="mensaje" rows="5"
                  class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent"></textarea>
        @error('mensaje') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="text-center">
        <button type="submit"
                class="px-8 py-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-xl shadow-md transition duration-300">
            Enviar mensaje
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mt-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif
</form>


        <!-- Mapa de localización -->
        <div class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-pink-100 fade-in-up h-80 relative">
            {!! $contacto->ubicacion !!}
        </div>



        <!-- Redes sociales -->
        <div class="text-center space-y-4 mb-6">
            <h2 class="text-2xl font-semibold text-pink-700 mb-2">Sígueme en redes</h2>
            <div class="flex justify-center gap-6 text-pink-500 text-2xl">
                @foreach ($redes_sociales as $social)
                        <a href="{{ $social->perfil_url }}">
                            {!! str_replace('<svg', '<svg width="1000" height="1000"', $social->icono_svg) !!}
                        </a>
                      @endforeach
            </div>
        </div>

        <!-- Mensaje de cierre -->
        <div class="mt-10 text-center text-pink-700 text-sm opacity-90 fade-in-up">
            <p>No estás sola. Estoy aquí para ti. 🌸</p>
        </div>
    </div>
</div>
