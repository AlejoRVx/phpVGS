@extends('layouts.admin')

@section('title', 'Productos - Panel de Administración')

@section('content')

<section class="text-center mb-8">
    <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        🛒 Gestión de Productos
    </h2>
</section>

<section class="mb-12">
    <form method="GET" action="{{ route('admin.productos.search') }}" class="max-w-3xl mx-auto flex">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar producto..." 
            class="w-full px-4 text-white bg-gray-900 rounded-l-lg border-2 border-r-0 border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

        <button type="submit" class="px-5 bg-purple-800 text-white rounded-r-lg hover:bg-purple-600 transition duration-300">
            🔎 Buscar
        </button>
    </form>
</section>

<div class="flex justify-center gap-4 mb-6">
    <a href="{{ route('admin.productos.index') }}" 
       class="px-4 py-2 rounded transition {{ !request('tipo') ? 'bg-blue-600 text-white' : 'bg-gray-700 hover:bg-gray-600' }}">Todos</a>
    
    <a href="{{ route('admin.productos.index', ['tipo' => 'Juego']) }}" 
       class="px-4 py-2 rounded transition {{ request('tipo') === 'Juego' ? 'bg-blue-600 text-white' : 'bg-gray-700 hover:bg-gray-600' }}">Juegos</a>
    
    <a href="{{ route('admin.productos.index', ['tipo' => 'Consola']) }}" 
       class="px-4 py-2 rounded transition {{ request('tipo') === 'Consola' ? 'bg-purple-600 text-white' : 'bg-gray-700 hover:bg-gray-600' }}">Consolas</a>
</div>

<hr class="border-t-2 border-gray-700 mt-8 mb-8">

<section class="py-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
            📦 Catálogo de Productos
        </h2>

        <a href="{{ route('admin.productos.create') }}" 
           class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 shadow-lg shadow-green-900/20 transition duration-300">
            + Agregar Producto
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @if($productos->isEmpty())
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-20 bg-gray-800/40 rounded-2xl border-2 border-dashed border-gray-600">
                <div class="bg-gray-900/50 p-6 rounded-full mb-6 shadow-inner">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-2 text-center">
                    {{ request('q') ? 'Sin coincidencias para "' . request('q') . '"' : 'El inventario está vacío' }}
                </h3>
                
                <p class="text-gray-400 text-center max-w-md mb-8 px-6">
                    {{ request('q') 
                        ? 'No encontramos productos con ese nombre. Intenta con un término diferente.' 
                        : 'Aún no has cargado productos al sistema. Usa el botón superior para empezar.' 
                    }}
                </p>

                @if(request('q') || request('tipo'))
                    <a href="{{ route('admin.productos.index') }}" class="px-8 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-300 flex items-center gap-2">
                        <span>🔙</span> Ver todo el catálogo
                    </a>
                @endif
            </div>
        @endif

        @foreach ($productos as $producto)
            <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden hover:scale-[1.02] transition-transform duration-300 flex flex-col">
                <img class="w-full h-48 object-cover" 
                     src="{{ asset('img/' . $producto->imagen) }}" 
                     alt="{{ $producto->nombre }}">

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-blue-400 mb-2">{{ $producto->nombre }}</h3>

                    <div class="text-sm text-gray-400 mb-3">
                        <p><strong>Tipo:</strong> {{ $producto->tipo }}</p>
                        @if($producto->tipo === 'Juego')
                            <p><strong>Género:</strong> {{ $producto->genero }}</p>
                        @endif
                        <p><strong>Compañía:</strong> {{ $producto->compania }}</p>
                    </div>

                    <p class="text-sm text-gray-400 mb-4 line-clamp-3">
                        {{ $producto->descripcion }}
                    </p>

                    <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-700">
                        <span class="text-2xl font-bold text-purple-400">
                            ${{ number_format($producto->precio) }}
                        </span>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.productos.edit', $producto->id) }}" 
                               class="px-4 py-2 bg-blue-600 rounded text-sm hover:bg-blue-500 transition duration-300">
                                Editar
                            </a>

                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                                        class="px-4 py-2 bg-red-600 rounded text-sm hover:bg-red-500 transition duration-300">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection

@push('scripts')
<script>
    function showToast(message, type = 'success') {
        const container = $('#toast-container');
        const bgColor = type === 'success' ? 'bg-purple-600' : 'bg-red-600';
        const icon = type === 'success' ? '✅' : '❌';

        const toastHtml = `
            <div class="toast ${bgColor} text-white p-4 rounded-lg shadow-2xl transition duration-500 transform -translate-y-full opacity-0 max-w-sm" style="min-width: 300px;">
                <p class="font-semibold">${icon} ${message}</p>
            </div>
        `;

        const newToast = $(toastHtml).appendTo(container);
        
        setTimeout(() => {
            newToast.removeClass('-translate-y-full opacity-0').addClass('translate-y-0 opacity-100');
        }, 10);

        setTimeout(() => {
            newToast.removeClass('translate-y-0 opacity-100').addClass('-translate-y-full opacity-0');
            newToast.on('transitionend', function() {
                newToast.remove();
            });
        }, 3000);
    }

    $(document).ready(function() {
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    });
</script>
@endpush