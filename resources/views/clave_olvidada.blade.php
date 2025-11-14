<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Recuperar contraseña</title>
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
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">Recupera tu clave</h1>
        </div>

        <form action="{{ url('/clave-olvidada') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="correo" class="block text-sm font-medium text-gray-300">correo</label>
                <input type="email" id="correo" name="correo" required class="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
            </div>
            <div>
                <label for="contrasena" class="block text-sm font-medium text-gray-300">contraseña nueva</label>
                <input type="password" id="contrasena" name="contrasena" required class="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
            </div>
            <div>
                <label for="contrasena" class="block text-sm font-medium text-gray-300">Confirmar contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required class="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
            </div>
            <button type="submit" class="w-full neon-blue text-black font-bold py-2 px-4 rounded-md transition duration-300">Guardar cambios</button>
        </form>
    </div>
</body>
</html>
