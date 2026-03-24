<div class="flex flex-wrap items-center justify-end gap-3 mb-8">

    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-400 whitespace-nowrap">Ordenar por:</label>
        <select id="filtro-orden"
                class="bg-gray-800 border border-gray-700 text-white text-sm rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 transition cursor-pointer">
            <option value="nombre_asc"   {{ request('orden') == 'nombre_asc'   ? 'selected' : '' }}>Nombre A-Z</option>
            <option value="nombre_desc"  {{ request('orden') == 'nombre_desc'  ? 'selected' : '' }}>Nombre Z-A</option>
            <option value="calificacion" {{ request('orden') == 'calificacion' ? 'selected' : '' }}>Mejor calificación</option>
            <option value="precio_asc"   {{ request('orden') == 'precio_asc'   ? 'selected' : '' }}>Precio: menor a mayor</option>
            <option value="precio_desc"  {{ request('orden') == 'precio_desc'  ? 'selected' : '' }}>Precio: mayor a menor</option>
            <option value="fecha_lanzamiento_asc"  {{ request('orden') == 'fecha_lanzamiento_asc'  ? 'selected' : '' }}>Fecha de lanzamiento: más antigua</option>
            <option value="fecha_lanzamiento_desc"  {{ request('orden') == 'fecha_lanzamiento_desc'  ? 'selected' : '' }}>Fecha de lanzamiento: más reciente</option>
        </select>
    </div>

    @if(request()->hasAny(['orden']))
        <a href="{{ url()->current() }}"
           class="flex items-center gap-1 px-3 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 text-red-400 hover:text-red-300 text-sm font-semibold rounded-xl transition">
            ✕ Limpiar
        </a>
    @endif

</div>