<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use App\Models\Productos;
use App\Models\Pedidos;
use App\Models\Pagos;

class AdminsController extends Controller
{
    public function index()
    {
        $totalUsuarios  = Usuarios::where('rol_id', 1)->count();
        $totalProductos = Productos::count();
        $totalPedidos   = Pedidos::count();
        $totalVentas    = Pagos::sum('total');

        $ultimosPedidos = Pedidos::with(['pago'])
            ->join('usuarios', 'pedidos.usuario_id', '=', 'usuarios.id')
            ->select('pedidos.*', 'usuarios.nombre as nombre_usuario')
            ->orderByDesc('pedidos.created_at')
            ->limit(5)
            ->get();

        return view('admin.main', compact(
            'totalUsuarios',
            'totalProductos',
            'totalPedidos',
            'totalVentas',
            'ultimosPedidos'
        ));
    }
}