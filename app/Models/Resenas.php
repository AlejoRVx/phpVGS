<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resenas extends Model
{
    public $table = 'resenas';

    public $fillable = [
        'usuario_id',
        'producto_id',
        'calificacion',
        'comentario',
        'fecha',
    ];
}
