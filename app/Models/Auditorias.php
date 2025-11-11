<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditorias extends Model
{
    public $table = 'auditorias';
    
    public $fillable = [
        'tabla',
        'accion',
        'fecha',
    ];
}
