<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Pedido_Productos;
use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CarritoItem;

class PagosController extends Controller
{
    public function index()
    {
        $pedidos = session()->get('pedidos', []);
        
        if (empty($pedidos)) {
            return redirect()->route('pedidos.index')->with('error', 'Tu pedido está vacío');
        }
        
        $total = 0;
        foreach ($pedidos as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        
        return view('pagos', compact('pedidos', 'total'));
    }

    public function pagar(Request $request)
    {
        $pedidos = session()->get('pedidos', []);

        if (empty($pedidos)) {
            return redirect()->route('pedidos.index')->with('error', 'Tu pedido está vacío');
        }

        $total = 0;
        foreach ($pedidos as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $pedido = Pedidos::create([
            'total'      => $total,
            'estado'     => true,
            'usuario_id' => Auth::id(),
        ]);

        foreach ($pedidos as $item) {
            Pedido_Productos::create([
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'pedido_id'       => $pedido->id,
                'producto_id'     => $item['id'],
            ]);
        }

        $pago = Pagos::create([
            'fecha_pago' => now(),
            'metodo'     => $request->input('metodo', 'Tarjeta de crédito'),
            'total'      => $total,
            'pedido_id'  => $pedido->id,
        ]);

        session()->forget('pedidos');
        CarritoItem::where('usuario_id', Auth::id())->delete();

        return redirect()->route('factura', ['pedido' => $pedido->id])
            ->with('factura_data', [
                'pedido_id' => $pedido->id,
                'fecha'     => $pago->fecha_pago,
                'metodo'    => $pago->metodo,
                'total'     => $total,
                'items'     => $pedidos,
                'usuario'   => [
                    'nombre'    => Auth::user()->nombre,
                    'direccion' => Auth::user()->direccion,
                    'telefono'  => Auth::user()->telefono,
                ],
            ]);
    }

public function factura()
{
    $data = session('factura_data');

    if (!$data) {
        return redirect()->route('main');
    }

    return view('factura', compact('data'));
}

public function historial()
{
    $pedidos = Pedidos::with(['productos.producto', 'pago'])
        ->where('usuario_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('historial', compact('pedidos'));
}

public function facturaHistorial($id)
{
    $pedido = Pedidos::with(['productos.producto', 'pago'])
        ->where('usuario_id', Auth::id())
        ->findOrFail($id);

    $usuario = Auth::user();

    $items = $pedido->productos->map(function ($pp) {
        return [
            'nombre'   => $pp->producto->nombre,
            'precio'   => $pp->precio_unitario,
            'cantidad' => $pp->cantidad,
            'imagen'   => $pp->producto->imagen,
            'tipo'     => $pp->producto->tipo,
        ];
    })->toArray();

    $data = [
        'pedido_id' => $pedido->id,
        'fecha'     => $pedido->pago->fecha_pago,
        'metodo'    => $pedido->pago->metodo,
        'total'     => $pedido->total,
        'items'     => $items,
        'usuario'   => [
            'nombre'    => $usuario->nombre,
            'direccion' => $usuario->direccion,
            'telefono'  => $usuario->telefono,
        ],
    ];

    return view('factura', compact('data'));
}
}