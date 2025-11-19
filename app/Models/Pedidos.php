<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];
}
