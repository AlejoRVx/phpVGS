<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function agregar($id)
    {
        $producto = Productos::findOrFail($id);
        $pedidos = session()->get('pedidos', []);
        
        if (isset($pedidos[$id])) {
            $pedidos[$id]['cantidad']++;
        } else {
            $pedidos[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen,
                'tipo' => $producto->tipo
            ];
        }
        
        session(['pedidos' => $pedidos]);
        
        return redirect()->back()->with('success', '✓ Producto agregado al pedido');
    }

    public function index()
    {
        $pedidos = session()->get('pedidos', []);
        
        $total = 0;
        foreach ($pedidos as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        
        return view('pedido', compact('pedidos', 'total'));
    }

    public function actualizar(Request $request, $id)
    {
        $pedidos = session()->get('pedidos', []);
        
        if (isset($pedidos[$id])) {
            $cantidad = $request->input('cantidad', 1);
            
            if ($cantidad > 0) {
                $pedidos[$id]['cantidad'] = $cantidad;
            } else {
                unset($pedidos[$id]);
            }
            
            session(['pedidos' => $pedidos]);
        }
        
        return redirect()->route('pedidos.index')->with('success', '✓ Pedido actualizado');
    }

    public function eliminar($id)
    {
        $pedidos = session()->get('pedidos', []);
        
        if (isset($pedidos[$id])) {
            unset($pedidos[$id]);
            session(['pedidos' => $pedidos]);
        }
        
        return redirect()->route('pedidos.index')->with('success', '✓ Producto eliminado');
    }

    public function vaciar()
    {
        session()->forget('pedidos');
        
        return redirect()->route('pedidos.index')->with('success', '✓ Pedido vaciado');
    }
}