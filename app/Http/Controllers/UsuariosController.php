<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios; 
use App\Http\Controllers\PedidosController;

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
            'contrasena' => ['required', 'min:8', 'string', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/',],
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

        /*Permite realizar una solicitud POST al webhook para registrar el usuario en n8n
        Http::post('http://localhost:5678/webhook-test/register-user', [
            'nombre' => $usuario->nombre,
            'correo' => $usuario->correo,
        ]);
        */

        return redirect()->route('login');
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

            if ($usuario->rol_id != 2) {
                PedidosController::cargarCarritoDesdeDB();
            }

            if ($usuario->rol_id == 2) {
                return redirect()->route('admin.main');
            }

            if (session()->has('pending_product_id')) {
                $productId = session()->pull('pending_product_id');
                $returnUrl = session()->pull('return_to', route('main'));

                return redirect($returnUrl)->with('auto_add_cart', $productId);
            }

            return redirect()->route('main');
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

        return back()->with('success', 'Usuario eliminado correctamente');
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

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function clave_olvidada(Request $request)
    {
        return view('clave_olvidada');
    }

    public function validar_clave_olvidada(Request $request)
{
    $request->validate([
        'correo' => 'required|email|exists:usuarios,correo',
        'contrasena1' => ['required', 'min:8', 'string', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/',],
        'contrasena2' => 'required|min:8|same:contrasena1',
    ], [
        'correo.exists' => 'Este correo no está registrado en el sistema.',
        'contrasena1.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'contrasena2.min' => 'La confirmación debe tener al menos 8 caracteres.',
        'contrasena2.same' => 'Las contraseñas no coinciden.',
    ]);

    $usuario = Usuarios::where('correo', $request->correo)->first();
    $usuario->contrasena = Hash::make($request->contrasena1);
    $usuario->save();

    return redirect('/')->with('success', 'Contraseña actualizada correctamente.');
}

public function perfil()
{
    $usuario = Auth::user();
    return view('perfil', compact('usuario'));
}

public function actualizarPerfil(Request $request)
{
    $usuario = Auth::user();

    $request->validate([
        'nombre'    => 'required|string|max:255',
        'direccion' => 'required|string|max:500',
        'telefono'  => 'required|string|max:15',
    ], [
        'nombre.required'    => 'El nombre es obligatorio.',
        'direccion.required' => 'La dirección es obligatoria.',
        'telefono.required'  => 'El teléfono es obligatorio.',
        'telefono.max'       => 'El teléfono no puede superar 15 caracteres.',
        'correo.required'   => 'El correo es obligatorio.',
        'correo.email'      => 'El correo debe ser una dirección válida.',
        'correo.unique'     => 'Este correo ya está registrado.',
    ]);

    $usuario->nombre    = $request->nombre;
    $usuario->direccion = $request->direccion;
    $usuario->telefono  = $request->telefono;
    $usuario->correo      = $request->correo;

    $usuario->save();

    return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente');
}
}