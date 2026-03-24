@extends('layouts.app')

@section('title', 'Factura de Compra')

@section('content')

<div id="factura-contenido" class="max-w-3xl mx-auto">

    <div class="text-center mb-10">
        <div class="flex items-center justify-center gap-3 mb-2">
            <img src="{{ asset('logo.ico') }}" class="h-10 w-10">
            <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                VGSTORM
            </h1>
        </div>
        <p class="text-gray-400 text-sm">Comprobante de compra</p>
    </div>

    <div class="bg-gray-900 border border-gray-700 rounded-2xl overflow-hidden shadow-2xl">

        <div class="bg-gradient-to-r from-green-600/30 to-emerald-600/30 border-b border-green-500/30 px-8 py-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-green-400 font-bold text-lg">¡Pago realizado exitosamente!</p>
                <p class="text-gray-400 text-sm">Disfruta tu compra.</p>
            </div>
        </div>

        <div class="px-8 py-6 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-gray-800/50 rounded-xl p-4 space-y-2">
                    <p class="text-xs text-purple-400 uppercase font-bold tracking-widest mb-3">Datos del pedido</p>
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

                <div class="bg-gray-800/50 rounded-xl p-4 space-y-2">
                    <p class="text-xs text-blue-400 uppercase font-bold tracking-widest mb-3">Datos del cliente</p>
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

            <div>
                <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-3">Productos comprados</p>
                <div class="space-y-3">
                    @foreach($data['items'] as $item)
                    <div class="flex items-center justify-between bg-gray-800/50 rounded-xl px-4 py-3">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('img/' . $item['imagen']) }}"
                                 alt="{{ $item['nombre'] }}"
                                 class="w-12 h-12 rounded-lg object-cover border border-gray-700">
                            <div>
                                <p class="font-semibold text-white text-sm">{{ $item['nombre'] }}</p>
                                <p class="text-gray-400 text-xs">
                                    {{ $item['tipo'] }} · Cantidad: {{ $item['cantidad'] }}
                                </p>
                            </div>
                        </div>
                        <p class="font-bold text-white">
                            ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-700 pt-4 flex justify-between items-center">
                <span class="text-gray-400 text-lg">Total pagado</span>
                <span class="text-2xl font-black text-green-400">
                    ${{ number_format($data['total'], 0, ',', '.') }}
                </span>
            </div>

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
        .flex.flex-col { display: none !important; }

        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

        body {
            background: white !important;
            color: #111 !important;
        }

        #factura-contenido .bg-gray-900 {
            background: white !important;
            border: 1.5px solid #d1d5db !important;
            box-shadow: none !important;
        }

        #factura-contenido .bg-gray-800\/50 {
            background: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
        }

        #factura-contenido .bg-gradient-to-r {
            background: #f0fdf4 !important;
            border-bottom: 1.5px solid #86efac !important;
        }

        .text-gray-400, .text-gray-300 { color: #4b5563 !important; }
        .text-white { color: #111827 !important; }

        .text-green-400 { color: #15803d !important; }

        .text-purple-400 { color: #7e22ce !important; }
        .text-blue-400 { color: #1d4ed8 !important; }

        #factura-contenido .text-transparent {
            background: none !important;
            color: #111 !important;
            -webkit-text-fill-color: #111 !important;
        }

        .border-gray-700 { border-color: #d1d5db !important; }
        .border-t { border-top: 1.5px solid #d1d5db !important; }

        #factura-contenido img {
            border: 1px solid #e5e7eb !important;
        }

        main { padding: 0 !important; }
        #factura-contenido { max-width: 100% !important; }
    }
</style>
@endpush