@extends('layouts.admin')

@section('title', 'Lista de Usuarios')

@section('content')
        <section class="text-center mb-8">
            <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-8">🙋‍♂️ Lista de Usuarios</h2>
        </section>

        <section id="catalogo-juegos" class="py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @foreach ($usuarios as $usuario)
                    <div class="bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300 transform hover:scale-105">
                        <h3 class="text-xl font-bold mb-2 text-blue-400">{{ $usuario->correo }}</h3>
                        <h3 class="text-gray-300">{{ $usuario->nombre }}</h3>
                        <h3 class="text-gray-300">{{ $usuario->direccion }}</h3>
                        <h3 class="text-gray-300">{{ $usuario->telefono }}</h3>
                        <p class="text-gray-300 mb-1"><strong>Rol ID:</strong> {{ $usuario->rol_id }}</p>
                        <p class="text-gray-300"><strong>Registrado el:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                        
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('admin.usuarios.edit', ['id' => $usuario->id]) }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-blue-500 transition duration-300">
                                Editar Usuario
                            </a>
                            
                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-red-600 transition duration-500" onclick="return confirm('¿Estás seguro que deseas eliminar este usuario?');">
                                    Eliminar Usuario
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection