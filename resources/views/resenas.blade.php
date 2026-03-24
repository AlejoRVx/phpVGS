@php
    $iconEstrella = "m8.243 7.34 -6.38 0.925 -0.113 0.023a1 1 0 0 0 -0.44 1.684l4.622 4.499 -1.09 6.355 -0.013 0.11a1 1 0 0 0 1.464 0.944l5.706 -3 5.693 3 0.1 0.046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355 4.624 -4.5 0.078 -0.085a1 1 0 0 0 -0.633 -1.62l-6.38 -0.926 -2.852 -5.78a1 1 0 0 0 -1.794 0L8.243 7.34z";
    $iconMedia = "M12 1a0.993 0.993 0 0 1 0.823 0.443l0.067 0.116 2.852 5.781 6.38 0.925c0.741 0.108 1.08 0.94 0.703 1.526l-0.07 0.095 -0.078 0.086 -4.624 4.499 1.09 6.355a1.001 1.001 0 0 1 -1.249 1.135l-0.101 -0.035 -0.101 -0.046 -5.693 -3 -5.706 3c-0.105 0.055 -0.212 0.09 -0.32 0.106l-0.106 0.01a1.003 1.003 0 0 1 -1.038 -1.06l0.013 -0.11 1.09 -6.355 -4.623 -4.5a1.001 1.001 0 0 1 0.328 -1.647l0.113 -0.036 0.114 -0.023 6.379 -0.925 2.853 -5.78A0.968 0.968 0 0 1 12 1zm0 3.274V16.75a1 1 0 0 1 0.239 0.029l0.115 0.036 0.112 0.05 4.363 2.299 -0.836 -4.873a1 1 0 0 1 0.136 -0.696l0.07 -0.099 0.082 -0.09 3.546 -3.453 -4.891 -0.708a1 1 0 0 1 -0.62 -0.344l-0.073 -0.097 -0.06 -0.106L12 4.274z";
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>{{ $producto->nombre }} - Reseñas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-nav {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
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
        .star-rating {
            display: inline-flex;
            gap: 0.25rem;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            font-size: 2rem;
            color: #4b5563;
            transition: color 0.2s;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #fbbf24;
        }
    </style>
</head>
<body class="text-white">
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

    <div id="toast-container" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 space-y-3">
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('productos.'.strtolower($producto->tipo).'s') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-blue-400 hover:text-blue-300 hover:bg-gray-700 rounded-lg border-2 border-blue-400 transition duration-300 shadow-lg hover:shadow-blue-400/30">
                <span class="mr-2 text-xl">←</span> 
                <span class="font-semibold">Volver atrás</span>
            </a>
        </div>

        <section class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="rounded-lg shadow-xl max-h-96 w-full object-cover">
                </div>

                <div class="flex flex-col justify-center">
                    <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-4">
                        {{ $producto->nombre }}
                    </h1>

                    
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <span class="text-yellow-400 text-2xl mr-3 flex items-center gap-0.5">
                                @php $calificacion = $promedioCalificacion; @endphp
                                
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($calificacion))
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="{{ $iconEstrella }}"></path>
                                        </svg>
                                    @elseif ($calificacion - floor($calificacion) >= 0.3 && $i == ceil($calificacion))
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                            <path d="{{ $iconMedia }}"></path>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-600 opacity-40">
                                            <path d="{{ $iconEstrella }}"></path>
                                        </svg>
                                    @endif
                                @endfor

                            </span>
                            <span class="text-xl text-gray-300">{{ number_format($calificacion, 1) }}/5</span>

                            <span class="text-sm text-gray-500 ml-2">{{ $cantidadResenas }} {{ $cantidadResenas == 1 ? 'reseña' : 'reseñas' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        @if ($producto->tipo == "Juego")
                            <p class="text-gray-300">
                                <span class="font-semibold text-blue-400">Género:</span> {{ $producto->genero }}
                            </p>
                        @endif
                        <p class="text-gray-300">
                            <span class="font-semibold text-blue-400">Compañía:</span> {{ $producto->compania }}
                        </p>
                        <p class="text-gray-300">
                            <span class="font-semibold text-blue-400">Lanzamiento:</span> {{ $producto->fecha_lanzamiento->format('d/m/Y') }}
                        </p>
                    </div>

                    <p class="text-gray-400 mb-6 leading-relaxed">
                        {{ $producto->descripcion }}
                    </p>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                        <span class="text-4xl font-bold text-purple-400">
                            ${{ number_format($producto->precio, 2) }}
                        </span>
                        <form class="add-to-cart-form" data-product-id="{{ $producto->id }}" method="POST">
                             @csrf
                            <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50 text-lg">
                                Añadir 🛒
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <hr class="border-t-2 border-gray-700 mb-12">

        <section class="mb-12">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
                💬 Reseñas de Usuarios
            </h2>

            <div class="bg-gray-800 rounded-xl shadow-2xl p-8 mb-8">
                <h3 class="text-2xl font-semibold text-blue-400 mb-6">Deja tu reseña</h3>
                
                <form action="{{ route('productos.resenas.agregar' , $producto->id ) }}" method="POST">
                     @csrf
                    
                    <div class="mb-6">
                        <label for="calificacion" class="block text-gray-300 font-semibold mb-3">Calificación:</label>
                        <select name="calificacion" id="calificacion" required
                            class="px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:shadow-lg focus:shadow-blue-400/30 transition duration-300">
                            <option value="">Selecciona una calificación</option>
                            <option value="5">⭐⭐⭐⭐⭐ - Excelente (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ - Muy bueno (4/5)</option>
                            <option value="3">⭐⭐⭐ - Bueno (3/5)</option>
                            <option value="2">⭐⭐ - Regular (2/5)</option>
                            <option value="1">⭐ - Malo (1/5)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="comentario" class="block text-gray-300 font-semibold mb-2">Comentario:</label>
                        <textarea name="comentario" id="comentario" rows="5" required
                                class="w-full px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:shadow-lg focus:shadow-blue-400/30 transition duration-300 resize-none"
                                placeholder="Cuéntanos qué te pareció este producto..."></textarea>
                    </div>

                    <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500">
                        Publicar Reseña 📝
                    </button>
                </form>
            </div>

            @foreach ($resenas as $resena)
                <div class="bg-gray-800 rounded-xl shadow-xl p-6 border-l-4 border-blue-400 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm text-gray-400">
                                Por <span class="font-semibold text-blue-400"> {{ explode(' ', $resena->usuario->nombre)[0] }} </span>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $resena->fecha->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $resena->calificacion)
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-400">
                                            <path d="{{ $iconEstrella }}"></path>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-600 opacity-30">
                                            <path d="{{ $iconEstrella }}"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-400 font-semibold ml-1">
                                {{ $resena->calificacion }}/5
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-300 leading-relaxed">
                        {{ $resena->comentario }} 
                    </p>
                </div>
            @endforeach

            @if($resenas->isEmpty())
                <div class="bg-gray-800 rounded-xl shadow-xl p-8 text-center">
                    <p class="text-gray-400 text-lg">No hay reseñas todavía</p>
                    <p class="text-gray-500 text-sm mt-2">¡Sé el primero en dejar una reseña!</p>
                </div>
            @endif
        </section>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('success') }}", "success");
        });
    </script>
    @endif

    <script>
        function showToast(message, type = 'success') {
        const container = $('#toast-container');
        
        let bgColor = '';
        let icon = '';

        if (type === 'success') {
            bgColor = 'bg-purple-600';
            icon = '✅';
        } else if (type === 'error') {
            bgColor = 'bg-red-600';
            icon = '❌';
        }

        const toastHtml = `
            <div class="toast ${bgColor} text-white p-4 rounded-lg shadow-2xl transition duration-500 transform -translate-y-full opacity-0 max-w-sm" style="min-width: 300px;">
                <p class="font-semibold">${icon} ${message}</p>
            </div>
        `;

        const newToast = $(toastHtml).appendTo(container);
        
        setTimeout(() => {
            newToast.removeClass('-translate-y-full opacity-0').addClass('translate-y-0 opacity-100');
        }, 10);

        setTimeout(() => {
            newToast.removeClass('translate-y-0 opacity-100').addClass('-translate-y-full opacity-0');
            
            newToast.on('transitionend', function() {
                newToast.remove();
            });
        }, 2600);
    }

        $(document).ready(function() {

            $(document).on('submit', '.add-to-cart-form', function(e) {
                e.preventDefault();
                var form = $(this);
                var productId = form.data('product-id');
                var url = '{{ route('pedidos.agregar', ['id' => '__id__']) }}'.replace('__id__', productId);
                var token = form.find('input[name="_token"]').val(); 
                var button = form.find('button[type="submit"]');

                button.prop('disabled', true).text('...');
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { _token: token },
                    success: function(response) {
                        showToast(response.message, 'success'); 
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            showToast('Guardando producto... Redirigiendo al login', 'error');
                            saveAndLogin(productId);
                        } else {
                            showToast('Hubo un problema. Inténtalo de nuevo.', 'error');
                        }
                    },
                    complete: function() {
                        button.prop('disabled', false).html('Añadir 🛒');
                    }
                });
            });

            @if(session('auto_add_cart'))
                const pendingId = "{{ session('auto_add_cart') }}";
                const pendingForm = $(`.add-to-cart-form[data-product-id="${pendingId}"]`);
                    
                if(pendingForm.length > 0) {
                    pendingForm.submit();
                }
            @endif
        });
    </script>
</body>
</html>