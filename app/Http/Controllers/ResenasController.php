<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class ResenasController extends Controller
{
    public function show($id)
    {
        $producto = Productos::findOrFail($id);
        return view('resenas', compact('producto'));
    }
}