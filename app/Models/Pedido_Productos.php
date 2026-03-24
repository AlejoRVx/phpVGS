<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido_Productos extends Model
{
    protected $table = 'pedido_productos';
    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario'];
    protected $casts = ['precio_unitario' => 'decimal:2'];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}