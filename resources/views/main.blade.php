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

    <div class="flex items-center space-x-8">
        
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
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg shadow-blue-900/40 transition-all transform hover:scale-105 active:scale-95">
                            Iniciar Sesión
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

<section class="relative h-[500px] flex items-center justify-center overflow-hidden rounded-3xl mb-16 shadow-2xl border border-gray-700">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/gaming-background.jpg') }}" class="w-full h-full object-cover opacity-40" alt="Gaming Background">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
    </div>
    
    <div class="relative z-10 text-center px-6">
        <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-500 to-blue-600 mb-6 drop-shadow-sm">
            VGSTORM
        </h1>
        <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-2xl mx-auto font-light tracking-wide">
            Eleva tu juego con lo último en títulos digitales y consolas de alto rendimiento.
        </p>
    </div>
</section>

<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
    <a href="{{ route('productos.juegos') }}" class="group relative h-64 rounded-2xl overflow-hidden border border-gray-700 cursor-pointer">

        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent z-10 group-hover:from-blue-900/80 transition-all duration-300"></div>
        
        <img src="{{ asset('img/juegos-digitales.jpg') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Juegos">
        
        <div class="absolute bottom-6 left-6 z-20">
            <h3 class="text-2xl font-bold text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">Juegos Digitales</h3>
            <p class="text-sm text-gray-200 drop-shadow-md font-medium">Lanzamientos y preventas</p>
        </div>
    </a>

    <a href="{{ route('productos.consolas') }}" class="group relative h-64 rounded-2xl overflow-hidden border border-gray-700 cursor-pointer">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent z-10 group-hover:from-purple-900/80 transition-all duration-300"></div>
        
        <img src="{{ asset('img/consolas-hardware.jpg') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Consolas">
        
        <div class="absolute bottom-6 left-6 z-20">
            <h3 class="text-2xl font-bold text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">Consolas</h3>
            <p class="text-sm text-gray-200 drop-shadow-md font-medium">Poder de nueva generación</p>
        </div>
    </a>

    <a href="#novedades" class="group relative h-64 rounded-2xl overflow-hidden border border-gray-700 cursor-pointer hidden lg:block">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent z-10 group-hover:from-green-900/80 transition-all duration-300"></div>
        
        <img src="{{ asset('img/blog-gaming.jpg') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Noticias">
        
        <div class="absolute bottom-6 left-6 z-20">
            <h3 class="text-2xl font-bold text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">Blog Gaming</h3>
            <p class="text-sm text-gray-200 drop-shadow-md font-medium">Noticias del mundo geek</p>
        </div>
    </a>
</section>

<div id="novedades" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-2">
        <h2 class="text-3xl font-bold mb-8 flex items-center gap-3">
            <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
            Últimas Noticias
        </h2>
        
        <div class="space-y-8">
            <article class="flex flex-col md:flex-row gap-6 bg-gray-800/40 p-4 rounded-2xl border border-gray-700 hover:border-blue-500/50 transition-colors group">
                <div class="w-full md:w-48 h-48 overflow-hidden rounded-xl">
                    <img src="{{ asset('img/noticia-steam.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="Steam Hardware">
                </div>
                <div class="flex flex-col justify-center flex-1">
                    <span class="text-blue-400 text-xs font-bold uppercase tracking-widest mb-2">Hardware</span>
                    <h4 class="text-xl font-bold mb-2 text-white">Nueva generación de Steam Hardware para 2026</h4>
                    <p class="text-gray-400 text-sm mb-4">Mejoras masivas en latencia y ergonomía para el nuevo ecosistema de Valve.</p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-xs text-gray-500">11 Nov, 2025</span>
                        <a href="https://store.steampowered.com/sale/steammachine" target="_blank" class="text-sm text-blue-400 font-semibold hover:text-blue-300">Leer más →</a>
                    </div>
                </div>
            </article>

            <article class="flex flex-col md:flex-row gap-6 bg-gray-800/40 p-4 rounded-2xl border border-gray-700 hover:border-purple-500/50 transition-colors group">
                <div class="w-full md:w-48 h-48 overflow-hidden rounded-xl">
                    <img src="{{ asset('img/noticia-gta.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="GTA VI">
                </div>
                <div class="flex flex-col justify-center flex-1">
                    <span class="text-purple-400 text-xs font-bold uppercase tracking-widest mb-2">Lanzamientos</span>
                    <h4 class="text-xl font-bold mb-2 text-white">Rockstar confirma estado final de GTA VI</h4>
                    <p class="text-gray-400 text-sm mb-4">La calidad técnica en consolas de nueva generación es la prioridad absoluta.</p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-xs text-gray-500">07 Nov, 2025</span>
                        <a href="https://www.rockstargames.com/es/newswire/article/8978kok9385a82/grand-theft-auto-vi-watch-trailer-1-now" target="_blank" class="text-sm text-purple-400 font-semibold hover:text-purple-300">Leer más →</a>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <aside>
        <h2 class="text-3xl font-bold mb-8">Top Ventas</h2>
        <div class="bg-gray-800/30 backdrop-blur-md border border-gray-700 rounded-3xl p-6 sticky top-8">
            <ul class="space-y-6">
                @php
                    $tops = [
                        ['name' => 'Elden Ring', 'price' => '150.000'],
                        ['name' => 'Hollow Knight: Silksong', 'price' => '47.500'],
                        ['name' => 'Resident Evil 4 Remake', 'price' => '121.800'],
                        ['name' => 'God of War: Ragnarok', 'price' => '130.000'],
                        ['name' => 'PlayStation 5', 'price' => '3.000.000'],
                    ];
                @endphp

                @foreach($tops as $index => $item)
                <li class="flex items-center gap-4 group">
                    <span class="text-4xl font-black text-gray-700 group-hover:text-blue-500/50 transition-colors">0{{ $index + 1 }}</span>
                    <div class="flex-1">
                        <p class="font-bold text-gray-200 leading-tight">{{ $item['name'] }}</p>
                        <p class="text-blue-400 font-mono text-sm">${{ $item['price'] }}</p>
                    </div>
                    <a href="{{ route('productos.juegos') }}" class="p-2 bg-gray-700 rounded-lg hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('productos.juegos') }}" class="block text-center mt-8 py-3 bg-gradient-to-r from-purple-600/20 to-blue-600/20 border border-purple-500/50 text-purple-300 rounded-xl hover:from-purple-600 hover:to-blue-600 hover:text-white transition-all duration-300">
                Ver todo el catálogo
            </a>
        </div>
    </aside>
</div>

</main>

<footer class="bg-gray-900 border-t border-gray-700 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center">
            <p class="text-gray-400">&copy; 2025 VGStorm. Derechos reservados.</p>
            <div class="mt-4">
                <a href="{{ route('terminos') }}" class="text-sm text-gray-400 hover:text-gray-300">Terminos y condiciones</a> | 
                <a href="{{ route('politicas') }}" class="text-sm text-gray-400 hover:text-gray-300">Politicas de privacidad</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>