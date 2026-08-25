<?php

namespace App\Services\Pedidos;

use App\Domain\Cart\CartManager;
use App\Models\Pagos;
use App\Models\Pedido_Productos;
use App\Models\Pedidos;
use App\Services\Admin\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(
        private CartManager $cart,
        private DashboardService $dashboard
    ) {}

    /**
     * Registra el pedido, sus líneas y el pago de forma atómica,
     * vacía el carrito y devuelve los datos para la factura.
     *
     * @return array{pedido_id: int, fecha: mixed, metodo: string, total: float, items: array, usuario: array}
     */
    public function pagar(string $metodo): array
    {
        $items = $this->cart->items();
        $total = $this->cart->total();
        $usuario = Auth::user();

        $resultado = DB::transaction(function () use ($items, $total, $metodo) {
            $pedido = Pedidos::create([
                'total' => $total,
                'estado' => true,
                'usuario_id' => Auth::id(),
                'nombre_cliente' => Auth::user()->nombre,
            ]);

            Pedido_Productos::insert(array_map(fn (array $item) => [
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'pedido_id' => $pedido->id,
                'producto_id' => $item['id'],
                'created_at' => now(),
                'updated_at' => now(),
            ], $items));

            $pago = Pagos::create([
                'fecha_pago' => now(),
                'metodo' => $metodo,
                'total' => $total,
                'pedido_id' => $pedido->id,
            ]);

            return [$pedido, $pago];
        });

        /** @var Pedidos $pedido */
        [$pedido, $pago] = $resultado;

        $this->cart->clear();
        $this->dashboard->clearCache();

        return [
            'pedido_id' => $pedido->id,
            'fecha' => $pago->fecha_pago,
            'metodo' => $pago->metodo,
            'total' => $total,
            'items' => $items,
            'usuario' => [
                'nombre' => $usuario->nombre,
                'direccion' => $usuario->direccion,
                'telefono' => $usuario->telefono,
            ],
        ];
    }
}
