<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $table = 'carrito_items';

    protected $fillable = ['usuario_id', 'producto_id', 'cantidad'];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}