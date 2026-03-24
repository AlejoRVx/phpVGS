<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Recuperar contraseña - VGStorm</title>
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
        .input-error { border-color: #ef4444 !important; }
        .input-success { border-color: #22c55e !important; }
    </style>
</head>
<body class="text-white p-4">

    <div class="max-w-xl w-full mx-auto bg-gray-900 p-10 rounded-lg shadow-2xl border border-gray-700">

        <div class="mb-8">
            <a href="{{ url('/login') }}" class="inline-flex items-center text-sm font-semibold text-blue-400 hover:text-blue-300 transition duration-300 group">
                <span class="mr-2 transform group-hover:-translate-x-1 transition-transform">←</span> 
                Volver al inicio de sesión
            </a>
        </div>

        <div class="text-center mb-10">
            <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-16 w-20 mx-auto mb-1">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">Recupera tu clave</h1>
            <p class="text-gray-400 mt-2">Ingresa tus nuevos datos de acceso</p>
        </div>

        <form action="{{ route('password.request') }}" method="POST" class="space-y-6" id="reset-form">
            @csrf
            
            <div>
                <label for="correo" class="block text-sm font-medium text-gray-300">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required 
                    class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-500" 
                    placeholder="ejemplo@vgstorm.com">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="contrasena1" class="block text-sm font-medium text-gray-300">Nueva Contraseña</label>
                    <input type="password" id="contrasena1" name="contrasena1" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" 
                        placeholder="Tu nueva contraseña">
                </div>
                <div>
                    <label for="contrasena2" class="block text-sm font-medium text-gray-300">Confirmar Contraseña</label>
                    <input type="password" id="contrasena2" name="contrasena2" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" 
                        placeholder="Confirmar contraseña">
                </div>
            </div>

            <p id="validation-msg" class="text-xs font-medium text-red-500 hidden italic"></p>

            @if ($errors->any())
                <div class="bg-red-500/10 border-l-4 border-red-500 p-3 text-sm font-medium text-red-500" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" id="btn-save" disabled
                class="w-full neon-blue text-black font-bold py-3 px-4 rounded-md transition duration-300 uppercase tracking-wider text-sm mt-4 opacity-50 cursor-not-allowed">
                Guardar cambios
            </button>
        </form>
    </div>

    <script>
        const pass1 = document.getElementById('contrasena1');
        const pass2 = document.getElementById('contrasena2');
        const email = document.getElementById('correo');
        const errorMsg = document.getElementById('validation-msg');
        const submitBtn = document.getElementById('btn-save');

        function validateForm() {
            const v1 = pass1.value;
            const v2 = pass2.value;

            const isTooShort = v1.length < 8;
            const hasNoNumber = !/\d/.test(v1);
            const hasNoLetter = !/[a-zA-Z]/.test(v1);
            const hasNoUppercase = !/[A-Z]/.test(v1);
            const passwordsMatch = (v1 === v2 && v1 !== "");

            let message = "";
            let isValid = true;

            if (v1.length > 0) {
                if (v2.length > 0 && !passwordsMatch) { message = "❌ Las contraseñas no coinciden."; isValid = false; }
            } else {
                isValid = false;
            }

            if (v1.length > 0) {
                if (!isValid) {
                    errorMsg.innerText = message;
                    errorMsg.classList.remove('hidden');
                    pass1.classList.add('input-error');
                    pass1.classList.remove('input-success');
                } else {
                    errorMsg.classList.add('hidden');
                    pass1.classList.remove('input-error');
                    pass1.classList.add('input-success');
                }
            }

            if (v2.length > 0) {
                if (passwordsMatch) {
                    pass2.classList.add('input-success');
                    pass2.classList.remove('input-error');
                } else {
                    pass2.classList.add('input-error');
                    pass2.classList.remove('input-success');
                }
            }

            if (isValid && passwordsMatch && email.value.includes('@')) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        pass1.addEventListener('input', validateForm);
        pass2.addEventListener('input', validateForm);
        email.addEventListener('input', validateForm);
    </script>
</body>
</html>