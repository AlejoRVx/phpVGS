<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Pedido_Productos;
use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'total' => $total,
            'estado' => true,
            'usuario_id' => Auth::id() ?? 1,
        ]);
        
        foreach ($pedidos as $item) {
            Pedido_Productos::create([
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'pedido_id' => $pedido->id,
                'producto_id' => $item['id'],
            ]);
        }
        
        $pago = Pagos::create([
            'fecha_pago' => now(),
            'metodo' => $request->input('metodo', 'Tarjeta de crédito'),
            'total' => $total,
            'pedido_id' => $pedido->id,
        ]);
        
        session()->forget('pedidos');
        
        return redirect()->route('pagos.index');
    }
}