<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    public $table = 'pagos';

    public $fillable = [
        'pedido_id',
        'total',
        'metodo',
        'fecha_pago',
    ];
}
