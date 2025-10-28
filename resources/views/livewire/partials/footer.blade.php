{{-- resources/views/components/vibra-con-miriam.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <header class="text-center mb-12">
            <div class="inline-block p-8 bg-white/70 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100">
                <h1 class="text-5xl font-bold bg-gradient-to-r from-pink-500 via-rose-400 to-purple-500 bg-clip-text text-transparent mb-2">
                    Vibra con
                </h1>
                <h2 class="text-6xl font-extrabold bg-gradient-to-r from-purple-500 via-pink-500 to-rose-400 bg-clip-text text-transparent">
                    Miriam
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-pink-300 to-purple-300 mx-auto mt-4 rounded-full"></div>
            </div>
        </header>

        <div class="grid lg:grid-cols-2 gap-12 items-start">
            {{-- Contactos Section --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-300">
                <h3 class="text-3xl font-semibold text-gray-700 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-pink-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    Contactos
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl hover:from-pink-100 hover:to-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-rose-400 mr-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <span class="text-gray-700 font-medium">{{$contacto->movil_formatted}}</span>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl hover:from-pink-100 hover:to-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-rose-400 mr-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <a href="mailto:Correo@gmail.com" class="text-rose-500 hover:text-rose-600 font-medium underline decoration-pink-200 hover:decoration-pink-400 transition-colors">
                            {{$contacto->correo}}
                        </a>
                    </div>
                </div>

                {{-- Redes Sociales --}}
                <div class="mt-8">
                    <h4 class="text-xl font-semibold text-gray-700 mb-4">Sigue-me !</h4>
                    <div class="flex space-x-4">

                       @foreach ($redes_sociales as $social)
                        <a href="{{ $social->perfil_url }}">
                            {!! str_replace('<svg', '<svg width="1000" height="1000"', $social->icono_svg) !!}
                        </a>
                      @endforeach

                    </div>
                </div>
            </div>

            {{-- Navegación Section --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-300">
                <h3 class="text-3xl font-semibold text-gray-700 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-purple-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Más Páginas
                </h3>
                
                <nav class="space-y-3">
                    <a href="#" class="group flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl hover:from-purple-100 hover:to-pink-100 transition-all duration-300 transform hover:translate-x-2">
                        <svg class="w-5 h-5 text-purple-400 mr-3 group-hover:text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium group-hover:text-gray-900">¿Donde Me Ubico?</span>
                    </a>
                    
                    <a href="#" class="group flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl hover:from-purple-100 hover:to-pink-100 transition-all duration-300 transform hover:translate-x-2">
                        <svg class="w-5 h-5 text-purple-400 mr-3 group-hover:text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <span class="text-gray-700 font-medium group-hover:text-gray-900">Contacta-me</span>
                    </a>
                </nav>
            </div>
        </div>

        {{-- Decorative Elements --}}
        <div class="fixed top-10 left-10 w-20 h-20 bg-pink-200/30 rounded-full blur-xl animate-pulse"></div>
        <div class="fixed top-32 right-20 w-16 h-16 bg-purple-200/30 rounded-full blur-xl animate-bounce"></div>
        <div class="fixed bottom-20 left-1/4 w-12 h-12 bg-rose-200/30 rounded-full blur-xl animate-pulse"></div>
        
        {{-- Footer --}}
        <footer class="text-center mt-16 p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-pink-100">
            <p class="text-gray-600 text-sm">
                © 2025 Marcel Lejk. Todos los derechos reservados.
            </p>
            <div class="flex justify-center items-center mt-4 space-x-2">
                <div class="w-2 h-2 bg-pink-300 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-purple-300 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-rose-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
        </footer>
    </div>
</div>

