<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resenas;

class Productos extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'stock',
        'tipo',
        'genero',
        'nombre',
        'compania',
        'fecha_lanzamiento',
        'precio',
        'descripcion',
        'imagen',
    ];

    protected $casts = [
        'fecha_lanzamiento' => 'datetime',
        'precio' => 'decimal:2',
    ];

    public function resenas()
    {
        return $this->hasMany(Resenas::class, 'producto_id');
    }

    public function calificacionPromedio()
    {
        return $this->resenas()->avg('calificacion') ?? 0;
    }
}