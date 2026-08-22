@extends('layouts.app')

@section('title', 'Factura de Compra')

@section('content')

<div id="factura-contenido" class="max-w-3xl mx-auto">

    <div class="bg-gray-900 border border-gray-700 rounded-2xl overflow-hidden shadow-2xl">

        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 px-8 py-8 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-60 h-60 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
            </div>
            <div class="relative">
                <div class="flex items-center justify-center gap-3 mb-3">
                    <img src="{{ asset('logo.ico') }}" class="h-12 w-12 drop-shadow-lg">
                    <h1 class="text-4xl font-black text-white tracking-tight drop-shadow-lg">VGSTORM</h1>
                </div>
                <p class="text-blue-100 text-sm font-medium tracking-widest uppercase">Comprobante de compra</p>
            </div>
        </div>

        <div class="bg-green-500/10 border-b border-green-500/20 px-8 py-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-green-400 font-bold">¡Pago realizado exitosamente!</p>
                <p class="text-gray-400 text-xs">Gracias por tu compra</p>
            </div>
        </div>

        <div class="px-8 py-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-3">
                    <p class="text-xs text-purple-400 uppercase font-bold tracking-widest">Datos del pedido</p>
                    <div class="bg-gray-800/50 rounded-xl p-4 space-y-2.5">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">N° Pedido</span>
                            <span class="text-white font-mono font-bold">#{{ str_pad($data['pedido_id'], 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Fecha</span>
                            <span class="text-white">{{ \Carbon\Carbon::parse($data['fecha'])->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Método de pago</span>
                            <span class="text-white">{{ $data['metodo'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-xs text-blue-400 uppercase font-bold tracking-widest">Datos del cliente</p>
                    <div class="bg-gray-800/50 rounded-xl p-4 space-y-2.5">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Nombre</span>
                            <span class="text-white">{{ $data['usuario']['nombre'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Teléfono</span>
                            <span class="text-white">{{ $data['usuario']['telefono'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Dirección</span>
                            <span class="text-white text-right max-w-[180px]">{{ $data['usuario']['direccion'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-3">Productos comprados</p>
                <div class="border border-gray-700 rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-800/80 border-b border-gray-700">
                                <th class="text-left px-4 py-3 text-xs text-gray-400 uppercase font-bold tracking-wider">Producto</th>
                                <th class="text-center px-4 py-3 text-xs text-gray-400 uppercase font-bold tracking-wider">Tipo</th>
                                <th class="text-center px-4 py-3 text-xs text-gray-400 uppercase font-bold tracking-wider">Cant.</th>
                                <th class="text-right px-4 py-3 text-xs text-gray-400 uppercase font-bold tracking-wider">Precio</th>
                                <th class="text-right px-4 py-3 text-xs text-gray-400 uppercase font-bold tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['items'] as $item)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-800/30 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('img/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}"
                                             class="w-10 h-10 rounded-lg object-cover border border-gray-700 flex-shrink-0">
                                        <span class="text-white font-medium truncate">{{ $item['nombre'] }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-xs px-2 py-1 rounded-full {{ $item['tipo'] === 'Juego' ? 'bg-blue-500/10 text-blue-400' : 'bg-purple-500/10 text-purple-400' }}">
                                        {{ $item['tipo'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-300">{{ $item['cantidad'] }}</td>
                                <td class="px-4 py-3 text-right text-gray-300">${{ number_format($item['precio'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-bold text-white">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-gray-800/30 rounded-xl p-5 border border-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Total pagado</p>
                        <p class="text-xs text-gray-500 mt-0.5">Incluye todos los productos</p>
                    </div>
                    <span class="text-3xl font-black text-green-400">
                        ${{ number_format($data['total'], 0, ',', '.') }}
                    </span>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-700 px-8 py-5 text-center">
            <p class="text-gray-500 text-xs">VGStorm — Tu tienda de videojuegos en línea</p>
            <p class="text-gray-600 text-xs mt-1">Este comprobante fue generado automáticamente.</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
        <button onclick="imprimirFactura()"
            class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-purple-600/30 transition-all hover:scale-105 active:scale-95">
            🖨️ Imprimir Factura
        </button>
        <a href="{{ route('main') }}"
            class="flex items-center justify-center gap-2 px-8 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-semibold rounded-xl border border-gray-700 transition-all">
            🏠 Volver al inicio
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function imprimirFactura() {
        window.print();
    }
</script>

<style>
    @media print {
        header, footer, #toast-container,
        .flex.flex-col.sm\:flex-row { display: none !important; }

        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

        body { background: white !important; color: #111 !important; }

        #factura-contenido .bg-gray-900 {
            background: white !important;
            border: none !important;
            box-shadow: none !important;
        }

        #factura-contenido .bg-gradient-to-r.from-blue-600 {
            background: #1e40af !important;
            -webkit-print-color-adjust: exact !important;
        }

        #factura-contenido .bg-gradient-to-r.from-blue-600 * { color: white !important; }

        #factura-contenido .bg-green-500\/10 {
            background: #f0fdf4 !important;
            border-bottom: 1.5px solid #86efac !important;
        }

        #factura-contenido .bg-gray-800\/50,
        #factura-contenido .bg-gray-800\/30,
        #factura-contenido .bg-gray-800\/80 {
            background: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
        }

        #factura-contenido table { border: 1px solid #e5e7eb !important; }
        #factura-contenido th { background: #f3f4f6 !important; border-bottom: 1px solid #e5e7eb !important; }
        #factura-contenido td { border-bottom: 1px solid #f3f4f6 !important; }

        .text-gray-400, .text-gray-300, .text-gray-500, .text-gray-600 { color: #4b5563 !important; }
        .text-white { color: #111827 !important; }
        .text-green-400 { color: #15803d !important; }
        .text-purple-400 { color: #7e22ce !important; }
        .text-blue-400 { color: #1d4ed8 !important; }

        .border-gray-700 { border-color: #d1d5db !important; }
        .border-gray-700\/50 { border-color: #e5e7eb !important; }

        #factura-contenido img { border: 1px solid #e5e7eb !important; }

        main { padding: 0 !important; }
        #factura-contenido { max-width: 100% !important; }
        #factura-contenido > div:first-child { border-radius: 0 !important; }
    }
</style>
@endpush
