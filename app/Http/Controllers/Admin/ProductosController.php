<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productos;


class ProductosController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->query('tipo');

        $productos = Productos::when($tipo, function ($query, $tipo) {
            return $query->where('tipo', $tipo);
        })->get();

        return view('admin.productos.index', compact('productos', 'tipo'));
    }

    public function create(Request $request)
    {
        $tipo = $request->query('tipo', 'Juego'); 
        return view('admin.productos.create', compact('tipo'))->with('success', 'producto agregado correctamente');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stock' => 'required|integer',
            'tipo' => 'required|string',
            'genero' => 'nullable|string',
            'nombre' => 'required|string',
            'compania' => 'required|string',
            'fecha_lanzamiento' => 'required|date',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);

        if ($request->hasFile('imagen')) {
            $imageName = $data['nombre'].'.'.$request->imagen->extension();
            $request->imagen->move(public_path('img'), $imageName);
            $data['imagen'] = $imageName;
        }

        Productos::create($data);
        return redirect()->route('admin.productos.index')
            ->with('success','Producto creado correctamente');
    }

    public function edit($id)
    {
        $producto = Productos::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Productos::findOrFail($id);

        $data = $request->validate([
            'stock' => 'required|integer',
            'tipo' => 'required|string',
            'genero' => 'nullable|string',
            'nombre' => 'required|string',
            'compania' => 'required|string',
            'fecha_lanzamiento' => 'required|date',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);

        if ($request->hasFile('imagen')) {

            if ($producto->imagen && file_exists(public_path('img/'.$producto->imagen))) {
                unlink(public_path('img/'.$producto->imagen));
            }

            $imageName = $request->nombre.'.'.$request->imagen->extension();
            $request->imagen->move(public_path('img'), $imageName);
            $data['imagen'] = $imageName;
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')
            ->with('success','Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Productos::findOrFail($id);

        if ($producto->imagen && file_exists(public_path('img/'.$producto->imagen))) {
            unlink(public_path('img/'.$producto->imagen));
        }

        $producto->delete();

        return back()->with('success','Producto eliminado');
    }

    public function search (Request $request)
    {
        $query = $request->input('q');

        $productos = Productos::where('nombre', 'LIKE', "%$query%")
        ->orWhere('compania', 'LIKE', "%$query%")
        ->get();

        return view('admin.productos.index', compact('productos'));
    }
}