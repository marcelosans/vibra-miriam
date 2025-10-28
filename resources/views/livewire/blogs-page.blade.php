<div class="py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-7xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">
    
    <!-- Elementos decorativos de fondo -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-30 float-animation"></div>
        <div class="absolute top-1/2 -left-20 w-32 h-32 bg-rose-200 rounded-full opacity-20 float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 right-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-25 float-animation" style="animation-delay: 2s;"></div>
    </div>

    <!-- Contenido principal -->
    <div class="relative z-10">
        
        <!-- Header del Blog -->
        <div class="text-center mb-12 fade-in-up">
            <div class="inline-block relative mb-6">
                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-pink-200 to-rose-300 p-1 shadow-lg">
                    <div class="w-full h-full rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <h1 class="text-5xl font-bold gradient-text mb-4">Mi Blog</h1>
            <p class="text-pink-600 font-medium text-xl">Reflexiones sobre sanación, crecimiento personal y transformación</p>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 mb-12 shadow-lg border border-pink-100 fade-in-up">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                
                <!-- Búsqueda por título -->
                <div class="flex-1 max-w-md">
        <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </svg>
        </div>
        <input type="text" 
               wire:model="searchTitle"
               placeholder="Buscar por título..." 
               class="block w-full pl-10 pr-3 py-3 border border-pink-200 rounded-xl leading-5 bg-white placeholder-pink-400 focus:outline-none focus:placeholder-pink-300 focus:ring-2 focus:ring-pink-400 focus:border-transparent">
    </div>
</div>


            
            </div>
        </div>

        <!-- Grid de entradas del blog -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

  @foreach($blogs as $blog)
        <article class="blog-card bg-white rounded-2xl overflow-hidden shadow-lg border border-pink-100 fade-in-up">
            <div class="h-48 bg-gradient-to-br from-pink-200 to-rose-300 relative overflow-hidden">
                @if($blog->imagen_destacada)
                    <img src="{{ Storage::url($blog->imagen_destacada) }}" 
                         alt="{{ $blog->titulo_blog }}" 
                         class="w-full h-full object-cover">
                @else
                    <img src="https://source.unsplash.com/featured/?blog" 
                         alt="{{ $blog->titulo_blog }}" 
                         class="w-full h-full object-cover">
                @endif
            </div>

            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3 hover:text-pink-600 transition-colors cursor-pointer">
                    <a href="blog-detail/{{$blog->slug }}">{{ $blog->titulo_blog }}</a>
                </h3>

                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                   Publicado {{ \Carbon\Carbon::parse($blog->fecha)->format('d \d\e F, Y') }}
                </p>
            </div>
        </article>
    @endforeach

        </div>

       
       

        <!-- Mensaje inspirador de cierre -->
        <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl p-8 text-white text-center shadow-xl fade-in-up">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <p class="text-lg font-medium mb-2">Cada artículo es un abrazo para tu alma</p>
            <p class="opacity-90">Espero que estas reflexiones te acompañen en tu camino de sanación y crecimiento. <strong>No estás sola en este viaje.</strong></p>
            
            <div class="mt-6">
                <p class="text-xl font-bold">Con amor infinito, Miriam ✨</p>
                <div class="flex justify-center gap-2 mt-4">
                    <div class="w-2 h-2 bg-white rounded-full opacity-60"></div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-80"></div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-60"></div>
                </div>
            </div>
        </div>

    </div>
</div>