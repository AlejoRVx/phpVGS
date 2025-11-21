<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Mi Carrito - VGStorm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        .quantity-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: all 0.3s;
        }
        .quantity-btn:hover {
            transform: scale(1.1);
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
            <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">🛒 Mi Carrito</h2>
        </section>

        @if(empty($pedidos))
            <div class="bg-gray-900 rounded p-8 text-center">
                <p class="text-xl mb-4">Tu carrito está vacío</p>
                <a href="/juegos" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">Ir a comprar 🛒</a>
            </div>
        @else
            @foreach($pedidos as $id => $item)
                <div class="bg-gray-900 rounded p-4 mb-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <img src="{{ asset('img/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-20 h-20 rounded mr-4">
                        <div>
                            <h3 class="font-bold">{{ $item['nombre'] }}</h3>
                            <p class="text-gray-400">${{ number_format($item['precio'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center bg-gray-800 rounded">
                            <form action="{{ route('pedidos.actualizar', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="cantidad" value="{{ max(1, $item['cantidad'] - 1) }}">
                                <button type="submit" class="quantity-btn bg-gray-700 hover:bg-gray-600 text-white rounded-l">−</button>
                            </form>
                            
                            <span class="w-12 text-center font-bold">{{ $item['cantidad'] }}</span>
                            
                            <form action="{{ route('pedidos.actualizar', $id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="cantidad" value="{{ $item['cantidad'] + 1 }}">
                                <button type="submit" class="quantity-btn bg-gray-700 hover:bg-gray-600 text-white rounded-r">+</button>
                            </form>
                        </div>

                        <p class="font-bold w-32 text-right">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</p>

                        <form action="{{ route('pedidos.eliminar', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-500 hover:bg-red-600">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="bg-gray-900 rounded p-6 mt-6 flex justify-between items-center">
                <form action="{{ route('pedidos.vaciar') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de vaciar todo el carrito?');" class="bg-gray-500 hover:bg-red-700 text-white px-6 py-3 rounded transition duration-500">Vaciar carrito 🛒</button>
                </form>

                <div class="text-right">
                    <p class="text-2xl font-bold">Total: ${{ number_format($total, 0, ',', '.') }}</p>
                    <a href="{{ route('pagos.index') }}" class="mt-4 inline-block px-8 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-500 hover:bg-green-600">Pagar</a>
                </div>
            </div>
        @endif
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