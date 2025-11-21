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

            $usuario = Auth::user();

            if ($usuario->rol_id == 2) {
                return redirect()->intended('/admin/main');
            }

            return redirect()->intended('/main');
        }
        
        return back()->withErrors([
            'correo' => 'Clave o correo inválidos. Inténtalo de nuevo.',
        ])->onlyInput('correo');
    }

    public function cerrarsesion(Request $request)
    {
        session()->forget('pedidos');

        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function listarUsuarios()
    {
        $usuarios = Usuarios::all();
        return view('admin.listausuarios', compact('usuarios'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id'
        ]);

        $usuario = Usuarios::findOrFail($request->usuario_id);
        $usuario->delete();

        return redirect('/admin/listausuarios')->with('success', 'Usuario eliminado correctamente');
    }

    public function editarUsuario($id)
    {
        $usuario = Usuarios::findOrFail($id);
        return view('admin.editarusuario', compact('usuario'));
    }

    public function actualizarUsuario(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:15',
        ]);

        $usuario = Usuarios::findOrFail($request->usuario_id);
        $usuario->nombre = $request->nombre;
        $usuario->direccion = $request->direccion;
        $usuario->telefono = $request->telefono;
        $usuario->rol_id = $request->rol_id;
        $usuario->save();

        return redirect('/admin/listausuarios')->with('success', 'Usuario actualizado correctamente');
    }

    public function clave_olvidada(Request $request)
    {
        return view('clave_olvidada');
    }

    public function validar_clave_olvidada(Request $request)
{
    $request->validate([
        'correo' => 'required|email|exists:usuarios,correo',
        'contrasena1' => 'required|min:6',
        'contrasena2' => 'required|min:6|same:contrasena1',
    ], [
        'correo.exists' => 'Este correo no está registrado en el sistema.',
        'contrasena1.min' => 'La contraseña debe tener al menos 6 caracteres.',
        'contrasena2.min' => 'La confirmación debe tener al menos 6 caracteres.',
        'contrasena2.same' => 'Las contraseñas no coinciden.',
    ]);

    $usuario = Usuarios::where('correo', $request->correo)->first();
    $usuario->contrasena = Hash::make($request->contrasena1);
    $usuario->save();

    return redirect('/')->with('success', 'Contraseña actualizada correctamente.');
}
}