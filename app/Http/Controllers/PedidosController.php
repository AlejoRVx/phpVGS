<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\CarritoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    public static function cargarCarritoDesdeDB()
    {
        $items = CarritoItem::with('producto')
            ->where('usuario_id', Auth::id())
            ->get();

        $pedidos = [];
        foreach ($items as $item) {
            $p = $item->producto;
            $pedidos[$p->id] = [
                'id'       => $p->id,
                'nombre'   => $p->nombre,
                'precio'   => $p->precio,
                'cantidad' => $item->cantidad,
                'imagen'   => $p->imagen,
                'tipo'     => $p->tipo,
            ];
        }

        session(['pedidos' => $pedidos]);
        return $pedidos;
    }

    private function sincronizarSessionADB()
    {
        $pedidos = session()->get('pedidos', []);
        $usuarioId = Auth::id();

        CarritoItem::where('usuario_id', $usuarioId)->delete();

        foreach ($pedidos as $productoId => $item) {
            CarritoItem::create([
                'usuario_id'  => $usuarioId,
                'producto_id' => $productoId,
                'cantidad'    => $item['cantidad'],
            ]);
        }
    }

    public function agregar(Request $request, $id)
    {
        if (!auth()->check()) {
            session(['pending_product_id' => $id]);
            session(['return_to' => url()->previous()]);

            return response()->json([
                'status'   => 'unauthenticated',
                'message'  => 'Inicia sesión para añadir al carrito',
                'redirect' => route('login')
            ], 401);
        }

        $producto = Productos::findOrFail($id);
        $pedidos  = session()->get('pedidos', []);

        if (isset($pedidos[$id])) {
            $pedidos[$id]['cantidad']++;
        } else {
            $pedidos[$id] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio,
                'cantidad' => 1,
                'imagen'   => $producto->imagen,
                'tipo'     => $producto->tipo,
            ];
        }

        session(['pedidos' => $pedidos]);

        CarritoItem::updateOrCreate(
            ['usuario_id' => Auth::id(), 'producto_id' => $id],
            ['cantidad'   => $pedidos[$id]['cantidad']]
        );

        $conteo_items = array_sum(array_column($pedidos, 'cantidad'));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => '¡Producto ' . $producto->nombre . ' añadido a tu carrito!',
                'total_items' => $conteo_items
            ]);
        }

        return redirect()->back()->with('success', '✓ Producto agregado al carrito');
    }

    public function index()
    {
        $pedidos = session()->get('pedidos', []);

        if (empty($pedidos) && Auth::check()) {
            $pedidos = self::cargarCarritoDesdeDB();
        }

        $total = 0;
        foreach ($pedidos as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('pedido', compact('pedidos', 'total'));
    }

    public function actualizar(Request $request, $id)
    {
        $pedidos  = session()->get('pedidos', []);
        $cantidad = (int) $request->input('cantidad', 1);

        if (isset($pedidos[$id])) {
            if ($cantidad > 0) {
                $pedidos[$id]['cantidad'] = $cantidad;

                CarritoItem::where('usuario_id', Auth::id())
                    ->where('producto_id', $id)
                    ->update(['cantidad' => $cantidad]);
            } else {
                unset($pedidos[$id]);

                CarritoItem::where('usuario_id', Auth::id())
                    ->where('producto_id', $id)
                    ->delete();
            }

            session(['pedidos' => $pedidos]);

            if ($request->ajax() || $request->wantsJson()) {
                $nuevoTotal = 0;
                foreach ($pedidos as $item) {
                    $nuevoTotal += $item['precio'] * $item['cantidad'];
                }

                $nuevoSubtotal = isset($pedidos[$id])
                    ? $pedidos[$id]['precio'] * $pedidos[$id]['cantidad']
                    : 0;

                return response()->json([
                    'success'       => true,
                    'nuevaCantidad' => $pedidos[$id]['cantidad'] ?? 0,
                    'nuevoSubtotal' => number_format($nuevoSubtotal, 0, ',', '.'),
                    'nuevoTotal'    => number_format($nuevoTotal, 0, ',', '.')
                ]);
            }
        }

        return redirect()->route('pedidos.index');
    }

    public function eliminar($id)
    {
        $pedidos = session()->get('pedidos', []);

        if (isset($pedidos[$id])) {
            unset($pedidos[$id]);
            session(['pedidos' => $pedidos]);
        }

        CarritoItem::where('usuario_id', Auth::id())
            ->where('producto_id', $id)
            ->delete();

        return redirect()->route('pedidos.index')->with('success', '✓ Producto eliminado');
    }

    public function vaciar()
    {
        session()->forget('pedidos');

        CarritoItem::where('usuario_id', Auth::id())->delete();

        return redirect()->route('pedidos.index')->with('success', '✓ Pedido vaciado');
    }

    public function guardarPendiente(Request $request)
    {
        session([
            'pending_product_id' => $request->id,
            'return_to'          => $request->url
        ]);
        return response()->json(['status' => 'ok']);
    }
}
