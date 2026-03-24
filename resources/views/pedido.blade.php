@extends('layouts.app')

@section('title', 'Carro de compras')

@section('content')

    <section class="text-center mb-12">
        <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">
            🛒 Mi Carrito
        </h2>
    </section>

    @if(empty($pedidos))
        <div class="bg-gray-900 rounded p-8 text-center">
            <p class="text-xl mb-4">Tu carrito está vacío</p>
            <a href="/productos/juegos" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">Ir a comprar 🛒</a>
        </div>
    @else
        @foreach($pedidos as $id => $item)
            <div class="bg-gray-900 rounded p-4 mb-4 flex justify-between items-center" id="producto-{{ $id }}">
                <div class="flex items-center">
                    <img src="{{ asset('img/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-20 h-20 rounded mr-4">
                    <div>
                        <h3 class="font-bold">{{ $item['nombre'] }}</h3>
                        <p class="text-gray-400">${{ number_format($item['precio'], 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center bg-gray-800 rounded">
                        <button type="button" 
                                onclick="cambiarCantidad('{{ $id }}', -1)" 
                                class="quantity-btn bg-gray-700 hover:bg-gray-600 text-white rounded-l">−</button>
                        
                        <span id="cant-{{ $id }}" class="w-12 text-center font-bold">{{ $item['cantidad'] }}</span>
                        
                        <button type="button" 
                                onclick="cambiarCantidad('{{ $id }}', 1)" 
                                class="quantity-btn bg-gray-700 hover:bg-gray-600 text-white rounded-r">+</button>
                    </div>

                    <p class="font-bold w-32 text-right" id="subtotal-{{ $id }}">
                        ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                    </p>

                    <form action="{{ route('pedidos.eliminar', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                        onclick="return confirm('¿Estás segur@ de quieres retirar el producto de tu carrito');" 
                        class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-500 hover:bg-red-600">
                        Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="bg-gray-900 rounded p-6 mt-6 flex justify-between items-center">
            <form action="{{ route('pedidos.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Estás segur@ de vaciar todo el carrito?');" class="bg-gray-500 hover:bg-red-700 text-white px-6 py-3 rounded transition duration-500">Vaciar carrito 🛒</button>
            </form>

            <div class="text-right">
                <p class="text-2xl font-bold" id="total-carrito">Total: ${{ number_format($total, 0, ',', '.') }}</p>
                <a href="{{ route('pagos.index') }}" class="mt-4 inline-block px-8 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-500 hover:bg-green-600">Pagar</a>
            </div>
        </div>
    @endif

@endsection

@push('scripts')

    <script>
        async function cambiarCantidad(id, cambio) {
            const spanCantidad = document.getElementById(`cant-${id}`);
            const spanSubtotal = document.getElementById(`subtotal-${id}`);
            const spanTotal = document.getElementById(`total-carrito`);
            
            let cantidadActual = parseInt(spanCantidad.innerText);
            let nuevaCantidad = cantidadActual + cambio;

            if (nuevaCantidad < 1) return;

            try {
                const response = await fetch(`/pedidos/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ cantidad: nuevaCantidad })
                });

                const data = await response.json();

                if (data.success) {
                    spanCantidad.innerText = data.nuevaCantidad;
                    spanSubtotal.innerText = `$${data.nuevoSubtotal}`;
                    spanTotal.innerText = `Total: $${data.nuevoTotal}`;

                    spanSubtotal.classList.add('updated');
                    setTimeout(() => spanSubtotal.classList.remove('updated'), 500);
                }
            } catch (error) {
                console.error("Error al conectar con el servidor:", error);
                alert("Ocurrió un error al actualizar el carrito.");
            }
        }
    </script>

@endpush