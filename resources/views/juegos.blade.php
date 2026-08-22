@extends('layouts.app')

@section('title', 'Juegos')
@section('search-bar')
@endsection

@section('content')
<section id="catalogo-juegos" class="py-6">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-6 sm:mb-8 text-center tracking-tight">
        🕹️ Catálogo de Juegos Digitales
    </h2>

    @include('partials._filtros')

    @if($productos->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-gray-800/30 rounded-3xl border-2 border-dashed border-purple-900/50">
            <div class="bg-gray-900 p-6 rounded-full mb-6 shadow-xl shadow-purple-500/10">
                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl sm:text-3xl font-bold text-white mb-2">¡Vaya! No encontramos ese juego</h3>
            <p class="text-gray-400 text-center max-w-md mb-8 px-6">
                {{ request('q')
                    ? 'Parece que "' . request('q') . '" no está en nuestra biblioteca. Intenta con otro nombre.'
                    : 'Parece que aún no tenemos juegos disponibles.'
                }}
            </p>
            @if(request('q'))
                <a href="{{ route('productos.juegos') }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold rounded-full transition transform hover:scale-105 shadow-lg shadow-purple-600/30">
                    🔄 Ver todo el catálogo
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach ($productos as $producto)
                <div class="bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden transition duration-300 transform hover:scale-[1.02] hover:shadow-blue-500/30 border border-gray-700 flex flex-col group">
                    <a href="{{ route('productos.resenas', ['id' => $producto->id]) }}" class="overflow-hidden block">
                        <img class="w-full h-48 object-cover object-center" loading="lazy"
                             src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    </a>
                    <div class="p-5 sm:p-6 flex flex-col flex-grow">
                        <a href="{{ route('productos.resenas', ['id' => $producto->id]) }}">
                            <h3 class="text-lg sm:text-xl font-bold text-blue-400 mb-2 hover:text-blue-300 transition-colors tracking-tight leading-tight">
                                {{ $producto->nombre }}
                            </h3>
                        </a>
                        <div class="text-sm text-gray-400 mb-4 space-y-1">
                            <p><span class="font-semibold text-gray-300">Género:</span> {{ $producto->genero }}</p>
                            <p><span class="font-semibold text-gray-300">Compañía:</span> {{ $producto->compania }}</p>
                            <p><span class="font-semibold text-gray-300">Lanzamiento:</span> {{ $producto->fecha_lanzamiento->format('d/m/Y') }}</p>
                        </div>
                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-700/50">
                            <span class="text-xl sm:text-2xl font-bold text-purple-400">${{ number_format($producto->precio, 2) }}</span>
                            @auth
                                <form class="add-to-cart-form" data-product-id="{{ $producto->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 sm:px-5 py-2 bg-purple-600 text-white font-bold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50 text-sm">
                                        Añadir 🛒
                                    </button>
                                </form>
                            @endauth
                            @guest
                                <button onclick="saveAndLogin({{ $producto->id }})" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50 text-sm">
                                    Comprar 🛒
                                </button>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
function saveAndLogin(productId) {
    fetch('{{ route('pedidos.guardar.pendiente') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ id: productId, url: window.location.href }),
    }).then(() => { window.location.href = '{{ route('login') }}'; });
}

document.addEventListener('DOMContentLoaded', () => {
    // Búsqueda en tiempo real (autocompletado)
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('search-results-container');
    let searchTimer = null;

    if (searchInput && resultsContainer) {
        searchInput.addEventListener('keyup', () => {
            const q = searchInput.value.trim();
            clearTimeout(searchTimer);

            if (q.length === 0) {
                resultsContainer.classList.add('hidden');
                resultsContainer.innerHTML = '';
                return;
            }

            searchTimer = setTimeout(() => {
                resultsContainer.classList.remove('hidden');
                resultsContainer.innerHTML = '<div class="p-4 text-center text-purple-400 font-medium">Buscando...</div>';

                fetch('{{ route("productos.buscarjuegos") }}?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(data => {
                        if (data.html?.trim()) {
                            resultsContainer.innerHTML = data.html;
                        } else {
                            resultsContainer.innerHTML = '<div class="p-4 text-center text-gray-400 italic">No se encontraron juegos</div>';
                        }
                    })
                    .catch(() => {
                        resultsContainer.innerHTML = '<div class="p-4 text-center text-red-400">Error en la búsqueda</div>';
                    });
            }, 300);
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#search-input') && !e.target.closest('#search-results-container')) {
                resultsContainer.classList.add('hidden');
            }
        });
    }

    // Filtros
    let filtroTimer = null;

    function aplicarFiltros() {
        const params = new URLSearchParams(window.location.search);
        const orden = document.getElementById('filtro-orden')?.value;
        const precioMin = document.getElementById('filtro-precio-min')?.value;
        const precioMax = document.getElementById('filtro-precio-max')?.value;

        if (orden) params.set('orden', orden); else params.delete('orden');
        if (precioMin) params.set('precio_min', precioMin); else params.delete('precio_min');
        if (precioMax) params.set('precio_max', precioMax); else params.delete('precio_max');

        window.location.href = window.location.pathname + '?' + params.toString();
    }

    document.getElementById('filtro-orden')?.addEventListener('change', aplicarFiltros);

    ['filtro-precio-min', 'filtro-precio-max'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', () => {
            clearTimeout(filtroTimer);
            filtroTimer = setTimeout(aplicarFiltros, 600);
        });
    });

    @if(session('auto_add_cart'))
        const pendingId = "{{ session('auto_add_cart') }}";
        const pendingForm = document.querySelector(`.add-to-cart-form[data-product-id="${pendingId}"]`);
        if (pendingForm) pendingForm.requestSubmit();
    @endif
});
</script>
@endpush
