<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticias extends Model
{
    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'resumen',
        'imagen',
        'categoria',
        'enlace',
    ];
}
