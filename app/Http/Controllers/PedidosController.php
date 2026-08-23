<?php

namespace App\Http\Controllers;

use App\Domain\Cart\CartManager;
use App\Models\Productos;
use App\Services\Catalogo\CatalogoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PedidosController extends Controller
{
    public function __construct(
        private CartManager $cart,
        private CatalogoService $catalogo
    ) {}

    public function index(): View
    {
        $pedidos = $this->cart->items();

        if ($pedidos === [] && Auth()->check()) {
            $this->cart->loadFromDatabase(Auth()->id());
            $pedidos = $this->cart->items();
        }

        return view('pedido', [
            'pedidos' => $pedidos,
            'total' => $this->cart->total(),
        ]);
    }

    public function agregar(Request $request, int $id): JsonResponse
    {
        if (! auth()->check()) {
            session(['pending_product_id' => $id, 'return_to' => url()->previous()]);

            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Inicia sesión para añadir al carrito',
                'redirect' => route('login'),
            ], 401);
        }

        $producto = Productos::findOrFail($id);
        $this->cart->add($producto);

        return response()->json([
            'success' => true,
            'message' => "¡Producto {$producto->nombre} añadido a tu carrito!",
            'total_items' => $this->cart->totalItems(),
        ]);
    }

    public function actualizar(Request $request, int $id): JsonResponse|View
    {
        $cantidad = max(0, (int) $request->input('cantidad', 1));

        $this->cart->setQuantity($id, $cantidad);

        if ($request->ajax() || $request->wantsJson()) {
            $items = $this->cart->items();
            $item = $items[$id] ?? null;

            return response()->json([
                'success' => true,
                'nuevaCantidad' => $item['cantidad'] ?? 0,
                'nuevoSubtotal' => number_format($item ? $item['precio'] * $item['cantidad'] : 0, 0, ',', '.'),
                'nuevoTotal' => number_format($this->cart->total(), 0, ',', '.'),
            ]);
        }

        return redirect()->route('pedidos.index');
    }

    public function eliminar(int $id): RedirectResponse
    {
        $this->cart->remove($id);

        return redirect()->route('pedidos.index')->with('success', '✓ Producto eliminado');
    }

    public function eliminarMiniCart(int $id): JsonResponse
    {
        $this->cart->remove($id);

        return response()->json([
            'success' => true,
            'items' => array_values($this->cart->items()),
            'total' => $this->cart->total(),
            'totalItems' => $this->cart->totalItems(),
        ]);
    }

    public function vaciar(): RedirectResponse
    {
        $this->cart->clear();

        return redirect()->route('pedidos.index')->with('success', '✓ Pedido vaciado');
    }

    /**
     * Guarda en sesión el producto pendiente antes de redirigir al login.
     */
    public function guardarPendiente(Request $request): JsonResponse
    {
        $request->validate(['id' => 'required|integer']);

        session([
            'pending_product_id' => (int) $request->input('id'),
            'return_to' => $request->input('url', route('main')),
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function miniCart(): JsonResponse
    {
        $items = $this->cart->items();

        if ($items === [] && Auth()->check()) {
            $this->cart->loadFromDatabase(Auth()->id());
            $items = $this->cart->items();
        }

        return response()->json([
            'items' => array_values($items),
            'total' => $this->cart->total(),
            'totalItems' => $this->cart->totalItems(),
        ]);
    }
}
