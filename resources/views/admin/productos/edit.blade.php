<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Editar Producto</title>
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
            
            <div class="flex flex-col items-center mb-8">
                <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                    ✏️ Editar Producto
                </h2>
            </div>

            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                <input type="hidden" name="tipo" value="{{ $producto->tipo }}">

                <div class="mb-4">
                    <label for="nombre" class="block text-gray-300 font-semibold mb-2">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="compania" class="block text-gray-300 font-semibold mb-2">Compañía *</label>
                    <input type="text" id="compania" name="compania" value="{{ old('compania', $producto->compania) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                @if ($producto->tipo == "Juego")
                    <div class="mb-4">
                        <label for="genero" class="block text-gray-300 font-semibold mb-2">Género *</label>
                        <input type="text" id="genero" name="genero" value="{{ old('genero', $producto->genero) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="fecha_lanzamiento" class="block text-gray-300 font-semibold mb-2">Fecha lanzamiento *</label>
                    <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" value="{{ old('fecha_lanzamiento', date('Y-m-d', strtotime($producto->fecha_lanzamiento))) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="precio" class="block text-gray-300 font-semibold mb-2">Precio *</label>
                    <input type="number" step="0.1" min="0" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-gray-300 font-semibold mb-2">Stock *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-300 font-semibold mb-2">Descripción *</label>
                    <textarea rows="4" id="descripcion" name="descripcion" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="imagen" class="block text-gray-300 font-semibold mb-2">Imagen (Opcional)</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <p class="text-xs text-gray-400 mt-2">Deja este campo vacío si no quieres cambiar la imagen actual.</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                        💾 Guardar Cambios
                    </button>
                    <a href="{{ route('admin.productos.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2026 VGStorm. Derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>