<?php

namespace App\Repositories;

use App\Models\Productos;
use App\Models\Resenas;
use Illuminate\Support\Collection;

class ResenaRepository
{
    /**
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

    public function buscarPorUsuarioYProducto(int $usuarioId, int $productoId): ?Resenas
    {
        return Resenas::where('usuario_id', $usuarioId)
            ->where('producto_id', $productoId)
            ->first();
    }

    public function actualizar(Resenas $resena, int $calificacion, string $comentario): void
    {
        $resena->update([
            'calificacion' => $calificacion,
            'comentario' => $comentario,
        ]);
    }

    public function eliminar(Resenas $resena): void
    {
        $resena->delete();
    }
}
