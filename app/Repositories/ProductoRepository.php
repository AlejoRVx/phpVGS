<?php

namespace App\Repositories;

use App\Models\Productos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductoRepository
{
    public const PER_PAGE = 12;

    /**
     * Catálogo paginado por tipo con filtros y ordenamiento.
     *
     * @param  array{orden?: ?string, precio_min?: ?float, precio_max?: ?float, q?: ?string}  $filtros
     */
    public function catalogoPorTipo(string $tipo, array $filtros = []): LengthAwarePaginator
    {
        return Productos::query()
            ->where('tipo', $tipo)
            ->when($filtros['q'] ?? null, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $like = "%{$q}%";

                    $sub->where('nombre', 'like', $like)
                        ->orWhere('genero', 'like', $like)
                        ->orWhere('compania', 'like', $like);
                });
            })
            ->when(isset($filtros['precio_min']) && $filtros['precio_min'] !== null && $filtros['precio_min'] !== '',
                fn ($query) => $query->where('precio', '>=', (float) $filtros['precio_min']))
            ->when(isset($filtros['precio_max']) && $filtros['precio_max'] !== null && $filtros['precio_max'] !== '',
                fn ($query) => $query->where('precio', '<=', (float) $filtros['precio_max']))
            ->when(
                ($filtros['orden'] ?? null) === 'calificacion',
                fn ($query) => $query->withAvg('resenas', 'calificacion')
                    ->orderByDesc('resenas_avg_calificacion')
            )
            ->orderBy($this->columnaOrden($filtros['orden'] ?? null), $this->direccionOrden($filtros['orden'] ?? null))
            ->paginate(self::PER_PAGE)
            ->withQueryString();
    }

    /**
     * Búsqueda ligera para autocompletado.
     */
    public function buscarPorTipo(string $tipo, string $q, int $limite = 10): Collection
    {
        $like = "%{$q}%";

        return Productos::query()
            ->where('tipo', $tipo)
            ->where(function ($sub) use ($like) {
                $sub->where('nombre', 'like', $like)
                    ->orWhere('genero', 'like', $like)
                    ->orWhere('compania', 'like', $like);
            })
            ->limit($limite)
            ->get(['id', 'nombre', 'imagen', 'tipo', 'precio']);
    }

    public function findOrFail(int $id): Productos
    {
        return Productos::findOrFail($id);
    }

    /**
     * Listado del panel admin con filtros opcionales.
     */
    public function administracion(?string $tipo = null, ?string $q = null): LengthAwarePaginator
    {
        return Productos::query()
            ->when($tipo, fn ($query) => $query->where('tipo', $tipo))
            ->when($q, function ($query) use ($q) {
                $like = "%{$q}%";

                $query->where(function ($sub) use ($like) {
                    $sub->where('nombre', 'like', $like)
                        ->orWhere('compania', 'like', $like);
                });
            })
            ->orderBy('nombre')
            ->paginate(self::PER_PAGE)
            ->withQueryString();
    }

    private function columnaOrden(?string $orden): string
    {
        return match ($orden) {
            'nombre_asc', 'nombre_desc' => 'nombre',
            'precio_asc', 'precio_desc' => 'precio',
            'fecha_lanzamiento_asc', 'fecha_lanzamiento_desc' => 'fecha_lanzamiento',
            default => 'id',
        };
    }

    private function direccionOrden(?string $orden): string
    {
        return in_array($orden, ['nombre_desc', 'precio_desc', 'fecha_lanzamiento_desc'], true)
            ? 'desc'
            : 'asc';
    }
}
