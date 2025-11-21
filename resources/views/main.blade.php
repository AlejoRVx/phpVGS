<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Inicio</title>
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
        <section class="text-center mb-12">
            <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">Bienvenido a VGStorm</h2>
        </section>
        <section id="seccion-noticias" class="mt-8 p-6 bg-gray-800 rounded-lg shadow-xl">
            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 border-b-2 border-blue-400 pb-2 mb-6">
            🎮 Noticias Recientes de Juegos y Consolas
            </h2>
            <div class="space-y-6">
                
                <div class="p-4 bg-gray-700/50 rounded-lg transition duration-300 hover:ring-2 hover:ring-blue-400">
                    <div class="flex items-start space-x-4 group">
                        <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32">
                            <img src="{{ asset('img/imagen1.jpg') }}" alt="Imagen Steam Hardware" class="w-full h-full object-cover rounded-md aspect-square">
                        </div>
                        <div class="flex-grow">
                            <strong class="font-semibold text-lg text-gray-100 group-hover:text-blue-400 transition duration-300">
                                Anuncian la nueva generación de hardware Steam para 2026
                            </strong>
                            <p class="text-gray-300 mt-1 text-sm">
                                Se revelan Steam Machine, Steam Frame y el nuevo Steam Controller con grandes mejoras de rendimiento.
                            </p>
                            <span class="block text-xs text-gray-400 mt-2">(Nov 11, 2025)</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-700/50 rounded-lg transition duration-300 hover:ring-2 hover:ring-blue-400">
                    <div class="flex items-start space-x-4 group">
                        <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32">
                            <img src="{{ asset('img/imagen2.jpg') }}" alt="Imagen GTA VI" class="w-full h-full object-cover rounded-md aspect-square">
                        </div>
                        <div class="flex-grow">
                            <strong class="font-semibold text-lg text-gray-100 group-hover:text-blue-400 transition duration-300">
                                Rockstar confirma otro retraso para GTA VI
                            </strong>
                            <p class="text-gray-300 mt-1 text-sm">
                                La fecha de lanzamiento se aplaza hasta noviembre de 2026, citando la necesidad de "pulir la experiencia global".
                            </p>
                            <span class="block text-xs text-gray-400 mt-2">(Nov 7, 2025)</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 bg-gray-700/50 rounded-lg transition duration-300 hover:ring-2 hover:ring-blue-400">
                    <div class="flex items-start space-x-4 group">
                        <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32">
                            <img src="{{ asset('img/imagen3.jpg') }}" alt="Imagen PS Portal" class="w-full h-full object-cover rounded-md aspect-square">
                        </div>
                        <div class="flex-grow">
                            <strong class="font-semibold text-lg text-gray-100 group-hover:text-blue-400 transition duration-300">
                                La PS5 portátil (PlayStation Portal) se transforma
                            </strong>
                            <p class="text-gray-300 mt-1 text-sm">
                                Sony añade funciones clave para competir con Xbox Game Pass, incluyendo juego nativo en la nube.
                            </p>
                            <span class="block text-xs text-gray-400 mt-2">(Nov 7, 2025)</span>
                        </div>
                    </div>
                </div>
            </div>
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
