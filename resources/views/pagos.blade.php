<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Pagos - VGStorm</title>
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
        @media print {
            .no-print {
                display: none;
            }
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

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="text-center mb-12">
            <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">Finalizar Compra</h2>
        </section>

        <div class="bg-gray-900 rounded p-6 mb-6">
            <h3 class="text-2xl font-bold mb-4">Resumen del Pedido</h3>
            
            @foreach($pedidos as $item)
                <div class="flex justify-between items-center border-b border-gray-700 py-3">
                    <div class="flex items-center">
                        <img src="{{ asset('img/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-16 h-16 rounded mr-4">
                        <div>
                            <p class="font-bold">{{ $item['nombre'] }}</p>
                            <p class="text-gray-400 text-sm">Cantidad: {{ $item['cantidad'] }}</p>
                        </div>
                    </div>
                    <p class="font-bold">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</p>
                </div>
            @endforeach
            
            <div class="mt-6 pt-4 border-t border-gray-700">
                <div class="flex justify-between text-xl font-bold">
                    <span>Total a Pagar:</span>
                    <span class="text-green-400">${{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 rounded p-6">
            <h3 class="text-2xl font-bold mb-4">Método de Pago</h3>
            
            <form action="{{ route('pagar') }}" method="POST">
                @csrf
                    
                <div class="mb-6">
                    <label class="block text-gray-300 mb-2">Selecciona tu método de pago:</label>
                    <select name="metodo" class="w-full bg-gray-800 text-white rounded px-4 py-3 border border-gray-700">
                        <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                        <option value="Tarjeta de débito">Tarjeta de débito</option>
                        <option value="PayPal">PayPal</option>
                        <option value="PSE">PSE</option>
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <div class="mb-6">
                        <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-blue-400 hover:text-blue-300 hover:bg-gray-700 rounded-lg border-2 border-blue-400 transition duration-300 shadow-lg hover:shadow-blue-400/30">
                            <span class="mr-2 text-xl">←</span> 
                            <span class="font-semibold">Volver atrás</span>
                        </a>
                    </div>
                        
                    <button type="submit" class="px-8 py-4 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50" onclick="alert('Pago realizado exitosamente, disfruta tu compra');">
                        💳 Realizar pago
                    </button>
                </div>
            </form>
        </div>
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