<?php

namespace App\Repositories;

use App\Models\Pagos;
use App\Models\Pedidos;
use Illuminate\Support\Collection;

class PedidoRepository
{
    /**
     * Historial de pedidos del usuario con productos y pago cargados (evita N+1).
     *
     * @return Collection<int, Pedidos>
     */
    public function historialDeUsuario(int $usuarioId): Collection
    {
        return Pedidos::query()
            ->with(['productos.producto', 'pago'])
            ->where('usuario_id', $usuarioId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function findOrFailDelUsuario(int $pedidoId, int $usuarioId): Pedidos
    {
        return Pedidos::query()
            ->with(['productos.producto', 'pago'])
            ->where('usuario_id', $usuarioId)
            ->findOrFail($pedidoId);
    }

    public function contarTodos(): int
    {
        return Pedidos::count();
    }

    public function totalVentas(): float
    {
        return (float) Pagos::sum('total');
    }

    /**
     * Últimos pedidos con nombre del cliente y su pago (una sola consulta).
     *
     * @return Collection<int, Pedidos>
     */
    public function ultimos(int $limite = 5): Collection
    {
        return Pedidos::query()
            ->with(['pago'])
            ->orderByDesc('created_at')
            ->limit($limite)
            ->get();
    }
}
