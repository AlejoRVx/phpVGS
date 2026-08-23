@extends('layouts.app')

@section('title', $producto->nombre . ' - Reseñas')

@php
    $iconEstrella = "m8.243 7.34 -6.38 0.925 -0.113 0.023a1 1 0 0 0 -0.44 1.684l4.622 4.499 -1.09 6.355 -0.013 0.11a1 1 0 0 0 1.464 0.944l5.706 -3 5.693 3 0.1 0.046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355 4.624 -4.5 0.078 -0.085a1 1 0 0 0 -0.633 -1.62l-6.38 -0.926 -2.852 -5.78a1 1 0 0 0 -1.794 0L8.243 7.34z";
    $iconMedia = "M12 1a0.993 0.993 0 0 1 0.823 0.443l0.067 0.116 2.852 5.781 6.38 0.925c0.741 0.108 1.08 0.94 0.703 1.526l-0.07 0.095 -0.078 0.086 -4.624 4.499 1.09 6.355a1.001 1.001 0 0 1 -1.249 1.135l-0.101 -0.035 -0.101 -0.046 -5.693 -3 -5.706 3c-0.105 0.055 -0.212 0.09 -0.32 0.106l-0.106 0.01a1.003 1.003 0 0 1 -1.038 -1.06l0.013 -0.11 1.09 -6.355 -4.623 -4.5a1.001 1.001 0 0 1 0.328 -1.647l0.113 -0.036 0.114 -0.023 6.379 -0.925 2.853 -5.78A0.968 0.968 0 0 1 12 1zm0 3.274V16.75a1 1 0 0 1 0.239 0.029l0.115 0.036 0.112 0.05 4.363 2.299 -0.836 -4.873a1 1 0 0 1 0.136 -0.696l0.07 -0.099 0.082 -0.09 3.546 -3.453 -4.891 -0.708a1 1 0 0 1 -0.62 -0.344l-0.073 -0.097 -0.06 -0.106L12 4.274z";
@endphp

@section('content')
<div class="mb-6">
    <a href="{{ route('productos.' . strtolower($producto->tipo) . 's') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-800 text-blue-400 hover:text-blue-300 hover:bg-gray-700 rounded-lg border-2 border-blue-400 transition duration-300 shadow-lg hover:shadow-blue-400/30">
        <span class="mr-2 text-xl">←</span>
        <span class="font-semibold">Volver atrás</span>
    </a>
</div>

<section class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 p-4 sm:p-8">
        <div class="flex items-center justify-center">
            <img src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                 class="rounded-lg shadow-xl max-h-80 sm:max-h-96 w-full object-cover" loading="lazy">
        </div>
        <div class="flex flex-col justify-center">
            <h1 class="text-2xl sm:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-4">
                {{ $producto->nombre }}
            </h1>

            <div class="mb-6">
                <div class="flex items-center mb-3 flex-wrap gap-2">
                    <span class="text-yellow-400 text-2xl flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($promedioCalificacion))
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="{{ $iconEstrella }}"/></svg>
                            @elseif ($promedioCalificacion - floor($promedioCalificacion) >= 0.3 && $i == ceil($promedioCalificacion))
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="{{ $iconMedia }}"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-600 opacity-40"><path d="{{ $iconEstrella }}"/></svg>
                            @endif
                        @endfor
                    </span>
                    <span class="text-xl text-gray-300">{{ number_format($promedioCalificacion, 1) }}/5</span>
                    <span class="text-sm text-gray-500">{{ $cantidadResenas }} {{ $cantidadResenas == 1 ? 'reseña' : 'reseñas' }}</span>
                </div>
            </div>

            <div class="space-y-2 mb-6">
                @if ($producto->tipo == "Juego")
                    <p class="text-gray-300"><span class="font-semibold text-blue-400">Género:</span> {{ $producto->genero }}</p>
                @endif
                <p class="text-gray-300"><span class="font-semibold text-blue-400">Compañía:</span> {{ $producto->compania }}</p>
                <p class="text-gray-300"><span class="font-semibold text-blue-400">Lanzamiento:</span> {{ $producto->fecha_lanzamiento->format('d/m/Y') }}</p>
            </div>

            <p class="text-gray-400 mb-6 leading-relaxed">{{ $producto->descripcion }}</p>

            <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                <span class="text-3xl sm:text-4xl font-bold text-purple-400">${{ number_format($producto->precio, 2) }}</span>
                @auth
                    <form class="add-to-cart-form" data-product-id="{{ $producto->id }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 sm:px-6 py-2.5 sm:py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">
                            Añadir 🛒
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</section>

<hr class="border-t-2 border-gray-700 mb-12">

