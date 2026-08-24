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
            <div class="bg-gray-900 rounded-xl p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4" id="producto-{{ $id }}" data-precio="{{ $item['precio'] }}">
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
                        <input type="number" id="cant-{{ $id }}" value="{{ $item['cantidad'] }}" min="1" max="99"
                               class="w-10 text-center font-bold text-sm bg-transparent text-white border-x border-gray-700 focus:outline-none focus:bg-gray-700 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none [-moz-appearance:textfield]"
                               onchange="cambiarCantidadDirecta('{{ $id }}', this.value)">
                        <button type="button" onclick="cambiarCantidad('{{ $id }}', 1)"
                                class="w-9 h-9 flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white rounded-r-lg transition text-lg font-bold">+</button>
                    </div>

                    <p class="font-bold text-sm sm:w-28 text-right" id="subtotal-{{ $id }}">
                        ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                    </p>

                    <form action="{{ route('pedidos.eliminar', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmarEliminar(this.closest('form'), '¿Eliminar {{ addslashes($item["nombre"]) }} del carrito?')"
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
            <button type="button" onclick="confirmarEliminar(this.closest('form'), '¿Estás seguro de vaciar todo el carrito?')"
                    class="bg-gray-500 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition duration-300">
                Vaciar carrito
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
const modal = document.createElement('div');
modal.id = 'confirm-modal';
modal.className = 'fixed inset-0 z-[200] items-center justify-center bg-black/60 backdrop-blur-sm';
modal.style.display = 'none';
modal.innerHTML = `
    <div class="bg-gray-900 border border-purple-500/40 rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 text-center">
        <div class="bg-red-500/10 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <p id="confirm-message" class="text-white font-semibold mb-6"></p>
        <div class="flex gap-3">
            <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition">Cancelar</button>
            <button id="confirm-btn" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition">Eliminar</button>
        </div>
    </div>`;
document.body.appendChild(modal);

const confirmBtn = modal.querySelector('#confirm-btn');
let pendingForm = null;

function confirmarEliminar(form, message) {
    pendingForm = form;
    document.getElementById('confirm-message').textContent = message;
    modal.style.display = 'flex';
}

function closeConfirmModal() {
    modal.style.display = 'none';
    pendingForm = null;
}

confirmBtn.addEventListener('click', () => {
    if (pendingForm) pendingForm.submit();
    closeConfirmModal();
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) closeConfirmModal();
});

const cartTimers = {};

function cambiarCantidad(id, cambio) {
    const input = document.getElementById(`cant-${id}`);
    let nuevaCantidad = Math.min(99, Math.max(1, parseInt(input.value) + cambio));
    input.value = nuevaCantidad;
    actualizarSubtotal(id, nuevaCantidad);
}

function cambiarCantidadDirecta(id, valor) {
    let nuevaCantidad = parseInt(valor);
    if (isNaN(nuevaCantidad) || nuevaCantidad < 1) { nuevaCantidad = 1; }
    if (nuevaCantidad > 99) { nuevaCantidad = 99; }
    document.getElementById(`cant-${id}`).value = nuevaCantidad;
    actualizarSubtotal(id, nuevaCantidad);
}

function actualizarSubtotal(id, nuevaCantidad) {
    const spanSubtotal = document.getElementById(`subtotal-${id}`);
    const spanTotal = document.getElementById('total-carrito');
    const precioUnit = parseFloat(document.getElementById(`producto-${id}`).dataset.precio);

    spanSubtotal.innerText = `$${(precioUnit * nuevaCantidad).toLocaleString('es-CL')}`;

    let totalActual = 0;
    document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
        totalActual += parseFloat(el.innerText.replace(/[$.]/g, '').replace(',', '.'));
    });
    spanTotal.innerText = `Total: $${totalActual.toLocaleString('es-CL')}`;

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
            window.updateMiniCartBadge?.();
        } catch (_) {}
    }, 400);
}
</script>
@endpush
