<?php

namespace App\Services\Usuarios;

use App\Domain\Contracts\UserNotifier;
use App\Models\Usuarios;
use App\Repositories\UsuarioRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    public function __construct(
        private UsuarioRepository $usuarios,
        private UserNotifier $notifier
    ) {}

    public function registrar(array $datos): Usuarios
    {
        $usuario = $this->usuarios->crear([
            'correo' => $datos['correo'],
            'contrasena' => Hash::make($datos['contrasena']),
            'nombre' => $datos['nombre'],
            'direccion' => $datos['direccion'],
            'telefono' => $datos['telefono'],
            'rol_id' => 1,
        ]);

        $this->notifier->notificarRegistro($usuario->nombre, $usuario->correo);

        return $usuario;
    }

    public function actualizarPerfil(Usuarios $usuario, array $datos): void
    {
        $usuario->update($datos);
    }

    /**
     * --- Panel admin ---
     */
    public function listarClientes(): LengthAwarePaginator
    {
        return $this->usuarios->paginado();
    }

    public function actualizarDesdeAdmin(int $usuarioId, array $datos): void
    {
        $usuario = $this->usuarios->findOrFail($usuarioId);
        $usuario->update($datos);
    }

    public function eliminar(int $usuarioId): void
    {
        $this->usuarios->findOrFail($usuarioId)->delete();
    }
}
