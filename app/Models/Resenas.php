<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resenas extends Model
{
    protected $table = 'resenas';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'calificacion',
        'comentario',
        'fecha',
    ];
}
