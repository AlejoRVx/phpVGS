<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>@yield('title', 'VGStorm')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }
        .glass-nav {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="text-white font-sans">

<div id="toast-container" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-[60] space-y-3"></div>

<header class="glass-nav sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-8">

            <div class="flex items-center flex-shrink-0">
                <img src="{{ asset('logo.ico') }}" class="h-9 w-9 mr-2 drop-shadow-[0_0_8px_rgba(59,130,246,0.5)]">
                <a href="{{ route('main') }}"
                   class="text-2xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 hover:from-blue-300 hover:to-purple-400 transition-all">
                    VGSTORM
                </a>
            </div>

            <div class="flex-grow"></div>
            
                @yield('search-bar')

                @if(View::hasSection('search-bar'))
                <div class="hidden md:flex flex-1 max-w-md relative group min-w-[570px]">
                    <form action="{{ request()->is('*consolas*') ? route('productos.buscarconsolas') : route('productos.buscarjuegos') }}" 
                        method="GET" 
                        class="w-full relative">
                        
                        <input type="search" 
                            name="q" 
                            id="search-input"
                            autocomplete="off"
                            placeholder="Buscar {{ request()->is('*consolas*') ? 'consolas' : 'juegos' }} por nombre o marca..." 
                            class="w-full bg-gray-800/50 border border-gray-700 text-sm text-white rounded-full py-2.5 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-500">
                    </form>

                    <div id="search-results-container" 
                        class="absolute top-full left-0 w-full mt-2 z-[100] bg-gray-900 border border-purple-500/50 shadow-[0_0_20px_rgba(168,85,247,0.3)] rounded-xl overflow-hidden hidden">
                    </div>

                    <div class="absolute left-3 top-2.5 text-gray-500 group-focus-within:text-purple-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                @endif

                <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium border-r border-gray-700 pr-8">
                    <a href="{{ route('main') }}" class="text-gray-300 hover:text-white transition-colors {{ request()->routeIs('main') ? 'text-blue-400 font-bold' : '' }}">Inicio</a>
                    <a href="{{ route('productos.juegos') }}" class="text-gray-300 hover:text-white transition-colors {{ request()->routeIs('productos.juegos') ? 'text-blue-400 font-bold' : '' }}">Juegos</a>
                    <a href="{{ route('productos.consolas') }}" class="text-gray-300 hover:text-white transition-colors {{ request()->routeIs('productos.consolas') ? 'text-blue-400 font-bold' : '' }}">Consolas</a>
                </nav>

                <div class="flex items-center space-x-5">
                    @auth
                        <a href="{{ route('pedidos.index') }}" class="relative p-2 text-gray-300 hover:text-blue-400 transition-colors group">
                            <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </a>

                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-sm font-bold text-gray-200 hover:text-blue-400 transition-colors focus:outline-none py-2">
                                <span>{{ explode(' ', Auth::user()->nombre)[0] }}</span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div class="absolute right-0 w-48 mt-0 origin-top-right bg-gray-900 border border-gray-700 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-800">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Cuenta</p>
                                </div>
                                <a href="{{ route('perfil') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition">Mi Perfil</a>
                                <a href="{{ route('historial') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition">Mis Pedidos</a>
                                <div class="border-t border-gray-800"></div>
                                <form action="{{ route('logout') }}" method="GET">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg transition-all transform hover:scale-105 active:scale-95">
                            Iniciar Sesión
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @yield('content')
</main>

<footer class="bg-gray-900 border-t border-gray-700 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center">
            <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
            <div class="mt-4">
                <a href="{{route('terminos')}}" class="text-sm text-gray-400 hover:text-gray-300">Terminos y condiciones</a> | 
                <a href="{{route('politicas')}}" class="text-sm text-gray-400 hover:text-gray-300">Politicas de privacidad</a>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')

</body>
</html>