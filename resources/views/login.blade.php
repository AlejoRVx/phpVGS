<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Inicio de sesión</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="text-white">
    <div class="max-w-md mx-auto bg-gray-900 p-8 rounded-lg shadow-2xl border border-gray-700">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</h1>
            <p class="text-lg mt-2 text-gray-300">Bienvenid@ a la mejor tienda gaming!</p>
        </div>
        <form action="{{ url('/') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Correo</label>
                <input type="email" id="email" name="correo" value="{{ old('correo') }}" required class="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <input type="password" id="password" name="contrasena" required class="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
            </div>
            @if ($errors->any())
                <div class="block text-sm font-medium text-red-500" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">Recuerdame</label>
                </div>
                <a href="/clave-olvidada" class="text-sm text-blue-400 hover:text-blue-300">Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" class="w-full neon-blue text-black font-bold py-2 px-4 rounded-md transition duration-300">Iniciar sesión</button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-300">No tienes cuenta? <a href="{{ url('/register') }}" class="text-blue-400 hover:text-blue-300 font-medium">Registrate aquí</a></p>
        </div>
    </div>
</body>
</html>
