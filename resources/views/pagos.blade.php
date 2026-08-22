@extends('layouts.app')

@section('title', 'Pagos')

@section('content')
<section class="text-center mb-8 sm:mb-12">
    <h2 class="text-3xl sm:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-4">Finalizar Compra</h2>
</section>

<div class="bg-gray-900 rounded-xl p-4 sm:p-6 mb-6">
    <h3 class="text-xl sm:text-2xl font-bold mb-4">Resumen del Pedido</h3>
    @foreach($pedidos as $item)
        <div class="flex justify-between items-center border-b border-gray-700 py-3 gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset('img/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-12 h-12 sm:w-16 sm:h-16 rounded object-cover flex-shrink-0" loading="lazy">
                <div class="min-w-0">
                    <p class="font-bold text-sm sm:text-base truncate">{{ $item['nombre'] }}</p>
                    <p class="text-gray-400 text-xs sm:text-sm">Cantidad: {{ $item['cantidad'] }}</p>
                </div>
            </div>
            <p class="font-bold text-sm sm:text-base whitespace-nowrap">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</p>
        </div>
    @endforeach
    <div class="mt-6 pt-4 border-t border-gray-700">
        <div class="flex justify-between text-lg sm:text-xl font-bold">
            <span>Total a Pagar:</span>
            <span class="text-green-400">${{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<div class="bg-gray-900 rounded-xl p-4 sm:p-6">
    <h3 class="text-xl sm:text-2xl font-bold mb-4">Método de Pago</h3>
    <form action="{{ route('pagar') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-300 mb-2">Selecciona tu método de pago:</label>
            <select name="metodo" class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                <option value="Tarjeta de débito">Tarjeta de débito</option>
                <option value="PayPal">PayPal</option>
                <option value="PSE">PSE</option>
            </select>
        </div>
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-blue-400 hover:text-blue-300 hover:bg-gray-700 rounded-lg border-2 border-blue-400 transition duration-300">
                <span class="mr-2 text-xl">←</span>
                <span class="font-semibold">Volver atrás</span>
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-purple-600 text-white font-semibold rounded-lg transition duration-300 hover:bg-purple-500 shadow-lg shadow-purple-600/50">
                💳 Realizar pago
            </button>
        </div>
    </form>
</div>
@endsection
