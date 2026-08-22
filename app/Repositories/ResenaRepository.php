<?php

namespace App\Repositories;

use App\Models\Productos;
use App\Models\Resenas;
use Illuminate\Support\Collection;

class ResenaRepository
{
    /**
     * Reseñas de un producto con su usuario cargado (evita N+1).
     *
     * @return Collection<int, Resenas>
     */
    public function porProducto(int $productoId): Collection
    {
        return Resenas::query()
            ->where('producto_id', $productoId)
            ->with('usuario:id,nombre')
            ->orderByDesc('fecha')
            ->get();
    }

    public function crear(Productos $producto, int $usuarioId, int $calificacion, string $comentario): Resenas
    {
        return $producto->resenas()->create([
            'usuario_id' => $usuarioId,
            'calificacion' => $calificacion,
            'comentario' => $comentario,
            'fecha' => now(),
        ]);
    }
}
