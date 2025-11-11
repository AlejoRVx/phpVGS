<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido_Productos extends Model
{
    public $table = 'pedido_productos';
    
    public $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];
}
