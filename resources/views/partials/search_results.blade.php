<div class="bg-gray-800 border border-blue-400 rounded-lg shadow-2xl overflow-hidden">
    @if($productos->isEmpty())
        <div class="p-4 text-center text-gray-400">
            No se encontraron productos.
        </div>
    @else
        <ul class="divide-y divide-gray-700">
            @foreach($productos as $producto)
                <li class="p-3 transition duration-200 hover:bg-gray-700">
                    <a href="{{ route('productos.resenas', ['id' => $producto->id]) }}" class="flex items-center justify-between gap-3">
                        <div class="flex items-center min-w-0">
                            <img class="h-10 w-10 object-cover rounded mr-3 flex-shrink-0" loading="lazy"
                                 src="{{ asset('img/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                            <div class="min-w-0">
                                <h4 class="text-blue-300 font-semibold text-sm truncate">{{ $producto->nombre }}</h4>
                                <p class="text-xs text-gray-400 truncate">{{ $producto->tipo }} · {{ $producto->compania }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-purple-400 whitespace-nowrap">${{ number_format($producto->precio, 0, ',', '.') }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="px-3 py-2 text-right text-xs text-gray-500 border-t border-gray-700">
            {{ $productos->count() }} resultado{{ $productos->count() !== 1 ? 's' : '' }}
        </div>
    @endif
</div>
