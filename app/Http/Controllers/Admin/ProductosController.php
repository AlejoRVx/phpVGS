<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GuardarProductoRequest;
use App\Services\Catalogo\AdminProductosService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductosController extends Controller
{
    public function __construct(private AdminProductosService $adminProductos) {}

    public function index(Request $request): View
    {
        $productos = $this->adminProductos->listar(
            $request->query('tipo'),
            $request->query('q')
        );

        return view('admin.productos.index', [
            'productos' => $productos,
            'tipo' => $request->query('tipo'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.productos.create', [
            'tipo' => $request->query('tipo', 'Juego'),
        ]);
    }

    public function store(GuardarProductoRequest $request): RedirectResponse
    {
        $this->adminProductos->crear(
            $request->validated(),
            $request->file('imagen')
        );

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit(int $id): View
    {
        $producto = $this->adminProductos->findOrFail($id);

        return view('admin.productos.edit', compact('producto'));
    }

    public function update(GuardarProductoRequest $request, int $id): RedirectResponse
    {
        $producto = $this->adminProductos->findOrFail($id);

        $this->adminProductos->actualizar(
            $producto,
            $request->validated(),
            $request->file('imagen')
        );

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        $producto = $this->adminProductos->findOrFail($id);

        $this->adminProductos->eliminar($producto);

        return back()->with('success', 'Producto eliminado');
    }

    public function search(Request $request): View
    {
        $request->validate(['q' => 'nullable|string|max:100']);

        $productos = $this->adminProductos->listar(null, $request->input('q'));

        return view('admin.productos.index', compact('productos'));
    }
}
