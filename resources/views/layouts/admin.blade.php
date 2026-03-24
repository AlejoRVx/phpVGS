<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title> @yield('title', 'VGStorm') </title>
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
    <header class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-8 w-8 mr-2">
                    <a href="{{ route('admin.main') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('admin.main') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Inicio</a>
                    <a href="{{ route('admin.productos.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Productos</a>
                    <a href="{{ route('admin.usuarios.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Usuarios</a>
                    <a href="{{ route('logout') }}" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500 transition-colors">
                        Cerrar sesión ⍈
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div id="toast-container" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 space-y-3">
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @yield('content')

    </main>

    <footer class="bg-gray-900 border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @stack('scripts')
    
</body>
</html>
