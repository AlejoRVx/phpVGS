@extends('layouts.app')

@section('title', 'Juegos')

@section('search-bar')
@endsection

@section('content')

    <section id="catalogo-juegos" class="py-6">
        <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8 text-center tracking-tight">
            🕹️ Catálogo de Juegos Digitales
        </h2>

        @include('partials._filtros')

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @if($productos->isEmpty())
                <div class="col-span-full flex flex-col items-center justify-center py-20 bg-gray-800/30 rounded-3xl border-2 border-dashed border-purple-900/50">
                    <div class="bg-gray-900 p-6 rounded-full mb-6 shadow-xl shadow-purple-500/10">
                       <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-2">¡Vaya! No encontramos ese juego</h3>
                    <p class="text-gray-400 text-center max-w-md mb-8 px-6 text-lg">
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
            @endif

            @foreach ($productos as $producto)
                <div class="bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden transition duration-300 transform hover:scale-[1.02] hover:shadow-blue-500/30 border border-gray-700 flex flex-col group">

                    <a href="{{ route('productos.resenas', ['id' => $producto->id]) }}" class="overflow-hidden block">
                        <img class="w-full h-48 object-cover object-center" src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    </a>
                            
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ route('productos.resenas', ['id' => $producto->id]) }}">
                            <h3 class="text-xl font-bold text-blue-400 mb-2 hover:text-blue-300 transition-colors tracking-tight leading-tight">
                                {{ $producto->nombre }}
                            </h3>
                        </a>
                                
                        <div class="text-sm text-gray-400 mb-4 space-y-1">
                            <p><span class="font-semibold text-gray-300">Género:</span> {{ $producto->genero }}</p>
                            <p><span class="font-semibold text-gray-300">Compañía:</span> {{ $producto->compania }}</p>
                            <p><span class="font-semibold text-gray-300">Lanzamiento:</span> {{ $producto->fecha_lanzamiento->format('d/m/Y') }}</p>
                        </div>

                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-700/50">
                            <span class="text-2xl font-bold text-purple-400">${{ number_format($producto->precio, 2) }}</span>
                                    
                            @auth
                                <form class="add-to-cart-form" data-product-id="{{ $producto->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-5 py-2 bg-purple-600 text-white font-bold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50 flex items-center gap-2">
                                        Añadir 🛒
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <button onclick="saveAndLogin({{ $producto->id }})" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">
                                    Comprar 🛒
                                </button>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function saveAndLogin(productId) {
            $.ajax({
                url: '{{ route('pedidos.guardar.pendiente') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: productId,
                    url: window.location.href
                },
                success: function() {
                    window.location.href = '{{ route('login') }}';
                }
            });
        }

        function showToast(message, type = 'success') {
            const container = $('#toast-container');
            let bgColor = type === 'success' ? 'bg-purple-600' : 'bg-red-600';
            let icon = type === 'success' ? '✅' : '❌';

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
                newToast.on('transitionend', function() { newToast.remove(); });
            }, 3000);
        }

        $(document).ready(function() {
            var timer = null;
            var resultsContainer = $('#search-results-container');

            $('#search-input').on('keyup', function() {
                var query = $(this).val();
                
                clearTimeout(timer); 

                if (query.length === 0) {
                    resultsContainer.addClass('hidden').empty();
                    return;
                }

                timer = setTimeout(function() {
                    $.ajax({
                        url: '{{ route('productos.buscarjuegos') }}',
                        method: 'GET',
                        data: { q: query },
                        beforeSend: function() {
                            resultsContainer.removeClass('hidden').html(
                                '<div class="p-4 text-center text-purple-400 font-medium">Buscando...</div>'
                            );
                        },
                        success: function(response) {
                            if (response.html && response.html.trim() !== "") {
                                resultsContainer.removeClass('hidden').html(response.html);
                            } else {
                                resultsContainer.removeClass('hidden').html(
                                    '<div class="p-4 text-center text-gray-400 italic">No se encontraron juegos</div>'
                                );
                            }
                        },
                        error: function() {
                            resultsContainer.removeClass('hidden').html(
                                '<div class="p-4 text-center text-red-400">Error en la búsqueda</div>'
                            );
                        }
                    });
                }, 300);
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.group').length) {
                    resultsContainer.addClass('hidden');
                }
            });

            $(document).on('submit', '.add-to-cart-form', function(e) {
                e.preventDefault();
                var form = $(this);
                var productId = form.data('product-id');
                var url = '{{ route('pedidos.agregar', ['id' => '__id__']) }}'.replace('__id__', productId);
                var token = form.find('input[name="_token"]').val(); 
                var button = form.find('button[type="submit"]');

                button.prop('disabled', true).text('...');
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { _token: token },
                    success: function(response) {
                        showToast(response.message, 'success'); 
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            showToast('Guardando producto... Redirigiendo al login', 'error');
                            saveAndLogin(productId);
                        } else {
                            showToast('Hubo un problema. Inténtalo de nuevo.', 'error');
                        }
                    },
                    complete: function() {
                        button.prop('disabled', false).html('Añadir 🛒');
                    }
                });
            });

            @if(session('auto_add_cart'))
                const pendingId = "{{ session('auto_add_cart') }}";
                const pendingForm = $(`.add-to-cart-form[data-product-id="${pendingId}"]`);
                    
                if(pendingForm.length > 0) {
                    pendingForm.submit();
                }
            @endif
        });

        (function() {
            var filtroTimer = null;

            function aplicarFiltros() {
                var params = new URLSearchParams(window.location.search);

                var orden = $('#filtro-orden').val();
                var precioMin = $('#filtro-precio-min').val();
                var precioMax = $('#filtro-precio-max').val();

                if (orden)     params.set('orden', orden);       else params.delete('orden');
                if (precioMin) params.set('precio_min', precioMin); else params.delete('precio_min');
                if (precioMax) params.set('precio_max', precioMax); else params.delete('precio_max');

                window.location.href = window.location.pathname + '?' + params.toString();
            }

            $('#filtro-orden').on('change', function() {
                aplicarFiltros();
            });

            $('#filtro-precio-min, #filtro-precio-max').on('input', function() {
                clearTimeout(filtroTimer);
                filtroTimer = setTimeout(aplicarFiltros, 600);
            });
        })();
    </script>
@endpush