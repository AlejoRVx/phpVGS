<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>{{ $producto->nombre }} - Reseñas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .neon-blue {
            background-color: #00efffff;
            box-shadow: 0 0 0px #00efffff, 0 0 0px #00efffff, 0 0 4px #00efffff;
        }
        .neon-blue:hover {
            box-shadow: 0 0 0px #00efffff, 0 0 0px #00efffff, 0 0 8px #00efffff;
        }
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
        }
        .star-rating {
            display: inline-flex;
            gap: 0.25rem;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            font-size: 2rem;
            color: #4b5563;
            transition: color 0.2s;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #fbbf24;
        }
    </style>
</head>
<body class="text-white">
    <header class="bg-gray-900 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-8 w-8 mr-2">
                    <a href="/main" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="/main" class="text-gray-300 hover:text-blue-400 transition duration-300">Inicio</a>
                    <a href="/juegos" class="text-gray-300 hover:text-blue-400 transition duration-300">Juegos</a>
                    <a href="/consolas" class="text-gray-300 hover:text-blue-400 transition duration-300">Consolas</a>
                    <a href="/pedidos" class="text-gray-300 hover:text-blue-400 transition duration-300"> 🛒 </a>
                    <a href="/logout" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500 transition duration-300">Cerrar sesión ⍈</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ url('/' . strtolower($producto->tipo)) . 's' }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-blue-400 hover:text-blue-300 hover:bg-gray-700 rounded-lg border-2 border-blue-400 transition duration-300 shadow-lg hover:shadow-blue-400/30">
                <span class="mr-2 text-xl">←</span> 
                <span class="font-semibold">Volver atrás</span>
            </a>
        </div>

        <section class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="rounded-lg shadow-xl max-h-96 w-full object-cover">
                </div>

                <div class="flex flex-col justify-center">
                    <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-4">
                        {{ $producto->nombre }}
                    </h1>

                    @if ($producto->tipo == "Juego")
                        <div class="mb-6">
                            <div class="flex items-center mb-3">
                                <span class="text-yellow-400 text-2xl mr-3">
                                    {{ str_repeat('⭐', floor($promedioCalificacion))}}
                                    @if($promedioCalificacion - floor($promedioCalificacion) > 0)
                                        ✨
                                    @endif
                                </span>
                                <span class="text-xl text-gray-300">{{ number_format($promedioCalificacion, 1) }}/5</span>
                                <span class="text-sm text-gray-500 ml-2">({{ $cantidadResenas }} reseña-s)</span>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-3 mb-6">
                        @if ($producto->tipo == "Juego")
                            <p class="text-gray-300">
                                <span class="font-semibold text-blue-400">Género:</span> {{ $producto->genero }}
                            </p>
                        @endif
                        <p class="text-gray-300">
                            <span class="font-semibold text-blue-400">Compañía:</span> {{ $producto->compania }}
                        </p>
                        <p class="text-gray-300">
                            <span class="font-semibold text-blue-400">Lanzamiento:</span> {{ $producto->fecha_lanzamiento->format('d/m/Y') }}
                        </p>
                    </div>

                    <p class="text-gray-400 mb-6 leading-relaxed">
                        {{ $producto->descripcion }}
                    </p>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                        <span class="text-4xl font-bold text-purple-400">
                            ${{ number_format($producto->precio, 2) }}
                        </span>
                        <form action="{{ route('pedidos.agregar', $producto->id) }}" method="POST" >
                            @csrf
                            <button class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50 text-lg" type="submit">
                                Añadir al carrito 🛒
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <hr class="border-t-2 border-gray-700 mb-12">

        @if ($producto->tipo == 'Juego')
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
                    💬 Reseñas de Usuarios
                </h2>

                <div class="bg-gray-800 rounded-xl shadow-2xl p-8 mb-8">
                    <h3 class="text-2xl font-semibold text-blue-400 mb-6">Deja tu reseña</h3>
                    
                    <form action="/juegos/resenas" method="POST">

                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="calificacion" class="block text-gray-300 font-semibold mb-3">Calificación:</label>
                            <select name="calificacion" id="calificacion" required
                                class="px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:shadow-lg focus:shadow-blue-400/30 transition duration-300">
                                <option value="">Selecciona una calificación</option>
                                <option value="5">⭐⭐⭐⭐⭐ - Excelente (5/5)</option>
                                <option value="4">⭐⭐⭐⭐ - Muy bueno (4/5)</option>
                                <option value="3">⭐⭐⭐ - Bueno (3/5)</option>
                                <option value="2">⭐⭐ - Regular (2/5)</option>
                                <option value="1">⭐ - Malo (1/5)</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="comentario" class="block text-gray-300 font-semibold mb-2">Comentario:</label>
                            <textarea name="comentario" id="comentario" rows="5" required
                                    class="w-full px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:shadow-lg focus:shadow-blue-400/30 transition duration-300 resize-none"
                                    placeholder="Cuéntanos qué te pareció este juego..."></textarea>
                        </div>

                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500">
                            Publicar Reseña 📝
                        </button>
                    </form>
                </div>

                @foreach ($resenas as $resena)
                    <div class="bg-gray-800 rounded-xl shadow-xl p-6 border-l-4 border-blue-400 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-400">
                                    Por <span class="font-semibold text-blue-400">Usuario Anónimo</span>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $resena->fecha->format('d/m/Y') }}
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <span class="text-yellow-400 text-xl">
                                    {{ str_repeat('⭐', $resena->calificacion) }}
                                </span>
                                <span class="text-sm text-gray-400 font-semibold">
                                    {{ $resena->calificacion }}/5
                                </span>
                            </div>
                        </div>
                        <p class="text-gray-300 leading-relaxed">
                            {{ $resena->comentario }} 
                        </p>
                    </div>
                @endforeach

                @if($resenas->isEmpty())
                    <div class="bg-gray-800 rounded-xl shadow-xl p-8 text-center">
                        <p class="text-gray-400 text-lg">No hay reseñas todavía</p>
                        <p class="text-gray-500 text-sm mt-2">¡Sé el primero en dejar una reseña!</p>
                    </div>
                @endif
            </section>
        @endif
    </main>

    <footer class="bg-gray-900 border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
                <div class="mt-4">
                    <a href="/terminos-y-condiciones" class="text-sm text-gray-400 hover:text-gray-300">Terminos y condiciones</a> | <a href="/politicas" class="text-sm text-gray-400 hover:text-gray-300">Politicas de privacidad</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>