<?php

namespace App\Http\Controllers;

use App\Domain\Cart\CartManager;
use App\Repositories\PedidoRepository;
use App\Services\Pedidos\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PagosController extends Controller
{
    public function __construct(
        private CartManager $cart,
        private CheckoutService $checkout,
        private PedidoRepository $pedidos
    ) {}

    public function index(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('pedidos.index')->with('error', 'Tu pedido está vacío');
        }

        $items = $this->cart->items();

        return view('pagos', [
            'pedidos' => $items,
            'total' => $this->cart->total(),
        ]);
    }

    public function pagar(Request $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('pedidos.index')->with('error', 'Tu pedido está vacío');
        }

        $request->validate([
            'metodo' => 'required|string|in:Tarjeta de crédito,Tarjeta de débito,PayPal,PSE',
        ]);

        $data = $this->checkout->pagar($request->input('metodo'));

        return redirect()
            ->route('factura', ['pedido' => $data['pedido_id']])
            ->with('factura_data', $data);
    }

    public function factura(): View|RedirectResponse
    {
        $data = session('factura_data');

        if (! $data) {
            return redirect()->route('main');
        }

        return view('factura', compact('data'));
    }

    public function historial(): View
    {
        $pedidos = $this->pedidos->historialDeUsuario(Auth::id());

        return view('historial', compact('pedidos'));
    }

    public function facturaHistorial(int $id): View
    {
        $pedido = $this->pedidos->findOrFailDelUsuario($id, Auth::id());
        $usuario = Auth::user();

        $items = $pedido->productos->map(fn ($pp) => [
            'nombre' => $pp->producto->nombre,
            'precio' => $pp->precio_unitario,
            'cantidad' => $pp->cantidad,
            'imagen' => $pp->producto->imagen,
            'tipo' => $pp->producto->tipo,
        ])->toArray();

        $data = [
            'pedido_id' => $pedido->id,
            'fecha' => $pedido->pago?->fecha_pago,
            'metodo' => $pedido->pago?->metodo ?? 'N/A',
            'total' => $pedido->total,
            'items' => $items,
            'usuario' => [
                'nombre' => $usuario->nombre,
                'direccion' => $usuario->direccion,
                'telefono' => $usuario->telefono,
            ],
        ];

        return view('factura', compact('data'));
    }
}
