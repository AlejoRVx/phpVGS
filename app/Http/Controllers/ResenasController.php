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
        $datos = $this->resenas->datosDeProducto($id);

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
}
