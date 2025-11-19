<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditorias extends Model
{
    protected $table = 'auditorias';
    
    protected $fillable = [
        'tabla',
        'accion',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];
}
