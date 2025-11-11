<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public $table = 'roles';

    public $fillable = [
        'tipo',
    ];
}
