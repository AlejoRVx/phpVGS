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
     * Datos para la página de detalle/reseñas de un producto.
     *
     * @return array{producto: Productos, resenas: Collection, promedioCalificacion: float, cantidadResenas: int}
     */
    public function datosDeProducto(int $productoId): array
    {
        $producto = Productos::findOrFail($productoId);
        $resenas = $this->resenas->porProducto($productoId);

        return [
            'producto' => $producto,
            'resenas' => $resenas,
            'promedioCalificacion' => (float) $resenas->avg('calificacion'),
            'cantidadResenas' => $resenas->count(),
        ];
    }

    public function crear(Productos $producto, int $usuarioId, int $calificacion, string $comentario): Resenas
    {
        return $this->resenas->crear($producto, $usuarioId, $calificacion, $comentario);
    }
}
