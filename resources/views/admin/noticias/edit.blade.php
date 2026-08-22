@extends('layouts.admin')

@section('title', 'Editar Noticia')

@section('content')
<section class="text-center mb-8">
    <h2 class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        Editar Noticia
    </h2>
</section>

<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 sm:p-8">
        <form action="{{ route('admin.noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="titulo" class="block text-gray-300 font-semibold mb-2">Título *</label>
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $noticia->titulo) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="resumen" class="block text-gray-300 font-semibold mb-2">Resumen *</label>
                <textarea id="resumen" name="resumen" rows="2" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('resumen', $noticia->resumen) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Imagen</label>
                <div id="drop-zone" class="relative border-2 border-dashed border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-400/5 transition-all">
                    <input type="file" id="imagen-input" name="imagen" accept="image/*" class="hidden">
                    <div id="drop-placeholder" class="{{ $noticia->imagen ? 'hidden' : '' }}">
                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-400 text-sm">Arrastra una imagen aquí o <span class="text-blue-400 font-semibold">haz clic</span></p>
                        <p class="text-gray-500 text-xs mt-1">Deja vacío para mantener la imagen actual</p>
                    </div>
                    <div id="drop-preview" class="{{ $noticia->imagen ? '' : 'hidden' }}">
                        <img id="preview-img" class="max-h-48 mx-auto rounded-lg object-cover" src="{{ $noticia->imagen ? asset('storage/' . $noticia->imagen) : '' }}">
                        <p id="preview-name" class="text-gray-400 text-xs mt-2">{{ $noticia->imagen }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="categoria" class="block text-gray-300 font-semibold mb-2">Categoría *</label>
                <select id="categoria" name="categoria" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="" disabled {{ old('categoria', $noticia->categoria) ? '' : 'selected' }}>Selecciona una categoría</option>
                    <option value="Hardware" {{ old('categoria', $noticia->categoria) === 'Hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="Lanzamientos" {{ old('categoria', $noticia->categoria) === 'Lanzamientos' ? 'selected' : '' }}>Lanzamientos</option>
                    <option value="Eventos" {{ old('categoria', $noticia->categoria) === 'Eventos' ? 'selected' : '' }}>Eventos</option>
                    <option value="General" {{ old('categoria', $noticia->categoria) === 'General' ? 'selected' : '' }}>General</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="enlace" class="block text-gray-300 font-semibold mb-2">Enlace (Opcional)</label>
                <input type="url" id="enlace" name="enlace" value="{{ old('enlace', $noticia->enlace) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <p class="text-xs text-gray-400 mt-2">URL externa opcional para la noticia.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.noticias.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
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

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-400', 'bg-blue-400/10');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-blue-400', 'bg-blue-400/10');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-400/10');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        showPreview(e.dataTransfer.files[0]);
    }
});

fileInput.addEventListener('change', () => {
    if (fileInput.files.length) showPreview(fileInput.files[0]);
});

function showPreview(file) {
    if (!file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        previewName.textContent = file.name;
        placeholder.classList.add('hidden');
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
