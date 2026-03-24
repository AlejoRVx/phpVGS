<div class="bg-gray-800 border border-blue-400 rounded-lg shadow-2xl overflow-hidden">
    @if($productos->isEmpty())
        <div class="p-4 text-center text-gray-400">
            No se encontraron juegos que coincidan con "{{ request('query') }}".
        </div>
    @else
        <ul class="divide-y divide-gray-700">
            @foreach($productos as $producto)
                <li class="p-4 transition duration-200 hover:bg-gray-700">
                    <a href="{{ route('productos.resenas', ['id' => $producto->id]) }}" class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-10 w-10 object-cover object-center rounded mr-4" 
                                 src="{{ asset('img/' . $producto->imagen) }}" 
                                 alt="{{ $producto->nombre }}">
                            <div>
                                <h4 class="text-blue-300 font-semibold">{{ $producto->nombre }}</h4>
                                <p class="text-sm text-gray-400">{{ $producto->genero }} | {{ $producto->compania }}</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-purple-400">${{ number_format($producto->precio, 2) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="p-2 text-right text-sm text-gray-500 border-t border-gray-700">
            Mostrando {{ $productos->count() }} resultados.
        </div>
    @endif
</div>