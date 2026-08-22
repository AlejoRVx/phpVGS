@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
<section class="text-center mb-8">
    <h2 class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        Editar Producto
    </h2>
</section>

<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 sm:p-8">
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            <input type="hidden" name="tipo" value="{{ $producto->tipo }}">

            <div class="mb-4">
                <label for="nombre" class="block text-gray-300 font-semibold mb-2">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="compania" class="block text-gray-300 font-semibold mb-2">Compañía *</label>
                <input type="text" id="compania" name="compania" value="{{ old('compania', $producto->compania) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            @if ($producto->tipo == "Juego")
                <div class="mb-4">
                    <label for="genero" class="block text-gray-300 font-semibold mb-2">Género *</label>
                    <input type="text" id="genero" name="genero" value="{{ old('genero', $producto->genero) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            @endif

            <div class="mb-4">
                <label for="fecha_lanzamiento" class="block text-gray-300 font-semibold mb-2">Fecha lanzamiento *</label>
                <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" value="{{ old('fecha_lanzamiento', date('Y-m-d', strtotime($producto->fecha_lanzamiento))) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="precio" class="block text-gray-300 font-semibold mb-2">Precio *</label>
                <input type="number" step="0.1" min="0" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-gray-300 font-semibold mb-2">Stock *</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-gray-300 font-semibold mb-2">Descripción *</label>
                <textarea rows="4" id="descripcion" name="descripcion" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-300 font-semibold mb-2">Imagen</label>
                <div id="drop-zone" class="relative border-2 border-dashed border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-400/5 transition-all">
                    <input type="file" id="imagen-input" name="imagen" accept="image/*" class="hidden">
                    <div id="drop-placeholder" class="{{ $producto->imagen ? 'hidden' : '' }}">
                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-400 text-sm">Arrastra una imagen aquí o <span class="text-blue-400 font-semibold">haz clic</span></p>
                        <p class="text-gray-500 text-xs mt-1">Deja vacío para mantener la imagen actual</p>
                    </div>
                    <div id="drop-preview" class="{{ $producto->imagen ? '' : 'hidden' }}">
                        <img id="preview-img" class="max-h-48 mx-auto rounded-lg object-cover" src="{{ $producto->imagen ? asset('img/' . $producto->imagen) : '' }}">
                        <p id="preview-name" class="text-gray-400 text-xs mt-2">{{ $producto->imagen }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.productos.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
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

document.addEventListener('DOMContentLoaded', () => {
    @if(session('success'))
        showToast("{{ session('success') }}", "success");
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", "error");
    @endif
});
</script>
@endsection
