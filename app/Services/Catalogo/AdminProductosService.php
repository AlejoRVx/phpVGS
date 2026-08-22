<?php

namespace App\Services\Catalogo;

use App\Models\Productos;
use App\Repositories\ProductoRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class AdminProductosService
{
    public function __construct(private ProductoRepository $productos) {}

    public function listar(?string $tipo = null, ?string $q = null): LengthAwarePaginator
    {
        return $this->productos->administracion($tipo, $q);
    }

    public function findOrFail(int $id): Productos
    {
        return $this->productos->findOrFail($id);
    }

    public function crear(array $datos, ?UploadedFile $imagen): void
    {
        if ($imagen) {
            $datos['imagen'] = $this->guardarImagen($imagen, $datos['nombre']);
        }

        Productos::create($datos);
    }

    public function actualizar(Productos $producto, array $datos, ?UploadedFile $imagen): void
    {
        if ($imagen) {
            $this->eliminarArchivo($producto->imagen);
            $datos['imagen'] = $this->guardarImagen($imagen, $datos['nombre']);
        }

        $producto->update($datos);
    }

    public function eliminar(Productos $producto): void
    {
        $this->eliminarArchivo($producto->imagen);
        $producto->delete();
    }

    private function guardarImagen(UploadedFile $imagen, string $nombreProducto): string
    {
        $nombreArchivo = $nombreProducto.'.'.$imagen->extension();
        $imagen->move(public_path('img'), $nombreArchivo);

        return $nombreArchivo;
    }

    private function eliminarArchivo(?string $nombreArchivo): void
    {
        if ($nombreArchivo && file_exists(public_path('img/'.$nombreArchivo))) {
            @unlink(public_path('img/'.$nombreArchivo));
        }
    }
}
