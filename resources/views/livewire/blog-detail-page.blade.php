<!-- Entrada de blog individual -->
<div class="py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-5xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">

    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-30 float-animation"></div>
        <div class="absolute top-1/2 -left-20 w-32 h-32 bg-rose-200 rounded-full opacity-20 float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 right-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-25 float-animation" style="animation-delay: 2s;"></div>
    </div>

    <!-- Contenido -->
    <div class="relative z-10">

        <!-- Banner con imagen destacada -->
        <div class="h-64 md:h-96 rounded-2xl overflow-hidden mb-10 shadow-lg relative">
            <img src="{{ Storage::url($blog->imagen_destacada) }}" alt="{{ $blog->titulo_blog }}"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-pink-100/20 to-rose-200/60"></div>
        </div>

        <!-- Encabezado del artículo -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold gradient-text mb-4">{{ $blog->titulo_blog }}</h1>
            <p class="text-pink-600 font-medium text-lg">Publicado {{ \Carbon\Carbon::parse($blog->fecha)->format('d \d\e F, Y') }}</p>
        </div>

        <!-- Contenido del artículo -->
        <div class="prose lg:prose-lg prose-p:text-gray-700 prose-p:leading-relaxed prose-headings:text-pink-700 max-w-none mb-16">
             {!! $blog->texto_blog !!}
        </div>

        <!-- Mensaje final -->
        <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl p-8 text-white text-center shadow-xl fade-in-up">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <p class="text-lg font-medium mb-2">Gracias por llegar hasta aquí</p>
            <p class="opacity-90">Espero que esta lectura te haya aportado calma y claridad. <strong>Vuelve siempre que lo necesites.</strong></p>

            <div class="mt-6">
                <p class="text-xl font-bold">Con amor, Miriam ✨</p>
                <div class="flex justify-center gap-2 mt-4">
                    <div class="w-2 h-2 bg-white rounded-full opacity-60"></div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-80"></div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-60"></div>
                </div>
            </div>
        </div>

    </div>
</div>
