<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
    protected $fillable = ['usuario_id', 'total', 'estado'];
    protected $casts = ['total' => 'decimal:2'];
    
    public function productos()
    {
        return $this->hasMany(Pedido_Productos::class, 'pedido_id');
    }

    public function pago()
    {
        return $this->hasOne(Pagos::class, 'pedido_id');
    }
}