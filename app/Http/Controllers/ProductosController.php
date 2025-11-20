<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    public function listarjuegos()
    {
        $productos = Productos::all()->where('tipo', 'Juego');
        return view('admin.juegos', compact('productos'));
    }

    public function listarconsolas()
    {
        $productos = Productos::all()->where('tipo', 'Consola');
        return view('admin.consolas', compact('productos'));
    }

    public function listarjuegosuser()
    {
        $productos = Productos::all()->where('tipo', 'Juego');
        return view('juegos', compact('productos'));
    }

    public function listarconsolasuser()
    {
        $productos = Productos::all()->where('tipo', 'Consola');
        return view('consolas', compact('productos'));
    }

    public function agregarproducto($tipo)
    {
        return view('admin.agregarproducto', compact('tipo'));
    }

   public function actualizarproducto(Request $request)
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
        $imageName = $data['nombre'] . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('img'), $imageName);
        $data['imagen'] = $imageName;
    }

    Productos::create($data);

    if ($data['tipo'] == 'Juego') {
        return redirect('/admin/juegos')->with('success', 'Juego agregado exitosamente.');
    } else {
        return redirect('/admin/consolas')->with('success', 'Consola agregada exitosamente.');
    }
}
public function editarproducto($tipo, $id)
{
    $producto = Productos::findOrFail($id);
    return view('admin.editarproducto', compact('producto'));
}

public function guardarcambios(Request $request){
    $request->validate([
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

    $producto = Productos::findOrFail($request->producto_id);
    $producto->stock = $request->stock;
    $producto->tipo = $request->tipo;
    $producto->genero = $request->genero;
    $producto->nombre = $request->nombre;
    $producto->compania = $request->compania;
    $producto->fecha_lanzamiento = $request->fecha_lanzamiento;
    $producto->precio = $request->precio;
    $producto->descripcion = $request->descripcion;
    
    if ($request->hasFile('imagen')) {
        if ($producto->imagen && file_exists(public_path('img/' . $producto->imagen))) {
            unlink(public_path('img/' . $producto->imagen));
        }
        
        $imageName = $request->nombre . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('img'), $imageName);
        $producto->imagen = $imageName;
    }
    
    $producto->save();

    if ($producto->tipo == 'Juego') {
        return redirect('/admin/juegos')->with('success', 'Juego editado exitosamente.');
    } else {
        return redirect('/admin/consolas')->with('success', 'Consola editada exitosamente.');
    }
}

public function delete(Request $request)
{
    $productoId = $request->input('producto_id');
    $producto = Productos::find($productoId);
    if ($producto) {
        unlink(public_path('img/' . $producto->imagen));
        $producto->delete();
        return back()->with('success', 'Producto eliminado exitosamente.');
    } else {
        return back()->with('error', 'Producto no encontrado.');
    }
}

public function buscarjuegos(Request $request)
{
    $search = $request->q;

    $productos = Productos::where('tipo', 'juego')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('genero', 'LIKE', "%{$search}%")
                  ->orWhere('compania', 'LIKE', "%{$search}%")
                  ->orWhere('precio', 'LIKE', "%{$search}%");
            });
        })->get();

        $usuario = Auth::user();

        if($usuario->rol_id == 2){
            return view('admin.juegos', compact('productos'));
        }
        return view('juegos', compact('productos'));
}

public function buscarconsolas(Request $request)
{
    $search = $request->q;

    $productos = Productos::where('tipo', 'consola')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('compania', 'LIKE', "%{$search}%")
                  ->orWhere('precio', 'LIKE', "%{$search}%");

            });
        })->get();

        $usuario = Auth::user();

        if($usuario->rol_id == 2){
            return view('admin.consolas', compact('productos'));
        }
        return view('consolas', compact('productos'));
}


}
