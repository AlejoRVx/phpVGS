@extends('layouts.app')

@section('title', 'Carro de compras')

@section('content')
<section class="text-center mb-8 sm:mb-12">
    <h2 class="text-3xl sm:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">
        🛒 Mi Carrito
    </h2>
</section>

@if(empty($pedidos))
    <div class="bg-gray-900 rounded-xl p-8 text-center">
        <p class="text-xl mb-4">Tu carrito está vacío</p>
        <a href="{{ route('productos.juegos') }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50 inline-block">Ir a comprar 🛒</a>
    </div>
@else
    <div class="space-y-4">
        @foreach($pedidos as $id => $item)
            <div class="bg-gray-900 rounded-xl p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4" id="producto-{{ $id }}">
                <div class="flex items-center gap-4 min-w-0">
                    <img src="{{ asset('img/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded object-cover flex-shrink-0" loading="lazy">
                    <div class="min-w-0">
                        <h3 class="font-bold truncate">{{ $item['nombre'] }}</h3>
                        <p class="text-gray-400 text-sm">${{ number_format($item['precio'], 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-4">
                    <div class="flex items-center bg-gray-800 rounded-lg">
                        <button type="button" onclick="cambiarCantidad('{{ $id }}', -1)"
                                class="w-9 h-9 flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white rounded-l-lg transition text-lg font-bold">−</button>
                        <span id="cant-{{ $id }}" class="w-10 text-center font-bold text-sm">{{ $item['cantidad'] }}</span>
                        <button type="button" onclick="cambiarCantidad('{{ $id }}', 1)"
                                class="w-9 h-9 flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white rounded-r-lg transition text-lg font-bold">+</button>
                    </div>

                    <p class="font-bold text-sm sm:w-28 text-right" id="subtotal-{{ $id }}">
                        ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                    </p>

                    <form action="{{ route('pedidos.eliminar', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Estás segur@ de quieres retirar el producto de tu carrito');"
                                class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-red-600 text-sm">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-gray-900 rounded-xl p-4 sm:p-6 mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('pedidos.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('¿Estás segur@ de vaciar todo el carrito?');"
                    class="bg-gray-500 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition duration-300">
                Vaciar carrito 🛒
            </button>
        </form>
        <div class="text-center sm:text-right">
            <p class="text-xl sm:text-2xl font-bold" id="total-carrito">Total: ${{ number_format($total, 0, ',', '.') }}</p>
            <a href="{{ route('pagos.index') }}" class="mt-3 inline-block px-8 py-3 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-green-600 shadow-lg">Pagar</a>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
const cartTimers = {};

function cambiarCantidad(id, cambio) {
    const spanCantidad = document.getElementById(`cant-${id}`);
    const spanSubtotal = document.getElementById(`subtotal-${id}`);
    const spanTotal = document.getElementById('total-carrito');

    let nuevaCantidad = parseInt(spanCantidad.innerText) + cambio;
    if (nuevaCantidad < 1) return;

    // Actualizar DOM al instante (optimistic)
    const precio = parseFloat(spanSubtotal.innerText.replace(/[$.]/g, '').replace(',', '.'));
    const precioUnit = precio / (nuevaCantidad - cambio);
    spanCantidad.innerText = nuevaCantidad;
    spanSubtotal.innerText = `$${(precioUnit * nuevaCantidad).toLocaleString('es-CL')}`;

    // Recalcular total
    let totalActual = 0;
    document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
        totalActual += parseFloat(el.innerText.replace(/[$.]/g, '').replace(',', '.'));
    });
    spanTotal.innerText = `Total: $${totalActual.toLocaleString('es-CL')}`;

    // Debounce: esperar 400ms antes de enviar al server
    clearTimeout(cartTimers[id]);
    cartTimers[id] = setTimeout(async () => {
        try {
            await fetch(`/pedidos/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ cantidad: nuevaCantidad })
            });
        } catch (_) {}
    }, 400);
}
</script>
@endpush
