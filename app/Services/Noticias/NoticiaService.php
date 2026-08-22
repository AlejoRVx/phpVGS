<?php

namespace App\Services\Noticias;

use App\Models\Noticias;
use App\Repositories\NoticiaRepository;
use Illuminate\Support\Collection;

class NoticiaService
{
    public function __construct(private NoticiaRepository $noticias) {}

    public function listar(): Collection
    {
        return $this->noticias->all();
    }

    public function obtener(int $id): Noticias
    {
        return $this->noticias->findOrFail($id);
    }

    public function crear(array $data): void
    {
        Noticias::create($data);
    }

    public function actualizar(Noticias $noticia, array $data): void
    {
        $noticia->update($data);
    }

    public function eliminar(Noticias $noticia): void
    {
        $noticia->delete();
    }
}
