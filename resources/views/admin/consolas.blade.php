<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Consolas</title>
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
    </style>
</head>
<body class="text-white">
    <header class="bg-gray-900 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-8 w-8 mr-2">
                    <a href="/admin/main" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="/admin/main" class="text-gray-300 hover:text-blue-400 transition duration-300">Inicio</a>
                    <a href="/admin/juegos" class="text-gray-300 hover:text-blue-400 transition duration-300">Juegos</a>
                    <a href="/admin/consolas" class="text-gray-300 hover:text-blue-400 transition duration-300">Consolas</a>
                    <a href="/admin/listausuarios" class="text-gray-300 hover:text-blue-400 transition duration-300">Usuarios</a>
                    <a href="/admin/auditorias" class="text-gray-300 hover:text-blue-400 transition duration-300">Auditorias</a>
                    <a href="/" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500 transition duration-300">Cerrar sesión ⍈</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="text-center mb-12">
            <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">Nuestras consolas</h2>
        </section>

        <section id="barra-busqueda" class="mb-12">
            <form action="#" method="GET" class="max-w-3xl mx-auto flex">
                <input type="search" name="q" placeholder="Buscar por nombre, compañía..." class="w-full px-4 text-white bg-gray-900 rounded-l-lg border-2 border-r-0 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:shadow-lg focus:shadow-blue-400/30 placeholder-gray-400 transition duration-300">
                <button type="submit" class="px-5 bg-purple-800 text-white font-semibold rounded-r-lg hover:bg-purple-600 transition duration-300 flex items-center shadow-md shadow-purple-600/20">
                    🔎 Buscar
                </button>
            </form>
        </section>

        <hr class="border-t-2 border-gray-700 mt-12 mb-8">

        <section id="catalogo-juegos" class="py-6">
            <div class="relative mb-8 flex justify-center items-center">
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                    🕹️ Catálogo de Consolas Destacadas
                </h2>
                <a href="{{ url('/admin/agregarproducto/Consola') }}" class="absolute right-0 px-5 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500">
                    Agregar
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($productos as $producto)
                    <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden transition duration-200 transform hover:scale-[1.02] hover:shadow-blue-500/50 flex flex-col">
                        <img class="w-full h-48 object-cover object-center" src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                            
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-blue-400 mb-2">{{ $producto->nombre }}</h3>
                                
                            <p class="text-sm text-gray-400 mb-3">
                                <span class="font-semibold">Compañía:</span> {{ $producto->compania }}<br>
                                <span class="font-semibold">Lanzamiento:</span> {{ $producto->fecha_lanzamiento->format('d/m/Y') }}
                            </p>

                            <p class="text-sm text-gray-400 mb-4">{{ $producto->descripcion }}</p>

                            <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-700">
                                <span class="text-2xl font-bold text-purple-400">${{ number_format($producto->precio) }}</span>
                                
                                <div class="flex justify-end gap-3">
                                    <a href="{{ url('/admin/editarproducto/Consola/' . $producto->id)}}" class="px-5 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-500 hover:bg-blue-500">
                                        Editar
                                    </a>
                                    <form action="{{ url('/admin/consolas') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-500 hover:bg-red-600" onclick="return confirm('¿Estás seguro que deseas eliminar este juego?');">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>