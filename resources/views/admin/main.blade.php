@extends('layouts.admin')

@section('title', 'Dashboard - VGStorm Admin')

@section('content')

<div class="mb-10">
    <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
        Panel de Control
    </h1>
    <p class="text-gray-400 mt-1">Bienvenido de nuevo, Admin</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="bg-gray-900 border border-gray-700 hover:border-blue-500/50 rounded-2xl p-6 flex items-center gap-5 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500/20 transition">
            <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Usuarios</p>
            <p class="text-3xl font-black text-white mt-1">{{ $totalUsuarios }}</p>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-700 hover:border-purple-500/50 rounded-2xl p-6 flex items-center gap-5 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500/20 transition">
            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Productos</p>
            <p class="text-3xl font-black text-white mt-1">{{ $totalProductos }}</p>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-700 hover:border-green-500/50 rounded-2xl p-6 flex items-center gap-5 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500/20 transition">
            <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Pedidos</p>
            <p class="text-3xl font-black text-white mt-1">{{ $totalPedidos }}</p>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-700 hover:border-yellow-500/50 rounded-2xl p-6 flex items-center gap-5 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-yellow-500/20 transition">
            <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Ventas totales</p>
            <p class="text-2xl font-black text-white mt-1">${{ number_format($totalVentas, 0, ',', '.') }}</p>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <div class="bg-gray-900 border border-gray-700 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700 flex items-center justify-between">
            <p class="font-bold text-white">Últimos pedidos</p>
        </div>
        <div class="divide-y divide-gray-800">
            @forelse($ultimosPedidos as $pedido)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-800/40 transition">
                <div>
                    <p class="text-white font-semibold text-sm">
                        #{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}
                        <span class="text-gray-400 font-normal">· {{ $pedido->nombre_usuario }}</span>
                    </p>
                    <p class="text-gray-500 text-xs mt-0.5">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="text-green-400 font-bold text-sm">
                    ${{ number_format($pedido->total, 0, ',', '.') }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500 text-sm">
                Aún no hay pedidos registrados.
            </div>
            @endforelse
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-700 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700">
            <p class="font-bold text-white">Noticias recientes</p>
        </div>
        <div class="divide-y divide-gray-800">

            <div class="px-6 py-4 flex gap-4 items-start hover:bg-gray-800/40 transition group">
                <img src="{{ asset('img/noticia-steam.jpg') }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0 border border-gray-700">
                <div>
                    <p class="text-white text-sm font-semibold group-hover:text-blue-400 transition leading-snug">
                        Nueva generación de Steam Hardware para 2026
                    </p>
                    <p class="text-gray-500 text-xs mt-1">Nov 11, 2025</p>
                </div>
            </div>

            <div class="px-6 py-4 flex gap-4 items-start hover:bg-gray-800/40 transition group">
                <img src="{{ asset('img/noticia-gta.jpg') }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0 border border-gray-700">
                <div>
                    <p class="text-white text-sm font-semibold group-hover:text-blue-400 transition leading-snug">
                        Rockstar confirma estado final de GTA VI
                    </p>
                    <p class="text-gray-500 text-xs mt-1">Nov 7, 2025</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection