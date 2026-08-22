<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Inicio de sesión - VGStorm</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-center { display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="text-white p-4 auth-center">
    <div class="max-w-xl w-full mx-auto bg-gray-900 p-6 sm:p-10 rounded-lg shadow-2xl border border-gray-700">
        <a href="{{ route('main') }}" class="flex items-center gap-2 text-gray-400 hover:text-white transition mb-6 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al inicio
        </a>
        <div class="text-center mb-8 sm:mb-10">
            <img src="{{ asset('logo.ico') }}" alt="VGStorm" class="h-14 w-14 mx-auto mb-2">
            <p class="text-lg mt-2 text-gray-300">Bienvenido a la mejor tienda gaming!</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5 sm:space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Correo</label>
                <input type="email" id="email" name="correo" value="{{ old('correo') }}" required
                    class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-500"
                    placeholder="ejemplo@vgstorm.com">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <input type="password" id="password" name="contrasena" required
                    class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-500"
                    placeholder="••••••••••">
            </div>

            @if ($errors->any())
                <div class="text-sm font-medium text-red-500">{{ $errors->first() }}</div>
            @endif

            @if (session('success'))
                <div class="text-green-400 text-sm font-medium">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-end">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-400 text-white font-bold py-3 px-4 rounded-md transition duration-300 uppercase tracking-wider text-sm">Iniciar sesión</button>
        </form>

        <div class="mt-6 sm:mt-8 text-center pt-6 border-t border-gray-800">
            <p class="text-gray-300">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium ml-1">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
