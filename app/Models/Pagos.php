<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'pedido_id',
        'total',
        'metodo',
        'fecha_pago',
    ];
}
