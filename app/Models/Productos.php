<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
