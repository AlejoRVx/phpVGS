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
        .header-listausuarios {
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
        <section class="text-center mb-8">
            <h2 class="text-5xl font-bold mb-8 header-listausuarios">🙋‍♂️ Lista de Usuarios</h2>
        </section>

        <section id="catalogo-juegos" class="py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @foreach ($usuarios as $usuario)
                    <div class="bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300 transform hover:scale-105">
                        <h3 class="text-xl font-bold mb-2 text-blue-400">{{ $usuario->correo }}</h3>
                        <h3 class="text-gray-300">{{ $usuario->nombre }}</h3>
                        <h3 class="text-gray-300">{{ $usuario->direccion }}</h3>
                        <h3 class="text-gray-300">{{ $usuario->telefono }}</h3>
                        <p class="text-gray-300 mb-1"><strong>Rol ID:</strong> {{ $usuario->rol_id }}</p>
                        <p class="text-gray-300"><strong>Registrado el:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                        
                        <div class="flex gap-2 mt-4">
                            <a href="{{ url('/admin/editarusuario/' . $usuario->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-blue-500 transition duration-300">
                                Editar Usuario
                            </a>
                            
                            <form action="{{ url('/admin/listausuarios') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-red-600 transition duration-500" onclick="return confirm('¿Estás seguro que deseas eliminar este usuario?');">
                                    Eliminar Usuario
                                </button>
                            </form>
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