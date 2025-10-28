<!-- Entrada de blog individual -->
<div class="mb-10 py-16 px-6 bg-gradient-to-br from-white via-pink-50 to-rose-50 text-gray-800 max-w-5xl mx-auto rounded-3xl shadow-2xl relative overflow-hidden">

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
            <img src="{{ Storage::url($service->minatura) }}" alt="Imagen destacada del artículo"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-pink-100/20 to-rose-200/60"></div>
        </div>

        <!-- Encabezado del artículo -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold gradient-text mb-4">{{$service->nombre}}</h1>
        </div>

        <!-- Contenido del artículo -->
        <div class="prose lg:prose-lg prose-p:text-gray-700 prose-p:leading-relaxed prose-headings:text-pink-700 max-w-none mb-16">
            <p>{{$service->descripcion}}</p>
        </div>

    </div>
</div>
