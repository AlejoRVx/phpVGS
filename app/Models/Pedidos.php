<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    public $table = 'pedidos';

    public $fillable = [
        'usuario_id',
        'total',
        'estado',
    ];
}
