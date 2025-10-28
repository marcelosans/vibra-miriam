<div class="container mx-auto px-4 py-12 max-w-7xl text-gray-800">

    <!-- ¿Quién Soy? -->
    <section class="bg-gradient-to-r from-rose-100 to-pink-50 rounded-3xl p-10 mb-16 shadow-xl">
        <div class="flex flex-col lg:flex-row items-center gap-10">
            <div class="flex-1">
                <h1 class="text-4xl font-extrabold mb-6">¿Quién Soy?</h1>
                <div class="space-y-5 text-lg leading-relaxed">
                    <p>Soy una profesional apasionada por el desarrollo personal y el bienestar integral. Mi enfoque se centra en ayudar a las personas a descubrir su potencial y alcanzar sus objetivos de vida de manera equilibrada y saludable.</p>
                    <p>Con años de experiencia en el campo del desarrollo humano, me especializo en técnicas de relajación, mindfulness y crecimiento personal. Mi misión es acompañarte en tu proceso de transformación y ayudarte a encontrar la paz interior que buscas.</p>
                    <p>Creo firmemente en el poder de la mente y en la capacidad que todos tenemos para crear cambios positivos en nuestras vidas. Mi trabajo se basa en la confianza, el respeto y la comprensión profunda de las necesidades individuales de cada persona.</p>
                </div>
                <div class="mt-10">
                <a href="#" class="inline-block bg-pink-400 text-white px-8 py-3 rounded-full font-semibold hover:bg-pink-500 transition">Descubrir mas sobre mi</a>
            </div>
            </div>
            <div class="lg:w-1/3">
                <div class="rounded-3xl overflow-hidden shadow-md">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616c5e95e34?w=300&h=300&fit=crop&crop=face" alt="Perfil profesional" class="w-full h-72 object-cover">
                </div>
            </div>
             
        </div>
    </section>

    <!-- Mis Servicios -->
    <section class="mb-20">
        <h2 class="text-4xl font-bold text-center mb-12">Mis Servicios</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach ($services as $servicio)
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                    <img src="{{ url('storage', $servicio->miniatura) }}" alt="{{ $servicio->nombre }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">{{ $servicio->nombre }}</h3>
                        <p class="text-gray-600 mb-6">{{ $servicio->descripcion}}</p>
                        <a href="#" class="inline-block bg-pink-200 text-gray-700 px-5 py-2 rounded-full hover:bg-pink-300 transition-colors">Ver Más</a>
                    </div>
                </div>
            @endforeach

           
            
        </div>
        
    </section>

    <!-- Experiencia -->
    <section class="bg-gradient-to-r from-pink-50 to-rose-100 rounded-3xl p-12 mb-20 shadow-xl">
        <h2 class="text-4xl font-bold text-center mb-8">Vive la experiencia de la hipnoterapia</h2>
        <div class="max-w-3xl mx-auto text-center text-lg text-gray-700 leading-relaxed">
            <p class="mb-6">
                "Antes de probar la hipnoterapia, vivía con ansiedad constante. Me costaba dormir, tenía ataques de pánico y sentía que no tenía el control de mis emociones. A través de nuestras sesiones, aprendí a relajarme profundamente, a reconocer cuando empieza mi ansiedad y a transformar esos momentos tensos en oportunidades de crecimiento. Hoy día estoy mucho más tranquila, he aprendido a conocer mi mente y, sobretodo, he comprendido que tengo la capacidad de cambiar aquellos pensamientos limitantes que no dejan que me sienta bien conmigo misma. Recomiendo esta experiencia a cualquiera que quiera sentir desde adentro."
            </p>
            <p class="text-right italic text-gray-600">– María Hernández</p>
            <div class="mt-10">
                <a href="#" class="inline-block bg-pink-400 text-white px-8 py-3 rounded-full font-semibold hover:bg-pink-500 transition">Reservar Cita</a>
            </div>
        </div>
    </section>

    <!-- Blog -->
    <section class="mb-20">
        <h2 class="text-4xl font-bold text-center mb-12">Mi Blog</h2>
        <div class="grid md:grid-cols-2 gap-8">
            @foreach ($blogs as $articulo)
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                    <div class="relative">
                        <img src="{{ url('storage', $articulo->imagen_destacada) }}" alt="{{ $articulo->titulo_blog }}" class="w-full h-52 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">{{ $articulo->titulo_blog }}</h3>
                        <p class="text-gray-600 mb-4">Publicado en :{{ $articulo->fecha }}</p>
                        <a href="blog-detail/{{$articulo->slug}}" class="inline-block bg-pink-200 text-gray-700 px-5 py-2 rounded-full hover:bg-pink-300 transition">Ver Más</a>
                    </div>
                </div>
            @endforeach
            
        </div>

        <div class="text-center mt-12">
            <a href="#" class="bg-pink-400 text-white px-8 py-3 rounded-full font-semibold hover:bg-pink-500 transition">Ver Todos los Artículos</a>
        </div>
    </section>
</div>
