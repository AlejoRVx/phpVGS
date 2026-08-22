<?php

namespace App\Http\Controllers;

use App\Services\Catalogo\CatalogoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductosController extends Controller
{
    public function __construct(private CatalogoService $catalogo) {}

    public function listarjuegos(Request $request): View
    {
        $productos = $this->catalogo->juegos($this->filtros($request));

        return view('juegos', compact('productos'));
    }

    public function listarconsolas(Request $request): View
    {
        $productos = $this->catalogo->consolas($this->filtros($request));

        return view('consolas', compact('productos'));
    }

    public function buscarJuegos(Request $request): JsonResponse|View
    {
        return $this->buscar($request, 'Juego');
    }

    public function buscarConsolas(Request $request): JsonResponse|View
    {
        return $this->buscar($request, 'Consola');
    }

    private function buscar(Request $request, string $tipo): JsonResponse
    {
        $request->validate(['q' => 'required|string|max:100']);

        $productos = $this->catalogo->buscar($tipo, (string) $request->input('q'));

        return response()->json([
            'html' => view('partials.search_results', compact('productos'))->render(),
        ]);
    }

    /**
     * @return array{orden?: string, precio_min?: ?string, precio_max?: ?string}
     */
    private function filtros(Request $request): array
    {
        return [
            'orden' => (string) $request->input('orden', 'nombre_asc'),
            'precio_min' => $request->input('precio_min'),
            'precio_max' => $request->input('precio_max'),
        ];
    }
}
