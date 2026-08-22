<?php

namespace App\Services\Admin;

use App\Models\Pagos;
use App\Models\Productos;
use App\Models\Usuarios;
use App\Repositories\PedidoRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(
        private UsuarioRepository $usuarios,
        private ProductoRepository $productos,
        private PedidoRepository $pedidos
    ) {}

    /**
     * Métricas y últimos pedidos para el panel de administración.
     *
     * @return array{totalUsuarios: int, totalProductos: int, totalPedidos: int, totalVentas: float, ultimosPedidos: mixed}
     */
    public function metricas(): array
    {
        $ttl = now()->addMinutes(5);

        return [
            'totalUsuarios' => Cache::remember('dashboard.usuarios', $ttl, fn () => Usuarios::where('rol_id', 1)->count()),
            'totalProductos' => Cache::remember('dashboard.productos', $ttl, fn () => Productos::count()),
            'totalPedidos' => Cache::remember('dashboard.pedidos', $ttl, fn () => $this->pedidos->contarTodos()),
            'totalVentas' => Cache::remember('dashboard.ventas', $ttl, fn () => (float) Pagos::sum('total')),
            'ultimosPedidos' => $this->pedidos->ultimos(5),
        ];
    }

    public function clearCache(): void
    {
        Cache::forget('dashboard.usuarios');
        Cache::forget('dashboard.productos');
        Cache::forget('dashboard.pedidos');
        Cache::forget('dashboard.ventas');
    }
}
