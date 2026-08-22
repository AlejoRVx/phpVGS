@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<section class="text-center mb-8">
    <h2 class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        Editar Usuario
    </h2>
</section>

<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 sm:p-8">
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
            @csrf

            <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">

            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Correo Electrónico</label>
                <input type="email" value="{{ $usuario->correo }}" class="w-full px-4 py-2 bg-gray-700 text-gray-400 rounded border border-gray-600 cursor-not-allowed" disabled>
                <p class="text-sm text-gray-400 mt-1">El correo no se puede modificar</p>
            </div>

            <div class="mb-4">
                <label for="nombre" class="block text-gray-300 font-semibold mb-2">Nombre Completo *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('nombre')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="direccion" class="block text-gray-300 font-semibold mb-2">Dirección *</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $usuario->direccion) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('direccion')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="telefono" class="block text-gray-300 font-semibold mb-2">Teléfono *</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('telefono')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="rol_id" class="block text-gray-300 font-semibold mb-2">Rol *</label>
                <select id="rol_id" name="rol_id" class="w-full px-4 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="1" {{ $usuario->rol_id == 1 ? 'selected' : '' }}>Usuario</option>
                    <option value="2" {{ $usuario->rol_id == 2 ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('rol_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-3 rounded transition duration-300">
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 rounded transition duration-300 text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
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
