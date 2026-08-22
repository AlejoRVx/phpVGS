<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    <title>Recuperar contrasena - VGStorm</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900 text-white">
    <div class="max-w-xl w-full mx-auto bg-gray-900 p-6 sm:p-10 rounded-lg shadow-2xl border border-gray-700">
        <div class="mb-8">
            <a href="{{ url('/login') }}" class="inline-flex items-center text-sm font-semibold text-blue-400 hover:text-blue-300 transition duration-300 group">
                <span class="mr-2 transform group-hover:-translate-x-1 transition-transform">&larr;</span> Volver al inicio de sesion
            </a>
        </div>
        <div class="text-center mb-10">
            <img src="{{ asset('logo.ico') }}" alt="VGStorm Logo" class="h-16 w-20 mx-auto mb-1">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">Recupera tu clave</h1>
            <p class="text-gray-400 mt-2">Ingresa tus nuevos datos de acceso</p>
        </div>

        <form action="{{ route('nueva_clave.actualizar') }}" method="POST" class="space-y-6" id="reset-form">
            @csrf
            <input type="hidden" id="correo" name="correo" value="{{ $correoUsuario }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="contrasena1" class="block text-sm font-medium text-gray-300">Nueva Contrasena</label>
                    <input type="password" id="contrasena1" name="contrasena1" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all" 
                        placeholder="Tu nueva contrasena">
                </div>
                <div>
                    <label for="contrasena2" class="block text-sm font-medium text-gray-300">Confirmar Contrasena</label>
                    <input type="password" id="contrasena2" name="contrasena2" required 
                        class="mt-1 block w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-white transition-all" 
                        placeholder="Confirmar contrasena">
                </div>
            </div>

            <p id="validation-msg" class="text-xs font-medium text-red-500 hidden italic text-center"></p>

            @if ($errors->any())
                <div class="bg-red-500/10 border-l-4 border-red-500 p-3 text-sm font-medium text-red-500 rounded" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" id="btn-save" disabled
                class="w-full bg-blue-500 hover:bg-blue-400 text-black font-bold py-3 px-4 rounded-md transition duration-300 uppercase tracking-wider text-sm mt-4 opacity-50 cursor-not-allowed">
                Guardar cambios
            </button>
        </form>
    </div>

    <script>
        const pass1 = document.getElementById('contrasena1');
        const pass2 = document.getElementById('contrasena2');
        const errorMsg = document.getElementById('validation-msg');
        const submitBtn = document.getElementById('btn-save');

        function validateForm() {
            const v1 = pass1.value;
            const v2 = pass2.value;

            const isTooShort = v1.length < 8;
            const hasLowercase = /[a-z]/.test(v1);
            const hasUppercase = /[A-Z]/.test(v1);
            const hasNumber = /[0-9]/.test(v1);
            const passwordsMatch = (v1 === v2 && v1 !== "");

            let message = "";
            let isValid = true;

            if (v1.length > 0) {
                if (isTooShort) { message = "La contrasena debe tener al menos 8 caracteres."; isValid = false; }
                else if (!hasLowercase) { message = "Debe incluir al menos una letra minuscula."; isValid = false; }
                else if (!hasUppercase) { message = "Debe incluir al menos una letra mayuscula."; isValid = false; }
                else if (!hasNumber) { message = "Debe incluir al menos un numero."; isValid = false; }
            } else { isValid = false; }

            if (v1.length > 0) {
                if (!isValid) {
                    errorMsg.innerText = message; errorMsg.classList.remove('hidden');
                    pass1.classList.add('border-red-500'); pass1.classList.remove('border-green-500');
                } else {
                    errorMsg.classList.add('hidden');
                    pass1.classList.remove('border-red-500'); pass1.classList.add('border-green-500');
                }
            } else { errorMsg.classList.add('hidden'); pass1.classList.remove('border-red-500', 'border-green-500'); }

            if (v2.length > 0) {
                if (passwordsMatch && isValid) { pass2.classList.add('border-green-500'); pass2.classList.remove('border-red-500'); }
                else {
                    if (v1 !== v2) { errorMsg.innerText = "Las contrasenas no coinciden."; errorMsg.classList.remove('hidden'); }
                    pass2.classList.add('border-red-500'); pass2.classList.remove('border-green-500');
                }
            } else { pass2.classList.remove('border-red-500', 'border-green-500'); }

            if (isValid && passwordsMatch) {
                submitBtn.disabled = false; submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true; submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        pass1.addEventListener('input', validateForm);
        pass2.addEventListener('input', validateForm);
    </script>
</body>
</html>