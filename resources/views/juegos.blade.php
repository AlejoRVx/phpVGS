<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Juegos</title>
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
        .header-juegos {
            background-image: linear-gradient(to right, #60a5fa, #9333ea); 
            color: transparent; 
            -webkit-background-clip: text; 
            background-clip: text;
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
                    <a href="/carrito" class="text-gray-300 hover:text-blue-400 transition duration-300"> 🛒 </a>
                    <a href="/" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500 transition duration-300">Cerrar sesión ⍈</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="text-center mb-8">
            <h2 class="text-5xl font-bold mb-8 header-juegos">Nuestros juegos</h2>
        </section>

        <section id="barra-busqueda" class="mb-12">
            <form action="#" method="GET" class="max-w-3xl mx-auto flex">
                <input type="search" name="q" placeholder="Buscar por nombre, género o compañía..." class="w-full px-4 text-white bg-gray-900 rounded-l-lg border-2 border-r-0 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:shadow-lg focus:shadow-blue-400/30 placeholder-gray-400 transition duration-300">
                <button type="submit" class="px-5 bg-purple-800 text-white font-semibold rounded-r-lg hover:bg-purple-600 transition duration-300 flex items-center shadow-md shadow-purple-600/20">
                    🔎 Buscar
                </button>
            </form>
        </section>
        
        <hr class="border-t-2 border-gray-700 mt-12 mb-8">

        <section id="catalogo-juegos" class="py-6">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8 text-center">
                🕹️ Catálogo de Juegos Digitales Destacados
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden transition duration-200 transform hover:scale-[1.02] hover:shadow-blue-500/50">
                    <img class="w-full h-48 object-cover object-center" src="{{ asset('img/imagen4.jpg') }}" alt="Hollow Knight">
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-blue-400 mb-2">Hollow Knight</h3>
                        
                        <p class="text-sm text-gray-400 mb-3">
                            <span class="font-semibold">Género:</span> Metroidvania | Acción | 2D
                            <span class="font-semibold">Compañía:</span> Team Cherry.
                        </p>

                        <div class="flex items-center mb-4">
                            <span class="text-yellow-400 text-lg mr-2">
                                ⭐⭐⭐⭐✨
                            </span>
                            <span class="text-sm text-gray-500">(30.1k reviews)</span>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <span class="text-2xl font-bold text-purple-400">37.500$</span>
                            
                            <button class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">
                                Añadir 🛒
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden transition duration-200 transform hover:scale-[1.02] hover:shadow-blue-500/50">
                    <img class="w-full h-48 object-cover object-center" src="{{ asset('img/imagen5.jpg') }}" alt="Resident Evil 4 Remake">
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-blue-400 mb-2">Resident Evil 4 Remake</h3>
                        
                        <p class="text-sm text-gray-400 mb-3">
                            <span class="font-semibold">Género:</span> Terror | Accion | single player 
                            <span class="font-semibold">Compañía:</span> CAPCOM Co., Ltd.
                        </p>

                        <div class="flex items-center mb-4">
                            <span class="text-yellow-400 text-lg mr-2">
                                ⭐⭐⭐⭐⭐
                            </span>
                            <span class="text-sm text-gray-500">(50.5k reviews)</span>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <span class="text-2xl font-bold text-purple-400">121.800$</span>
                            
                            <button class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">
                                Añadir 🛒
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden transition duration-200 transform hover:scale-[1.02] hover:shadow-blue-500/50">
                    <img class="w-full h-48 object-cover object-center" src="{{ asset('img/imagen6.jpg') }}" alt="God of War Ragnarök">
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-blue-400 mb-2">God of War Ragnarök</h3>
                        
                        <p class="text-sm text-gray-400 mb-3">
                            <span class="font-semibold">Género:</span> Accion | Aventura | Rol
                            <span class="font-semibold">Compañía:</span> SIE Santa Monica Studio, Jetpack Interactive.
                        </p>

                        <div class="flex items-center mb-4">
                            <span class="text-yellow-400 text-lg mr-2">
                                ⭐⭐⭐⭐✨
                            </span>
                            <span class="text-sm text-gray-500">(60.2k reviews)</span>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <span class="text-2xl font-bold text-purple-400">219.000$</span>
                            
                            <button class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">
                                Añadir 🛒
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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