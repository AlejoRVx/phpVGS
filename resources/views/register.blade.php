<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Registro - VGStorm</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900 text-white">
    <div class="max-w-xl w-full mx-auto bg-gray-900 p-6 sm:p-10 rounded-lg shadow-2xl border border-gray-700">
        <a href="{{ route('main') }}" class="flex items-center gap-2 text-gray-400 hover:text-white transition mb-6 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al inicio
        </a>
        <div class="text-center mb-10">
            <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-16 w-20 mx-auto mb-1">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">VGStorm</h1>
            <p class="text-lg mt-2 text-gray-300">¡Únete a la mejor experiencia gaming!</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border-l-4 border-red-500 text-red-400 p-4 rounded mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-300">Correo</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-500"
                        placeholder="ejemplo@vgstorm.com">
                </div>
                <div>
                    <label for="contrasena" class="block text-sm font-medium text-gray-300">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                        placeholder="Tu contraseña segura">
                    
                    <p id="password-error" class="text-[11px] mt-2 font-medium text-red-500 hidden italic">
                        La contraseña debe tener al menos 8 caracteres.
                    </p>
                </div>
            </div>

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-300">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required 
                    class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-300">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
                </div>
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-300">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
                </div>
            </div>

            <button type="submit" id="btn-registrar" disabled 
                class="w-full bg-blue-500 hover:bg-blue-400 text-black font-bold py-3 px-4 rounded-md transition duration-300 uppercase tracking-widest text-sm mt-4 opacity-50 cursor-not-allowed">
                Registrarse
            </button>
        </form>

        <div class="mt-8 text-center pt-6 border-t border-gray-800">
            <p class="text-gray-300">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium ml-1">Inicia sesión aquí</a></p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('contrasena');
        const errorMsg = document.getElementById('password-error');
        const submitBtn = document.getElementById('btn-registrar');
        const form = document.querySelector('form');
        const requiredInputs = form.querySelectorAll('input[required]');

        function validarTodo() {
            const value = passwordInput.value;
            
            const isTooShort = value.length < 8;
            const hasNoNumber = !/\d/.test(value);
            const hasNoLetter = !/[a-zA-Z]/.test(value);
            const hasNoUppercase = !/[A-Z]/.test(value);

            const isInvalid = isTooShort || hasNoNumber || hasNoLetter || hasNoUppercase;

            if (value.length > 0 && isInvalid) {
                errorMsg.classList.remove('hidden');
                passwordInput.classList.remove('border-green-500', 'focus:ring-green-500');
                passwordInput.classList.add('border-red-500', 'focus:ring-red-500');
                
                if (isTooShort) {
                    errorMsg.innerText = "La contraseña debe tener al menos 8 caracteres.";
                } else if (hasNoNumber) {
                    errorMsg.innerText = "La contraseña debe contener al menos un número.";
                } else if (hasNoLetter) {
                    errorMsg.innerText = "La contraseña debe contener al menos una letra.";
                } else if (hasNoUppercase) {
                    errorMsg.innerText = "La contraseña debe contener al menos una letra mayúscula.";
                }
            } else if (value.length > 0) {
                errorMsg.classList.add('hidden');
                passwordInput.classList.remove('border-red-500', 'focus:ring-red-500');
                passwordInput.classList.add('border-green-500', 'focus:ring-green-500');
            } else {
                errorMsg.classList.add('hidden');
                passwordInput.classList.remove('border-red-500', 'border-green-500');
            }

            let allFieldsFilled = true;
            requiredInputs.forEach(input => { if(input.value.trim() === "") allFieldsFilled = false; });

            if (!isInvalid && allFieldsFilled && value.length > 0) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        requiredInputs.forEach(input => {
            input.addEventListener('input', validarTodo);
        });
    </script>
</body>
</html>