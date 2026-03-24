@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')

<section class="text-center mb-10">
    <h2 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-2">
        Mis Pedidos
    </h2>
    <p class="text-gray-400">Historial completo de tus compras</p>
</section>

@if($pedidos->isEmpty())
    <div class="text-center py-20 text-gray-500">
        <p class="text-6xl mb-4">🛒</p>
        <p class="text-xl font-semibold mb-2">Aún no tienes pedidos</p>
        <a href="{{ route('productos.juegos') }}"
           class="mt-4 inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:scale-105 transition-all">
            Explorar juegos
        </a>
    </div>
@else
    <div class="space-y-6">
        @foreach($pedidos as $pedido)
        <div class="bg-gray-900 border border-gray-700 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-gray-700 bg-gray-800/40">
                <div class="flex items-center gap-6">
                    <div>
                        <p class="text-xs text-purple-400 uppercase font-bold tracking-widest">Pedido</p>
                        <p class="text-white font-mono font-bold text-lg">
                            #{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Fecha</p>
                        <p class="text-gray-300 text-sm">
                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Total</p>
                        <p class="text-green-400 font-bold">
                            ${{ number_format($pedido->total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('historial.factura', $pedido->id) }}"
                   class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white text-sm font-bold rounded-xl shadow-lg transition-all hover:scale-105 active:scale-95 whitespace-nowrap">
                    🧾 Ver factura
                </a>
            </div>

            <div class="px-6 py-4 space-y-3">
                @foreach($pedido->productos as $pp)
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <p class="text-white font-semibold text-sm">{{ $pp->producto->nombre }}</p>
                        <p class="text-gray-400 text-xs">{{ $pp->producto->tipo }} · Cantidad: {{ $pp->cantidad }}</p>
                    </div>
                    <p class="text-white font-bold text-sm">
                        ${{ number_format($pp->precio_unitario * $pp->cantidad, 0, ',', '.') }}
                    </p>
                </div>
                @endforeach
            </div>

        </div>
        @endforeach
    </div>
@endif

@endsection