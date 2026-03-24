<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Agregar producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
                    <a href="{{ route('admin.main') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('admin.main') }}" class="text-gray-300 hover:text-blue-400">Inicio</a>
                    <a href="{{ route('admin.productos.index') }}" class="text-gray-300 hover:text-blue-400">Productos</a>
                    <a href="{{ route('admin.usuarios.index') }}" class="text-gray-300 hover:text-blue-400">Usuarios</a>
                    <a href="{{ route('logout') }}" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500">Cerrar sesión ⍈</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8">
            <div class="flex flex-col items-center mb-8"> <div class="bg-gray-900 p-1 rounded-full flex items-center border border-gray-700 relative w-64 mb-6"> <div id="switch-bg" class="absolute h-9 w-32 bg-blue-600 rounded-full transition-all duration-300 ease-in-out"></div>
                <button type="button" onclick="toggleTipo('Juego')" id="btn-juego" 
                        class="relative z-10 w-32 py-2 text-sm font-bold transition-colors duration-300 text-white">
                    🎮 Juego
                </button>
                
                <button type="button" onclick="toggleTipo('Consola')" id="btn-consola" 
                        class="relative z-10 w-32 py-2 text-sm font-bold transition-colors duration-300 text-gray-400">
                    🕹️ Consola
                </button>
            </div>

            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                ➕ Agregar producto
            </h2>
        </div>

            <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tipo" id="tipo_input" value="Juego">

                <div class="mb-4">
                    <label for="nombre" class="block text-gray-300 font-semibold mb-2">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="compania" class="block text-gray-300 font-semibold mb-2">Compañía *</label>
                    <input type="text" id="compania" name="compania" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div id="campo-genero" class="mb-4 transition-all duration-300">
                    <label for="genero" class="block text-gray-300 font-semibold mb-2">Género *</label>
                    <input type="text" id="genero" name="genero" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="mb-4">
                    <label for="fecha_lanzamiento" class="block text-gray-300 font-semibold mb-2">Fecha de Lanzamiento *</label>
                    <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="precio" class="block text-gray-300 font-semibold mb-2">Precio *</label>
                    <input type="number" step="0.1" id="precio" name="precio" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-gray-300 font-semibold mb-2">Stock *</label>
                    <input type="number" id="stock" name="stock" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-300 font-semibold mb-2">Descripción *</label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="imagen" class="block text-gray-300 font-semibold mb-2">Imagen *</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                        💾 Guardar Producto
                    </button>
                    <a href="{{ route('admin.productos.index')}}" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleTipo(tipo) {
            const btnJuego = document.getElementById('btn-juego');
            const btnConsola = document.getElementById('btn-consola');
            const switchBg = document.getElementById('switch-bg');
            const campoGenero = document.getElementById('campo-genero');
            const inputTipo = document.getElementById('tipo_input');
            const inputGenero = document.getElementById('genero');

            if (tipo === 'Juego') {
                switchBg.style.transform = 'translateX(0px)';
                switchBg.classList.replace('bg-purple-600', 'bg-blue-600');
                btnJuego.classList.replace('text-gray-400', 'text-white');
                btnConsola.classList.replace('text-white', 'text-gray-400');
                
                campoGenero.style.display = 'block';
                inputTipo.value = 'Juego';
                inputGenero.required = true;
            } else {
                switchBg.style.transform = 'translateX(124px)';
                switchBg.classList.replace('bg-blue-600', 'bg-purple-600');
                btnConsola.classList.replace('text-gray-400', 'text-white');
                btnJuego.classList.replace('text-white', 'text-gray-400');
                
                campoGenero.style.display = 'none';
                inputTipo.value = 'Consola';
                inputGenero.required = false;
                inputGenero.value = '';
            }
        }

        window.onload = () => toggleTipo('Juego');
    </script>
</body>
</html>