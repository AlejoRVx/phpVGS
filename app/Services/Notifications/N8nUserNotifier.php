<?php

namespace App\Services\Notifications;

use App\Domain\Contracts\UserNotifier;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nUserNotifier implements UserNotifier
{
    private const TIMEOUT = 5;

    private function url(string $path): string
    {
        return rtrim((string) config('services.n8n.base_url'), '/').$path;
    }

    public function notificarRegistro(string $nombre, string $correo): void
    {
        try {
            Http::timeout(self::TIMEOUT)
                ->post($this->url('/webhook/register-user'), [
                    'nombre' => $nombre,
                    'correo' => $correo,
                ]);
        } catch (\Throwable $e) {
            Log::warning('No se pudo notificar el registro a n8n: '.$e->getMessage());
        }
    }

    public function enviarCodigoVerificacion(string $correo, string $nombre, string $codigo): bool
    {
        try {
            $respuesta = Http::timeout(self::TIMEOUT)
                ->post($this->url('/webhook/codigo-verificacion'), [
                    'codigo' => $codigo,
                    'correo' => $correo,
                    'nombre' => $nombre,
                ]);
        } catch (\Throwable $e) {
            Log::warning('No se pudo conectar con el servicio de verificación: '.$e->getMessage());

            return false;
        }

        return (bool) $respuesta->json('codigo_enviado');
    }
}