<section class="mb-12">
    <h2 class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        💬 Reseñas de Usuarios
    </h2>

    @guest
        <div class="bg-gray-800/50 rounded-xl shadow-2xl p-6 sm:p-8 mb-8 border border-gray-700 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-purple-500/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">¿Qué te pareció este producto?</h3>
            <p class="text-gray-400 mb-6">Inicia sesión para dejar tu reseña y calificación</p>
            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold rounded-xl transition-all shadow-lg hover:scale-105 active:scale-95">
                Iniciar sesión
            </a>
        </div>
    @endguest

    @auth
        @if($miResena)
            <div class="bg-gray-800 rounded-xl shadow-2xl p-4 sm:p-8 mb-8 border-l-4" style="border-color: #a855f7;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl sm:text-2xl font-semibold" style="color: #a855f7;">Tu reseña</h3>
                    <div class="flex gap-3">
                        <button onclick="abirEditarResena()" title="Editar reseña" class="text-gray-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button onclick="document.getElementById('modal-eliminar-resena').classList.remove('hidden')" title="Eliminar reseña" class="text-gray-400 hover:text-red-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 mb-3">
                    <div class="flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $miResena->calificacion)
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-400"><path d="{{ $iconEstrella }}"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-600 opacity-30"><path d="{{ $iconEstrella }}"/></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-400 font-semibold">{{ $miResena->calificacion }}/5</span>
                </div>
                <p class="text-gray-300 leading-relaxed">{{ $miResena->comentario }}</p>
            </div>

            <div id="form-editar-resena" class="hidden bg-gray-800 rounded-xl shadow-2xl p-4 sm:p-8 mb-8 border-l-4 border-yellow-500">
                <h3 class="text-xl sm:text-2xl font-semibold text-yellow-400 mb-6">Editar reseña</h3>
                <form action="{{ route('productos.resenas.editar', $miResena->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-6">
                        <label class="block text-gray-300 font-semibold mb-3">Calificación:</label>
                        <select name="calificacion" required
                            class="w-full px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                            <option value="5" {{ $miResena->calificacion == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ - Excelente (5/5)</option>
                            <option value="4" {{ $miResena->calificacion == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ - Muy bueno (4/5)</option>
                            <option value="3" {{ $miResena->calificacion == 3 ? 'selected' : '' }}>⭐⭐⭐ - Bueno (3/5)</option>
                            <option value="2" {{ $miResena->calificacion == 2 ? 'selected' : '' }}>⭐⭐ - Regular (2/5)</option>
                            <option value="1" {{ $miResena->calificacion == 1 ? 'selected' : '' }}>⭐ - Malo (1/5)</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-300 font-semibold mb-2">Comentario:</label>
                        <textarea name="comentario" rows="4"
                            class="w-full px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition resize-none">{{ $miResena->comentario }}</textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-500 text-white font-semibold rounded-lg transition">
                            Guardar cambios
                        </button>
                        <button type="button" onclick="cerrarEditarResena()" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold rounded-lg transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

            <div id="modal-eliminar-resena" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="document.getElementById('modal-eliminar-resena').classList.add('hidden')"></div>
                <div class="relative bg-gray-900 border border-gray-700 rounded-2xl p-6 sm:p-8 max-w-md w-full shadow-2xl">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-500/10 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">¿Eliminar tu reseña?</h3>
                        <p class="text-gray-400 text-sm">Esta acción no se puede deshacer. Podrás crear una nueva reseña después.</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="document.getElementById('modal-eliminar-resena').classList.add('hidden')"
                                class="flex-1 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold rounded-xl border border-gray-700 transition-all">
                            Cancelar
                        </button>
                        <form action="{{ route('productos.resenas.eliminar', $miResena->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl transition-all">
                                Sí, eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-800 rounded-xl shadow-2xl p-4 sm:p-8 mb-8">
                <h3 class="text-xl sm:text-2xl font-semibold text-blue-400 mb-6">Deja tu reseña</h3>
                <form action="{{ route('productos.resenas.agregar', $producto->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="calificacion" class="block text-gray-300 font-semibold mb-3">Calificación:</label>
                        <select name="calificacion" id="calificacion" required
                            class="w-full px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            <option value="">Selecciona una calificación</option>
                            <option value="5">⭐⭐⭐⭐⭐ - Excelente (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ - Muy bueno (4/5)</option>
                            <option value="3">⭐⭐⭐ - Bueno (3/5)</option>
                            <option value="2">⭐⭐ - Regular (2/5)</option>
                            <option value="1">⭐ - Malo (1/5)</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="comentario" class="block text-gray-300 font-semibold mb-2">Comentario:</label>
                        <textarea name="comentario" id="comentario" rows="5"
                            class="w-full px-4 py-3 bg-gray-900 text-white rounded-lg border-2 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-none"
                            placeholder="Cuéntanos qué te pareció este producto..."></textarea>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500">
                        Publicar Reseña 📝
                    </button>
                </form>
            </div>
        @endif
    @endauth

    @foreach ($resenas as $resena)
        <div class="bg-gray-800 rounded-xl shadow-xl p-4 sm:p-6 border-l-4 border-blue-400 mb-6">
            <div class="flex justify-between items-start mb-4 flex-wrap gap-2">
                <div>
                    <p class="text-sm text-gray-400">Por <span class="font-semibold text-blue-400">{{ explode(' ', $resena->usuario->nombre)[0] }}</span></p>
                    <p class="text-xs text-gray-500 mt-1">{{ $resena->fecha->format('d/m/Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $resena->calificacion)
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-400"><path d="{{ $iconEstrella }}"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-600 opacity-30"><path d="{{ $iconEstrella }}"/></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-400 font-semibold">{{ $resena->calificacion }}/5</span>
                </div>
            </div>
            <p class="text-gray-300 leading-relaxed">{{ $resena->comentario }}</p>
        </div>
    @endforeach

    @if($resenas->isEmpty())
        <div class="bg-gray-800 rounded-xl shadow-xl p-8 text-center">
            <p class="text-gray-400 text-lg">No hay reseñas todavía</p>
            <p class="text-gray-500 text-sm mt-2">¡Sé el primero en dejar una reseña!</p>
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
function abirEditarResena() {
    document.getElementById('form-editar-resena').classList.remove('hidden');
    document.getElementById('form-editar-resena').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function cerrarEditarResena() {
    document.getElementById('form-editar-resena').classList.add('hidden');
}
</script>
@endpush
