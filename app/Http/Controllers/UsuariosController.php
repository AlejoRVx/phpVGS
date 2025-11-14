<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
        $usuario->rol_id = 1;
        $usuario->save();

        return redirect('/');
    }  

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $remember = $request->has('remember'); 

        if (Auth::attempt([
            'correo' => $credentials['correo'], 
            'password' => $credentials['contrasena'] 
        ], $remember)) {

            $request->session()->regenerate();

            return redirect()->intended('/main');
        }
        
        return back()->withErrors([
            'correo' => 'Clave o correo inválidos. Inténtalo de nuevo.',
        ])->onlyInput('correo');
    }
    public function cerrarsesion(Request $request)
    {
        session()->flash(...);
    }
}
