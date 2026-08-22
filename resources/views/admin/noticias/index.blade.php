@extends('layouts.admin')

@section('title', 'Noticias - Panel de Administración')

@section('content')

<section class="text-center mb-8">
    <h2 class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">
        Gestión de Noticias
    </h2>
</section>

<section class="py-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
            Listado de Noticias
        </h2>
        <a href="{{ route('admin.noticias.create') }}"
           class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 shadow-lg shadow-green-900/20 transition duration-300 text-center">
            + Agregar Noticia
        </a>
    </div>

    <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
        @if($noticias->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-gray-800/40 rounded-2xl border-2 border-dashed border-gray-600">
                <div class="bg-gray-900/50 p-6 rounded-full mb-6 shadow-inner">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2 text-center">No hay noticias</h3>
                <p class="text-gray-400 text-center max-w-md mb-8 px-6">
                    Aún no has cargado noticias al sistema. Usa el botón superior para empezar.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="px-6 py-4 text-sm font-bold text-blue-400 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-4 text-sm font-bold text-blue-400 uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 text-sm font-bold text-blue-400 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-sm font-bold text-blue-400 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($noticias as $noticia)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition duration-200">
                                <td class="px-6 py-4 text-white font-medium">{{ $noticia->titulo }}</td>
                                <td class="px-6 py-4 text-gray-400">{{ $noticia->categoria }}</td>
                                <td class="px-6 py-4 text-gray-400">{{ $noticia->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.noticias.edit', $noticia->id) }}"
                                           class="px-4 py-2 bg-blue-600 rounded text-sm hover:bg-blue-500 transition duration-300">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta noticia?')"
                                                    class="px-4 py-2 bg-red-600 rounded text-sm hover:bg-red-500 transition duration-300">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    @if(session('success'))
        showToast("{{ session('success') }}", "success");
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", "error");
    @endif
});
</script>

@endsection
