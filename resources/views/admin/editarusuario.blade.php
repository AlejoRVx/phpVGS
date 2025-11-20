<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Editar Usuario</title>
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
                    <a href="/admin/main" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="/admin/main" class="text-gray-300 hover:text-blue-400 transition duration-300">Inicio</a>
                    <a href="/admin/juegos" class="text-gray-300 hover:text-blue-400 transition duration-300">Juegos</a>
                    <a href="/admin/consolas" class="text-gray-300 hover:text-blue-400 transition duration-300">Consolas</a>
                    <a href="/admin/listausuarios" class="text-gray-300 hover:text-blue-400 transition duration-300">Usuarios</a>
                    <a href="/" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500 transition duration-300">Cerrar sesión ⍈</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-6">
                ✏️ Editar Usuario
            </h2>

            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('/admin/editarusuario') }}" method="POST">
                @csrf
                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">

                <div class="mb-4">
                    <label class="block text-gray-300 font-semibold mb-2">Correo Electrónico</label>
                    <input type="email" value="{{ $usuario->correo }}" class="w-full px-4 py-2 bg-gray-700 text-gray-400 rounded border border-gray-600 cursor-not-allowed" disabled>
                    <p class="text-sm text-gray-400 mt-1">El correo no se puede modificar</p>
                </div>

                <div class="mb-4">
                    <label for="nombre" class="block text-gray-300 font-semibold mb-2">Nombre Completo *</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    @error('nombre')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="direccion" class="block text-gray-300 font-semibold mb-2">Dirección *</label>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $usuario->direccion) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    @error('direccion')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="telefono" class="block text-gray-300 font-semibold mb-2">Teléfono *</label>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    @error('telefono')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="rol_id" class="block text-gray-300 font-semibold mb-2">Rol *</label>
                    <select id="rol_id" name="rol_id" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="1" {{ $usuario->rol_id == 1 ? 'selected' : '' }}>Usuario</option>
                        <option value="2" {{ $usuario->rol_id == 2 ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('rol_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                        💾 Guardar Cambios
                    </button>
                    <a href="/admin/listausuarios" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
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
</body>
</html>