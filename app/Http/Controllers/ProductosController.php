<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;


class ProductosController extends Controller
{
public function listarjuegos(Request $request)
{
    $productos = $this->aplicarFiltros(
        Productos::where('tipo', 'Juego'), $request
    );
    return view('juegos', compact('productos'));
}

public function listarconsolas(Request $request)
{
    $productos = $this->aplicarFiltros(
        Productos::where('tipo', 'Consola'), $request
    );
    return view('consolas', compact('productos'));
}

private function aplicarFiltros($query, Request $request)
{
    $orden = $request->input('orden', 'nombre_asc');

    if ($orden === 'nombre_asc') {
        $query->orderBy('nombre', 'asc');
    } elseif ($orden === 'nombre_desc') {
        $query->orderBy('nombre', 'desc');
    } elseif ($orden === 'calificacion') {
        $query->withAvg('resenas', 'calificacion')
            ->orderByDesc('resenas_avg_calificacion');
    } elseif ($orden === 'precio_asc') {
        $query->orderBy('precio', 'asc');
    } elseif ($orden === 'precio_desc') {
        $query->orderBy('precio', 'desc');
    } elseif ($orden === 'fecha_lanzamiento_desc') {
        $query->orderBy('fecha_lanzamiento', 'desc');
    } elseif ($orden === 'fecha_lanzamiento_asc') {
        $query->orderBy('fecha_lanzamiento', 'asc');
    } else {
        $query->orderBy('id', 'asc');
    }

    return $query->get();
}

public function buscarJuegos(Request $request)
{
    return $this->buscar($request, 'Juego');
}

public function buscarConsolas(Request $request)
{
    return $this->buscar($request, 'Consola');
}

public function buscar(Request $request, $tipo)
{
    $query = $request->input('q');

    $productos = Productos::where('tipo', $tipo)
        ->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%{$query}%")
              ->orWhere('genero', 'like', "%{$query}%")
              ->orWhere('compania', 'like', "%{$query}%");
        })
        ->limit(10)
        ->get();

    if ($request->ajax()) {
        $html = view('partials.search_results', compact('productos'))->render();
        return response()->json(['html' => $html]);
    }

    $view = $tipo === 'Juego' ? 'juegos' : 'consolas';

    return view($view, compact('productos'));
}

}