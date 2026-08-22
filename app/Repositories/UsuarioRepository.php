<?php

namespace App\Repositories;

use App\Models\Usuarios;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsuarioRepository
{
    public function findOrFail(int $id): Usuarios
    {
        return Usuarios::findOrFail($id);
    }

    public function buscarPorCorreo(string $correo): ?Usuarios
    {
        return Usuarios::where('correo', $correo)->first();
    }

    /**
     * Listado paginado para el panel admin (solo clientes, excluye admins).
     */
    public function paginado(int $perPage = 15): LengthAwarePaginator
    {
        return Usuarios::query()
            ->where('rol_id', '!=', 2)
            ->orderBy('nombre')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function crear(array $datos): Usuarios
    {
        return Usuarios::create($datos);
    }

    public function contarClientes(): int
    {
        return Usuarios::where('rol_id', 1)->count();
    }
}
