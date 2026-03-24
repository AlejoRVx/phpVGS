<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuarios;

class Resenas extends Model
{
    protected $table = 'resenas';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'calificacion',
        'comentario',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }
}
