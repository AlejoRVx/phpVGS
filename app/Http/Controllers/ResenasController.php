<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarResenaRequest;
use App\Models\Productos;
use App\Services\Resenas\ResenaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResenasController extends Controller
{
    public function __construct(private ResenaService $resenas) {}

    public function show(int $id): View
    {
        $datos = $this->resenas->datosDeProducto($id, auth()->id());

        return view('resenas', $datos);
    }

    public function agregarresena(GuardarResenaRequest $request, int $id): RedirectResponse
    {
        $producto = Productos::findOrFail($id);

        $this->resenas->crear(
            $producto,
            auth()->id(),
            $request->calificacion,
            $request->comentario
        );

        return redirect()
            ->route('productos.resenas', ['id' => $id])
            ->with('success', 'Reseña agregada exitosamente.');
    }

    public function editarresena(GuardarResenaRequest $request, int $id): RedirectResponse
    {
        $resena = $this->resenas->obtenerResena($id, auth()->id());

        $this->resenas->actualizar($resena, $request->calificacion, $request->comentario);

        return redirect()
            ->route('productos.resenas', ['id' => $resena->producto_id])
            ->with('success', 'Reseña actualizada exitosamente.');
    }

    public function eliminarresena(int $id): RedirectResponse
    {
        $resena = $this->resenas->obtenerResena($id, auth()->id());
        $productoId = $resena->producto_id;

        $this->resenas->eliminar($resena);

        return redirect()
            ->route('productos.resenas', ['id' => $productoId])
            ->with('success', 'Reseña eliminada exitosamente.');
    }
}
