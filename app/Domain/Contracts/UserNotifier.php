<?php

namespace App\Domain\Contracts;

interface UserNotifier
{
    /**
     * Notifica el registro de un usuario al sistema externo (n8n).
     * No debe interrumpir el flujo si el servicio no responde.
     */
    public function notificarRegistro(string $nombre, string $correo): void;

    /**
     * Envía un código de verificación de 6 dígitos.
     *
     * @return bool true si el servicio confirmó el envío
     */
    public function enviarCodigoVerificacion(string $correo, string $nombre, string $codigo): bool;
}
