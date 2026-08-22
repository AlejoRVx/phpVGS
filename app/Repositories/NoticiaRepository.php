<?php

namespace App\Repositories;

use App\Models\Noticias;
use App\Models\Productos;
use Illuminate\Support\Collection;

class NoticiaRepository
{
    public function all(): Collection
    {
        return Noticias::query()
            ->orderByDesc('created_at')
            ->get();
    }

    public function findOrFail(int $id): Noticias
    {
        return Noticias::findOrFail($id);
    }

    public function topVentas(int $limite = 6): Collection
    {
        return Productos::query()
            ->select('productos.id', 'productos.nombre', 'productos.imagen', 'productos.precio', 'productos.tipo')
            ->selectRaw('SUM(pedido_productos.cantidad) as total_vendidos')
            ->join('pedido_productos', 'productos.id', '=', 'pedido_productos.producto_id')
            ->groupBy('productos.id', 'productos.nombre', 'productos.imagen', 'productos.precio', 'productos.tipo')
            ->orderByDesc('total_vendidos')
            ->limit($limite)
            ->get();
    }
}
