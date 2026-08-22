<?php

namespace App\Services\Catalogo;

use App\Models\Productos;
use App\Repositories\ProductoRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CatalogoService
{
    public function __construct(private ProductoRepository $productos) {}

    public function juegos(array $filtros = []): LengthAwarePaginator
    {
        return $this->productos->catalogoPorTipo('Juego', $filtros);
    }

    public function consolas(array $filtros = []): LengthAwarePaginator
    {
        return $this->productos->catalogoPorTipo('Consola', $filtros);
    }

    /**
     * Búsqueda para autocompletado; devuelve productos y el HTML del partial.
     */
    public function buscar(string $tipo, string $q): Collection
    {
        return $this->productos->buscarPorTipo($tipo, $q);
    }

    public function findOrFail(int $id): Productos
    {
        return $this->productos->findOrFail($id);
    }
}
