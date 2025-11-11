<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    public $table = 'usuarios';
    
    public $fillable = [
        'correo',
        'contrasena',
        'nombre',
        'direccion',
        'telefono',
        'rol_id',
    ];
}
