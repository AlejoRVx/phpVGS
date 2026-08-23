<?php

namespace App\Services\Resenas;

use App\Models\Productos;
use App\Models\Resenas;
use App\Repositories\ResenaRepository;
use Illuminate\Support\Collection;

class ResenaService
{
    public function __construct(private ResenaRepository $resenas) {}

    /**
     * @return array{producto: Productos, resenas: Collection, promedioCalificacion: float, cantidadResenas: int, miResena: ?Resenas}
     */
    public function datosDeProducto(int $productoId, ?int $usuarioId = null): array
    {
        $producto = Productos::findOrFail($productoId);
        $resenas = $this->resenas->porProducto($productoId);

        $miResena = null;
        if ($usuarioId) {
            $miResena = $this->resenas->buscarPorUsuarioYProducto($usuarioId, $productoId);
        }

        return [
            'producto' => $producto,
            'resenas' => $resenas,
            'promedioCalificacion' => (float) $resenas->avg('calificacion'),
            'cantidadResenas' => $resenas->count(),
            'miResena' => $miResena,
        ];
    }

    public function crear(Productos $producto, int $usuarioId, int $calificacion, string $comentario): Resenas
    {
        return $this->resenas->crear($producto, $usuarioId, $calificacion, $comentario);
    }

    public function obtenerResena(int $resenaId, int $usuarioId): Resenas
    {
        $resena = Resenas::findOrFail($resenaId);

        if ($resena->usuario_id !== $usuarioId) {
            abort(403);
        }

        return $resena;
    }

    public function actualizar(Resenas $resena, int $calificacion, string $comentario): void
    {
        $this->resenas->actualizar($resena, $calificacion, $comentario);
    }

    public function eliminar(Resenas $resena): void
    {
        $this->resenas->eliminar($resena);
    }
}
