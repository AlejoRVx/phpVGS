<?php

namespace App\Services\Usuarios;

use App\Domain\Contracts\UserNotifier;
use App\Repositories\UsuarioRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Flujo: solicitar código -> validar código -> definir nueva clave.
 * El estado del flujo vive en la sesión con expiración de 3 minutos.
 */
class RecuperacionClaveService
{
    private const SEGUNDOS_EXPIRACION = 180;

    private const CLAVE_CODIGO = 'verificacion_codigo';

    private const CLAVE_CORREO = 'verificacion_correo';

    private const CLAVE_CREADO_EN = 'verificacion_creado_en';

    private const CLAVE_AUTORIZADO = 'codigo_verificado_exitosamente';

    public function __construct(
        private UsuarioRepository $usuarios,
        private UserNotifier $notifier
    ) {}

    /**
     * Genera y envía el código. Devuelve true si el envío fue confirmado.
     */
    public function solicitarCodigo(string $correo): bool
    {
        $usuario = $this->usuarios->buscarPorCorreo($correo);
        $codigo = (string) random_int(100000, 999999);

        if (! $this->notifier->enviarCodigoVerificacion($usuario->correo, $usuario->nombre, $codigo)) {
            return false;
        }

        Session::put([
            self::CLAVE_CODIGO => $codigo,
            self::CLAVE_CORREO => $usuario->correo,
            self::CLAVE_CREADO_EN => time(),
        ]);

        return true;
    }

    public function tieneSolicitudPendiente(): bool
    {
        return Session::has(self::CLAVE_CODIGO);
    }

    /**
     * Valida el código ingresado.
     *
     * @return array{ok: bool, correo?: string, motivo?: string}
     */
    public function validarCodigo(string $codigoIngresado): array
    {
        $codigoCorrecto = Session::get(self::CLAVE_CODIGO);
        $correo = Session::get(self::CLAVE_CORREO);
        $creadoEn = Session::get(self::CLAVE_CREADO_EN);

        if (! $codigoCorrecto || ! $correo || ! $creadoEn) {
            return ['ok' => false, 'motivo' => 'sin_sesion'];
        }

        if ((time() - $creadoEn) > self::SEGUNDOS_EXPIRACION) {
            $this->limpiarSolicitud();

            return ['ok' => false, 'motivo' => 'expirado'];
        }

        if ($codigoIngresado !== $codigoCorrecto) {
            return ['ok' => false, 'motivo' => 'incorrecto'];
        }

        Session::put(self::CLAVE_AUTORIZADO, $correo);

        return ['ok' => true, 'correo' => $correo];
    }

    /**
     * Verifica que el correo esté autorizado para cambiar clave.
     */
    public function estaAutorizado(string $correo): bool
    {
        $autorizado = Session::get(self::CLAVE_AUTORIZADO);
        $enFlujo = Session::get(self::CLAVE_CORREO);

        return $autorizado !== null && $autorizado === $enFlujo && $autorizado === $correo;
    }

    public function consumirAutorizacion(): void
    {
        Session::forget(self::CLAVE_AUTORIZADO);
    }

    /**
     * Actualiza la contraseña del usuario del flujo.
     */
    public function actualizarClave(string $correo, string $nuevaClave): bool
    {
        $usuario = $this->usuarios->buscarPorCorreo($correo);

        if (! $usuario) {
            return false;
        }

        $usuario->contrasena = Hash::make($nuevaClave);
        $usuario->save();

        $this->limpiarFlujoCompleto();

        return true;
    }

    public function limpiarSolicitud(): void
    {
        Session::forget([self::CLAVE_CODIGO, self::CLAVE_CORREO, self::CLAVE_CREADO_EN]);
    }

    public function limpiarFlujoCompleto(): void
    {
        Session::forget([
            self::CLAVE_CODIGO,
            self::CLAVE_CORREO,
            self::CLAVE_CREADO_EN,
            self::CLAVE_AUTORIZADO,
        ]);
    }
}
