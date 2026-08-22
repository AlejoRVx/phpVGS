@extends('layouts.admin')

@section('title', 'Agregar producto')

@section('content')
<section class="text-center mb-8">
    <h2 class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        Agregar Producto
    </h2>
</section>

<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 sm:p-8">
        <div class="flex flex-col items-center mb-8">
            <div class="bg-gray-900 p-1 rounded-full flex items-center border border-gray-700 relative w-64 mb-6">
                <div id="switch-bg" class="absolute h-9 w-32 bg-blue-600 rounded-full transition-all duration-300 ease-in-out"></div>
                <button type="button" onclick="toggleTipo('Juego')" id="btn-juego"
                        class="relative z-10 w-32 py-2 text-sm font-bold transition-colors duration-300 text-white">
                    Juego
                </button>
                <button type="button" onclick="toggleTipo('Consola')" id="btn-consola"
                        class="relative z-10 w-32 py-2 text-sm font-bold transition-colors duration-300 text-gray-400">
                    Consola
                </button>
            </div>
            <h3 class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                Agregar producto
            </h3>
        </div>

        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tipo" id="tipo_input" value="Juego">

            <div class="mb-4">
                <label for="nombre" class="block text-gray-300 font-semibold mb-2">Nombre *</label>
                <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="compania" class="block text-gray-300 font-semibold mb-2">Compañía *</label>
                <input type="text" id="compania" name="compania" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div id="campo-genero" class="mb-4 transition-all duration-300">
                <label for="genero" class="block text-gray-300 font-semibold mb-2">Género *</label>
                <input type="text" id="genero" name="genero" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label for="fecha_lanzamiento" class="block text-gray-300 font-semibold mb-2">Fecha de Lanzamiento *</label>
                <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="precio" class="block text-gray-300 font-semibold mb-2">Precio *</label>
                <input type="number" step="0.1" id="precio" name="precio" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-gray-300 font-semibold mb-2">Stock *</label>
                <input type="number" id="stock" name="stock" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-gray-300 font-semibold mb-2">Descripción *</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-300 font-semibold mb-2">Imagen *</label>
                <div id="drop-zone" class="relative border-2 border-dashed border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-400/5 transition-all">
                    <input type="file" id="imagen-input" name="imagen" accept="image/*" class="hidden" required>
                    <div id="drop-placeholder">
                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-400 text-sm">Arrastra una imagen aquí o <span class="text-blue-400 font-semibold">haz clic</span></p>
                        <p class="text-gray-500 text-xs mt-1">JPG, PNG, GIF, WEBP (máx. 2MB)</p>
                    </div>
                    <div id="drop-preview" class="hidden">
                        <img id="preview-img" class="max-h-48 mx-auto rounded-lg object-cover">
                        <p id="preview-name" class="text-gray-400 text-xs mt-2"></p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                    Guardar Producto
                </button>
                <a href="{{ route('admin.productos.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleTipo(tipo) {
    const btnJuego = document.getElementById('btn-juego');
    const btnConsola = document.getElementById('btn-consola');
    const switchBg = document.getElementById('switch-bg');
    const campoGenero = document.getElementById('campo-genero');
    const inputTipo = document.getElementById('tipo_input');
    const inputGenero = document.getElementById('genero');

    if (tipo === 'Juego') {
        switchBg.style.transform = 'translateX(0px)';
        switchBg.classList.replace('bg-purple-600', 'bg-blue-600');
        btnJuego.classList.replace('text-gray-400', 'text-white');
        btnConsola.classList.replace('text-white', 'text-gray-400');
        campoGenero.style.display = 'block';
        inputTipo.value = 'Juego';
        inputGenero.required = true;
    } else {
        switchBg.style.transform = 'translateX(124px)';
        switchBg.classList.replace('bg-blue-600', 'bg-purple-600');
        btnConsola.classList.replace('text-gray-400', 'text-white');
        btnJuego.classList.replace('text-white', 'text-gray-400');
        campoGenero.style.display = 'none';
        inputTipo.value = 'Consola';
        inputGenero.required = false;
        inputGenero.value = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    toggleTipo('Juego');

    @if(session('success'))
        showToast("{{ session('success') }}", "success");
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", "error");
    @endif
});

const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('imagen-input');
const placeholder = document.getElementById('drop-placeholder');
const preview = document.getElementById('drop-preview');
const previewImg = document.getElementById('preview-img');
const previewName = document.getElementById('preview-name');

dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-blue-400', 'bg-blue-400/10'); });
dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-blue-400', 'bg-blue-400/10'); });
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-400/10');
    if (e.dataTransfer.files.length) { fileInput.files = e.dataTransfer.files; showPreview(e.dataTransfer.files[0]); }
});
fileInput.addEventListener('change', () => { if (fileInput.files.length) showPreview(fileInput.files[0]); });

function showPreview(file) {
    if (!file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = (e) => { previewImg.src = e.target.result; previewName.textContent = file.name; placeholder.classList.add('hidden'); preview.classList.remove('hidden'); };
    reader.readAsDataURL(file);
}
</script>
@endsection
