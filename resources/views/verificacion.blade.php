<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Verificar Código - VGStorm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .neon-blue { background-color: #00efffff; box-shadow: 0 0 4px #00efffff; }
        .neon-blue:hover:not(:disabled) { box-shadow: 0 0 8px #00efffff; }
        body { background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .input-error { border-color: #ef4444 !important; }
        .input-success { border-color: #22c55e !important; }
    </style>
</head>
<body class="text-white p-4">
    <div class="max-w-xl w-full mx-auto bg-gray-900 p-10 rounded-lg shadow-2xl border border-gray-700">
        <div class="mb-8">
            <a href="{{ url('/login') }}" class="inline-flex items-center text-sm font-semibold text-blue-400 hover:text-blue-300 transition duration-300 group">
                <span class="mr-2 transform group-hover:-translate-x-1 transition-transform">←</span> Volver al inicio de sesión
            </a>
        </div>
        <div class="text-center mb-10">
            <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-16 w-20 mx-auto mb-1">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">Verifica tu código</h1>
            <p class="text-gray-400 mt-2">Ingresa el código enviado a tu correo <br> <span class="font-bold">{{ session('verificacion_correo') }}</span></p>
        </div>

        <form action="{{ route('verificacion.validar') }}" method="POST" class="space-y-6" id="reset-form">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 text-center mb-4">Código de verificación</label>
                <div class="flex justify-center gap-3" id="otp-container">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-2xl font-bold bg-gray-800 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-2xl font-bold bg-gray-800 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-2xl font-bold bg-gray-800 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-2xl font-bold bg-gray-800 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-2xl font-bold bg-gray-800 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-2xl font-bold bg-gray-800 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all">
                </div>
                <input type="hidden" id="correo" name="correo" required>
            </div>

            <p id="validation-msg" class="text-xs font-medium text-red-500 hidden text-center italic"></p>

            @if ($errors->any())
                <div class="bg-red-500/10 border-l-4 border-red-500 p-3 text-sm font-medium text-red-500 rounded" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" id="btn-save" disabled
                class="w-full neon-blue text-black font-bold py-3 px-4 rounded-md transition duration-300 uppercase tracking-wider text-sm mt-4 opacity-50 cursor-not-allowed">
                Validar Código
            </button>
        </form>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-field');
        const hiddenInput = document.getElementById('correo');
        const errorMsg = document.getElementById('validation-msg');
        const submitBtn = document.getElementById('btn-save');

        inputs.forEach((input, index) => {
            // 1. CAPTURAR EL EVENTO DE PEGAR (Ctrl + V)
            input.addEventListener('paste', (e) => {
                e.preventDefault(); // Evitamos el comportamiento por defecto
                
                // Obtenemos el texto del portapapeles y limpiamos dejando solo números
                const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                const cleanData = pasteData.replace(/[^0-9]/g, '').substring(0, inputs.length);

                // Distribuimos los números en los cuadritos
                cleanData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });

                // Enfocamos el último cuadrito lleno o el último disponible
                const focusIndex = cleanData.length < inputs.length ? cleanData.length : inputs.length - 1;
                if (inputs[focusIndex]) {
                    inputs[focusIndex].focus();
                }

                // Actualizamos el input oculto que va al servidor
                updateFullCode();
            });

            // 2. CONTROL DE ENTRADA MANUAL (Solo números)
            input.addEventListener('input', (e) => {
                input.value = input.value.replace(/[^0-9]/g, '');
                if (input.value.length === 1 && index < inputs.length - 1) { 
                    inputs[index + 1].focus(); 
                }
                updateFullCode();
            });

            // 3. MEJORA DE NAVEGACIÓN CON TECLADO (Borrar y Flechas)
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) { 
                    inputs[index - 1].focus(); 
                }
                if (e.key === 'ArrowLeft' && index > 0) {
                    inputs[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });

        // 4. FUNCIÓN PARA REUNIR EL CÓDIGO Y HABILITAR EL BOTÓN
        function updateFullCode() {
            let code = "";
            inputs.forEach(input => code += input.value);
            hiddenInput.value = code;

            if (code.length === inputs.length) {
                errorMsg.classList.add('hidden');
                inputs.forEach(input => { 
                    input.classList.remove('input-error'); 
                    input.classList.add('input-success'); 
                });
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                inputs.forEach(input => input.classList.remove('input-success', 'input-error'));
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    </script>
</body>
</html>