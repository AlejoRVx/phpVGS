<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Recuperar contraseña - VGStorm</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900 text-white">
    <div class="max-w-xl w-full mx-auto bg-gray-900 p-6 sm:p-10 rounded-lg shadow-2xl border border-gray-700">
        <div class="mb-8">
            <a href="{{ url('/login') }}" class="inline-flex items-center text-sm font-semibold text-blue-400 hover:text-blue-300 transition duration-300 group">
                <span class="mr-2 transform group-hover:-translate-x-1 transition-transform">←</span> Volver al inicio de sesión
            </a>
        </div>
        <div class="text-center mb-10">
            <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-16 w-20 mx-auto mb-1">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">Recupera tu clave</h1>
            <p class="text-gray-400 mt-2">Ingresa tu correo</p>
        </div>

        <form action="{{ url('/clave-olvidada') }}" method="POST" class="space-y-6" id="reset-form">
            @csrf
            <div>
                <label for="correo" class="block text-sm font-medium text-gray-300">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required 
                    class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-500" 
                    placeholder="ejemplo@vgstorm.com">
            </div>
            <p id="validation-msg" class="text-xs font-medium text-red-500 hidden italic"></p>

            @if ($errors->any())
                <div class="bg-red-500/10 border-l-4 border-red-500 p-3 text-sm font-medium text-red-500 rounded" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" id="btn-save" disabled
                class="w-full bg-blue-500 hover:bg-blue-400 text-black font-bold py-3 px-4 rounded-md transition duration-300 uppercase tracking-wider text-sm mt-4 opacity-50 cursor-not-allowed">
                Enviar enlace
            </button>
        </form>
    </div>

    <script>
        const emailInput = document.getElementById('correo');
        const errorMsg = document.getElementById('validation-msg');
        const submitBtn = document.getElementById('btn-save');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function validateEmail() {
            const emailValue = emailInput.value.trim();
            if (emailValue === "") {
                errorMsg.classList.add('hidden');
                emailInput.classList.remove('border-red-500', 'border-green-500');
                disableButton();
            } else if (!emailRegex.test(emailValue)) {
                errorMsg.innerText = "❌ Por favor, ingresa un correo electrónico válido.";
                errorMsg.classList.remove('hidden');
                emailInput.classList.add('border-red-500');
                emailInput.classList.remove('border-green-500');
                disableButton();
            } else {
                errorMsg.classList.add('hidden');
                emailInput.classList.remove('border-red-500');
                emailInput.classList.add('border-green-500');
                enableButton();
            }
        }

        function enableButton() { submitBtn.disabled = false; submitBtn.classList.remove('opacity-50', 'cursor-not-allowed'); }
        function disableButton() { submitBtn.disabled = true; submitBtn.classList.add('opacity-50', 'cursor-not-allowed'); }
        emailInput.addEventListener('input', validateEmail);
    </script>
</body>
</html>