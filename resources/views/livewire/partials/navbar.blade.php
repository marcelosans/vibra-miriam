{{-- resources/views/livewire/partials/navbar.blade.php --}}
<header class="bg-white/80 backdrop-blur-md border-b border-pink-100 shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent hover:from-pink-600 hover:to-purple-600 transition-all duration-300">
                    Vibra con Miriam
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-8">
                <div class="flex items-baseline space-x-6">
                    <a href="/sobre-mi" class="text-pink-600 hover:text-purple-500 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-pink-50">
                        Sobre Mí
                    </a>
                    <div class="relative group">
                      <button type="button" class="text-pink-600 hover:text-purple-500 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-pink-50 inline-flex items-center">
                          Servicios
                          <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                          </svg>
                      </button>
                      <div class="absolute z-50 mt-2 w-48 bg-white border border-pink-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 delay-100">
                          @foreach ($services as $service)
                              <a href="servicio/{{$service->slug}}" class="block px-4 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors duration-200">{{$service->nombre}}</a>
                          @endforeach
                       
                         
                      </div>
                  </div>
                    <a href="/blog" class="text-pink-600 hover:text-purple-500 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-pink-50">
                        Blog
                    </a>
                    <a href="/contacto" class="text-pink-600 hover:text-purple-500 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-pink-50">
                        Contacto
                    </a>
                    <a href="/reservar-cita" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-medium hover:from-pink-600 hover:to-purple-600 transform hover:scale-105 transition-all duration-200 shadow-md">
                        Reservar Cita
                    </a>
                </div>

                {{-- Conditional Authentication Section --}}
                @if($isAuthenticated)
                    {{-- Profile Dropdown (Authenticated) --}}
                    <div class="relative">
                        <button type="button" 
                                class="flex items-center gap-x-2 py-2 px-3 text-sm font-medium rounded-lg border border-pink-200 bg-white/80 text-pink-700 shadow-sm hover:bg-pink-50 focus:outline-none focus:bg-pink-50 transition-colors"
                                id="profile-dropdown-toggle"
                                aria-expanded="false"
                                aria-haspopup="true">
                            <span class="hidden lg:block">{{ $user->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div id="profile-dropdown" 
                             class="hidden absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg border border-pink-200 z-50"
                             role="menu" 
                             aria-orientation="vertical" 
                             aria-labelledby="profile-dropdown-toggle">
                            <div class="py-1">
                                <div class="px-4 py-3 border-b border-pink-100">
                                    <p class="text-sm font-medium text-pink-900">{{ $user->name }} {{ $user->apellido }}</p>
                                    <p class="text-xs text-pink-500">{{ $user->email }}</p>
                                    @if($user->telefono)
                                        <p class="text-xs text-pink-400 mt-1">{{ $user->telefono_formateado }}</p>
                                    @endif
                                </div>
                                <a href="" class="flex items-center px-4 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors" role="menuitem">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" clip-rule="evenodd"/>
                                    </svg>
                                    Editar Perfil
                                </a>
                                <a href="" class="flex items-center px-4 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors" role="menuitem">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Mis Citas
                                </a>
                                <div class="border-t border-pink-100 my-1"></div>
                                <button wire:click="logout" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left" role="menuitem">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Login/Register Links (Not Authenticated) --}}
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-pink-600 hover:text-purple-500 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-pink-50">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-medium hover:from-pink-600 hover:to-purple-600 transform hover:scale-105 transition-all duration-200 shadow-md">
                            Registrarse
                        </a>
                    </div>
                @endif
            </div>

            {{-- Mobile menu button --}}
            <div class="md:hidden">
                <button type="button" 
                        class="bg-white/70 backdrop-blur-sm p-2 rounded-lg text-pink-600 hover:text-purple-500 hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all duration-200"
                        id="mobile-menu-toggle">
                    <svg class="h-6 w-6 hamburger-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6 close-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white/90 backdrop-blur-sm rounded-b-xl border-t border-pink-100 mt-2">
                {{-- Navigation Links --}}
                <a href="/sobre-mi" class="text-pink-600 hover:text-purple-500 block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 hover:bg-pink-50">
                    Sobre Mí
                </a>
                <div class="relative group">
                      <button type="button" class="text-pink-600 hover:text-purple-500 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-pink-50 inline-flex items-center">
                          Servicios
                          <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                          </svg>
                      </button>
                      <div class="absolute z-50 mt-2 w-48 bg-white border border-pink-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 delay-100">
                          <a href="#" class="block px-4 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors duration-200">Terapia Individual</a>
                          <a href="#" class="block px-4 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors duration-200">Terapia de Pareja</a>
                          <a href="#" class="block px-4 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors duration-200">Sesiones Online</a>
                      </div>
                  </div>
                <a href="/blog" class="text-pink-600 hover:text-purple-500 block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 hover:bg-pink-50">
                    Blog
                </a>
                <a href="/contacto" class="text-pink-600 hover:text-purple-500 block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 hover:bg-pink-50">
                    Contacto
                </a>
                <a href="/reservar-cita" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white block px-3 py-2 rounded-lg text-base font-medium hover:from-pink-600 hover:to-purple-600 transition-all duration-200 shadow-md mt-3">
                    Reservar Cita
                </a>
                
                {{-- Mobile Authentication Section --}}
                @if($isAuthenticated)
                    {{-- Mobile Profile Dropdown (Authenticated) --}}
                    <div class="border-t border-pink-200 mt-4 pt-4">
                        <button type="button" 
                                class="flex items-center justify-between w-full px-3 py-2 text-left bg-white/50 backdrop-blur-sm rounded-lg border border-pink-200 hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all duration-200"
                                id="mobile-profile-dropdown-toggle"
                                aria-expanded="false"
                                aria-haspopup="true">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold mr-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-pink-900">{{ $user->name }} {{ $user->apellido }}</p>
                                    <p class="text-xs text-pink-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-pink-600 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        {{-- Mobile Profile Dropdown Menu --}}
                        <div id="mobile-profile-dropdown" 
                             class="hidden mt-2 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg border border-pink-200"
                             role="menu" 
                             aria-orientation="vertical" 
                             aria-labelledby="mobile-profile-dropdown-toggle">
                            <div class="py-1">    
                                <a href="" class="flex items-center px-3 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors duration-200" role="menuitem">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" clip-rule="evenodd"/>
                                    </svg>
                                    Editar Perfil
                                </a>
                                
                                <a href="" class="flex items-center px-3 py-2 text-sm text-pink-700 hover:bg-pink-50 transition-colors duration-200" role="menuitem">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Mis Citas
                                </a>
                                
                                <div class="border-t border-pink-200 my-1"></div>
                                <button wire:click="logout" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200 text-left" role="menuitem">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Mobile Login/Register Links (Not Authenticated) --}}
                    <div class="border-t border-pink-200 mt-4 pt-4 space-y-2">
                        <a href="{{ route('login') }}" class="text-pink-600 hover:text-purple-500 block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 hover:bg-pink-50">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white block px-3 py-2 rounded-lg text-base font-medium hover:from-pink-600 hover:to-purple-600 transition-all duration-200 shadow-md">
                            Registrarse
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</header>

{{-- JavaScript para funcionalidad del navbar --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.querySelector('.hamburger-icon');
        const closeIcon = document.querySelector('.close-icon');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                const isHidden = mobileMenu.classList.contains('hidden');
                
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            });

            // Cerrar menú móvil al hacer clic en un enlace
            const mobileLinks = mobileMenu.querySelectorAll('a:not([role="menuitem"])');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                });
            });

            // Cerrar menú móvil al redimensionar la ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            });
        }

        // Funcionalidad del dropdown de perfil móvil
        const mobileProfileDropdownToggle = document.getElementById('mobile-profile-dropdown-toggle');
        const mobileProfileDropdown = document.getElementById('mobile-profile-dropdown');
        
        if (mobileProfileDropdownToggle && mobileProfileDropdown) {
            const mobileProfileChevron = mobileProfileDropdownToggle.querySelector('svg:last-child');

            mobileProfileDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isExpanded = mobileProfileDropdownToggle.getAttribute('aria-expanded') === 'true';
                
                if (isExpanded) {
                    mobileProfileDropdown.classList.add('hidden');
                    mobileProfileDropdownToggle.setAttribute('aria-expanded', 'false');
                    if (mobileProfileChevron) mobileProfileChevron.style.transform = 'rotate(0deg)';
                } else {
                    mobileProfileDropdown.classList.remove('hidden');
                    mobileProfileDropdownToggle.setAttribute('aria-expanded', 'true');
                    if (mobileProfileChevron) mobileProfileChevron.style.transform = 'rotate(180deg)';
                }
            });

            // Cerrar dropdown móvil del perfil al hacer clic en un enlace
            const mobileProfileLinks = mobileProfileDropdown.querySelectorAll('a[role="menuitem"], button[role="menuitem"]');
            mobileProfileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Cerrar dropdown del perfil
                    mobileProfileDropdown.classList.add('hidden');
                    mobileProfileDropdownToggle.setAttribute('aria-expanded', 'false');
                    if (mobileProfileChevron) mobileProfileChevron.style.transform = 'rotate(0deg)';
                    
                    // Cerrar menú móvil completo
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                });
            });
        }

        // Funcionalidad del dropdown de perfil
        const profileDropdownToggle = document.getElementById('profile-dropdown-toggle');
        const profileDropdown = document.getElementById('profile-dropdown');
        
        if (profileDropdownToggle && profileDropdown) {
            const profileChevron = profileDropdownToggle.querySelector('svg:last-child');

            profileDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isExpanded = profileDropdownToggle.getAttribute('aria-expanded') === 'true';
                
                if (isExpanded) {
                    profileDropdown.classList.add('hidden');
                    profileDropdownToggle.setAttribute('aria-expanded', 'false');
                    if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
                } else {
                    profileDropdown.classList.remove('hidden');
                    profileDropdownToggle.setAttribute('aria-expanded', 'true');
                    if (profileChevron) profileChevron.style.transform = 'rotate(180deg)';
                }
            });

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!profileDropdownToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                    profileDropdownToggle.setAttribute('aria-expanded', 'false');
                    if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
                }
            });

            // Cerrar dropdown con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    profileDropdown.classList.add('hidden');
                    profileDropdownToggle.setAttribute('aria-expanded', 'false');
                    if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
                }
            });
        }
    });
</script>