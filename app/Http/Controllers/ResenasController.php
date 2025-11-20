<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Resenas;

class ResenasController extends Controller
{
    public function show($id)
    {
        $producto = Productos::findOrFail($id);
        $resenas = Resenas::where('producto_id', $id)->orderBy('fecha', 'desc')->get();
        $promedioCalificacion = $resenas->avg('calificacion');
        $cantidadResenas = $resenas->count();
        return view('resenas', compact('resenas', 'producto', 'promedioCalificacion', 'cantidadResenas'));
    }

    public function agregarresena(Request $request)
    {
        $validatedData = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:10000',
        ]);

        $resena = new Resenas();
        $resena->producto_id = $validatedData['producto_id'];
        $resena->usuario_id = auth()->id();
        $resena->calificacion = $validatedData['calificacion'];
        $resena->comentario = $validatedData['comentario'];
        $resena->fecha = now();
        $resena->save();

        return redirect()->route('juegos.resenas', ['id' => $resena->producto_id])->with('success', 'Reseña agregada exitosamente.');
    }
}