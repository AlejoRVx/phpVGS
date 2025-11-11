<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

class UsuariosController extends Controller
{
    public function index()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:15',
        ]);

        $usuario = new Usuarios();
        $usuario->correo = $validatedData['correo'];
        $usuario->contrasena = Hash::make($validatedData['contrasena']);
        $usuario->nombre = $validatedData['nombre'];
        $usuario->direccion = $validatedData['direccion'];
        $usuario->telefono = $validatedData['telefono'];
        $usuario->rol_id = 1; // Default role as User
        $usuario->save();

        return redirect('/');
    }  

    public function login(Request $request)
    {
        
        return view('main');
        
        /*
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $usuario = Usuarios::where('correo', $credentials['correo'])->first();

        if ($usuario && Hash::check($credentials['contrasena'], $usuario->contrasena)) {
            // Authentication passed
            // Here you would typically set session data or a token
            return redirect('/main');
        } else {
            return back()->withErrors([
                'correo' => 'The provided credentials do not match our records.',
            ]);
        } 
        */
    }
}
