<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="@yield('title', 'VGStorm Admin')">
    <meta property="og:description" content="VGStorm - Panel de administración.">
    <meta property="og:image" content="https://res.cloudinary.com/dsidu0tej/image/upload/v1781156632/VGStorm_cjxm5w.png">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>@yield('title', 'VGStorm Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-white font-sans">

<div id="toast-container" class="fixed top-5 left-1/2 -translate-x-1/2 z-[60] space-y-3 pointer-events-none"></div>

<header class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <img src="{{ asset('logo.ico') }}" alt="VGStorm" class="h-8 w-8 mr-2">
                <a href="{{ route('admin.main') }}" class="text-xl sm:text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</a>
            </div>

            {{-- Nav desktop --}}
            <nav class="hidden md:flex items-center space-x-8 text-sm">
                <a href="{{ route('admin.main') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Inicio</a>
                <a href="{{ route('admin.productos.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Productos</a>
                <a href="{{ route('admin.noticias.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Noticias</a>
                <a href="{{ route('admin.usuarios.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Usuarios</a>
                <a href="{{ route('logout') }}" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');" class="text-gray-300 hover:text-red-500 transition-colors">Cerrar sesión</a>
            </nav>

            {{-- Botón menú móvil --}}
            <button id="admin-mobile-btn" class="md:hidden p-2 text-gray-300 hover:text-white focus:outline-none" aria-label="Menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="admin-menu-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path id="admin-menu-close" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" class="hidden"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div id="admin-mobile-menu" class="md:hidden hidden border-t border-gray-700/50">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('admin.main') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition">Inicio</a>
            <a href="{{ route('admin.productos.index') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition">Productos</a>
            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition">Noticias</a>
            <a href="{{ route('admin.usuarios.index') }}" class="block px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition">Usuarios</a>
            <a href="{{ route('logout') }}" class="block px-4 py-2.5 text-red-400 hover:bg-red-500/10 rounded-lg transition">Cerrar sesión</a>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-12">
    @yield('content')
</main>

<footer class="bg-gray-900 border-t border-gray-700 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center">
            <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
        </div>
    </div>
</footer>

<script>
document.getElementById('admin-mobile-btn')?.addEventListener('click', function() {
    const menu = document.getElementById('admin-mobile-menu');
    const iconOpen = document.getElementById('admin-menu-open');
    const iconClose = document.getElementById('admin-menu-close');
    menu.classList.toggle('hidden');
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
});
</script>

@stack('scripts')
</body>
</html>
