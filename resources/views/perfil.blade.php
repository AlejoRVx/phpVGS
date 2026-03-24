@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')

<section class="text-center mb-10">
    <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-2">
        Mi Perfil
    </h2>
    <p class="text-gray-400">Administra tu información personal</p>
</section>

<div class="max-w-2xl mx-auto">

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-green-500/10 border border-green-500/30 text-green-400 px-5 py-4 rounded-xl">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 border border-gray-700 rounded-2xl p-8 mb-6 flex items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
            <span class="text-3xl font-black text-white">
                {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
            </span>
        </div>
        <div>
            <p class="text-2xl font-bold text-white">{{ $usuario->nombre }}</p>
            <p class="text-gray-400 text-sm mt-1">{{ $usuario->correo }}</p>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-700 rounded-2xl overflow-hidden">

        <div class="px-8 py-5 border-b border-gray-700 bg-gray-800/40">
            <p class="text-white font-bold text-lg">Información personal</p>
            <p class="text-gray-400 text-sm">Actualiza tus datos de contacto y entrega</p>
        </div>

        <form action="{{ route('perfil.actualizar') }}" method="POST" class="px-8 py-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">
                    Nombre completo
                </label>
                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $usuario->nombre) }}"
                       class="w-full bg-gray-800 border {{ $errors->has('nombre') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition placeholder-gray-500"
                       placeholder="Tu nombre completo">
                @error('nombre')
                    <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">
                    Teléfono
                </label>
                <input type="text"
                       name="telefono"
                       value="{{ old('telefono', $usuario->telefono) }}"
                       class="w-full bg-gray-800 border {{ $errors->has('telefono') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition placeholder-gray-500"
                       placeholder="Tu número de teléfono">
                @error('telefono')
                    <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">
                    Dirección de entrega
                </label>
                <textarea name="direccion"
                          rows="3"
                          class="w-full bg-gray-800 border {{ $errors->has('direccion') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition placeholder-gray-500 resize-none"
                          placeholder="Tu dirección completa">{{ old('direccion', $usuario->direccion) }}</textarea>
                @error('direccion')
                    <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">
                    Correo electrónico
                </label>
                <input type="email"
                       name="correo"
                       value="{{ old('correo', $usuario->correo) }}"
                       class="w-full bg-gray-800 border {{ $errors->has('correo') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition placeholder-gray-500"
                       placeholder="Tu correo electrónico">
                @error('correo')
                    <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-purple-600/30 transition-all hover:scale-105 active:scale-95">
                    💾 Guardar cambios
                </button>
                <a href="{{ route('main') }}"
                   class="flex-1 py-3 text-center bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-semibold rounded-xl border border-gray-700 transition-all">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection