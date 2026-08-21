<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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

        // Permite realizar una solicitud POST al webhook para registrar el usuario en n8n
        Http::post('http://localhost:5678/webhook/register-user', [
            'nombre' => $usuario->nombre,
            'correo' => $usuario->correo,
        ]);
        

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

    /**
     * 1. Muestra la vista para ingresar el correo electrónico.
     * RUTA: GET /clave-olvidada (named: password.request)
     */
    public function clave_olvidada()
    {
        return view('clave_olvidada');
    }

    /**
     * 2. Procesa el correo, genera el código de 6 dígitos y llama a n8n.
     * RUTA: POST /clave-olvidada
     */
    public function validar_verificacion(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|exists:usuarios,correo',
        ], [
            'correo.exists' => 'Este correo no está registrado en el sistema.',
        ]);

        $usuario = Usuarios::where('correo', $request->correo)->first();
        $codigo = $this->num_aleatorio(6);

        try {
            $respuesta = Http::post('http://localhost:5678/webhook/codigo-verificacion', [
                'codigo' => $codigo,
                'correo' => $usuario->correo,
                'nombre' => $usuario->nombre,
            ]);
        } catch (ConnectionException $e) {
            return back()->withErrors(['correo' => 'No se pudo establecer conexión con el servicio de verificación. Asegúrate de que esté activo.']);
        } catch (\Exception $e) {
            return back()->withErrors(['correo' => 'Ocurrió un error inesperado al procesar la solicitud.']);
        }

        if ($respuesta->json('codigo_enviado')) {
            // Guardamos el código, el correo y el tiempo actual de creación en la sesión
            session([
                'verificacion_codigo' => $codigo,
                'verificacion_correo' => $usuario->correo,
                'verificacion_creado_en' => time()
            ]);

            return redirect()->route('verificacion')->with('success', 'Código de verificación enviado.');
        }

        return back()->withErrors(['correo' => 'Hubo un error al enviar el código a n8n.'])->withInput();
    }

    /**
     * 3. Muestra la vista de los 6 cuadritos para ingresar el código.
     * RUTA: GET /verificacion (named: verificacion)
     */
    public function verificacion()
    {
        if (!session('verificacion_codigo')) {
            return redirect()->route('password.request')
                ->withErrors(['correo' => 'Debes solicitar un código de verificación primero.']);
        }

        return view('verificacion');
    }

    /**
     * 4. Valida si el código de los 6 cuadritos es correcto y no ha expirado.
     * RUTA: POST /verificacion (named: verificacion.validar)
     */
    public function validar_clave_olvidada(Request $request)
    {
        // El input oculto en tu HTML se llama 'correo', por eso validamos 'correo'
        $request->validate([
            'correo' => 'required|string|size:6', 
        ], [
            'correo.size' => 'El código de verificación debe contener 6 dígitos.',
        ]);

        $codigoCorrecto = session('verificacion_codigo');
        $correoUsuario  = session('verificacion_correo');
        $creadoEn       = session('verificacion_creado_en');

        // Límite de tiempo: 3 minutos (600 segundos)
        $minutosExpiracion = 180;

        if (!$codigoCorrecto || !$correoUsuario || !$creadoEn) {
            return redirect()->route('password.request')
                ->withErrors(['correo' => 'La sesión de recuperación no es válida o expiró.']);
        }

        // Validación de tiempo transcurrido
        if ((time() - $creadoEn) > $minutosExpiracion) {
            session()->forget(['verificacion_codigo', 'verificacion_correo', 'verificacion_creado_en']);
            return redirect()->route('password.request')
                ->withErrors(['correo' => 'El código ha expirado (límite 3 minutos). Solicita uno nuevo.']);
        }

        // Si el código coincide, guardamos su propio CORREO como credencial de éxito
        if ($request->correo === $codigoCorrecto) {
            session(['codigo_verificado_exitosamente' => $correoUsuario]);
            return redirect()->route('nueva_clave');
        }

        return back()->withErrors(['correo' => 'El código de verificación ingresado es incorrecto.']);
    }

    /**
     * 5. Muestra la vista para escribir las nuevas contraseñas.
     * RUTA: GET /nueva-clave (named: nueva_clave)
     */
    public function nueva_clave()
    {
        $correoAutorizado = session('codigo_verificado_exitosamente');
        $correoUsuario = session('verificacion_correo');

        // Control de seguridad estricto: deben coincidir los correos
        if (!$correoAutorizado || !$correoUsuario || $correoAutorizado !== $correoUsuario) {
            session()->forget(['codigo_verificado_exitosamente', 'verificacion_codigo', 'verificacion_correo']);
            return redirect()->route('password.request')
                ->withErrors(['correo' => 'Acceso denegado. La sesión de verificación es inválida o intentas usar otro correo.']);
        }

        // SOLUCIÓN AL ERROR GRAVE: Destruimos el pase de abordar inmediatamente al cargar la página
        session()->forget('codigo_verificado_exitosamente');

        // Enviamos el $correoUsuario a la vista para el input hidden del formulario final
        return view('nueva_clave', compact('correoUsuario'));
    }

    /**
     * 6. Procesa el formulario final, encripta y actualiza la contraseña en la BD.
     * RUTA: POST /nueva-clave (named: nueva_clave.actualizar)
     */
    public function actualizar_clave(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena1' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'contrasena2' => 'required|string|same:contrasena1',
        ], [
            'contrasena1.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'contrasena1.regex' => 'La contraseña debe incluir minúsculas, mayúsculas y números.',
            'contrasena2.same' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuarios::where('correo', $request->correo)->first();

        if (!$usuario) {
            return redirect()->route('password.request')
                ->withErrors(['correo' => 'No se pudo encontrar el usuario asociado.']);
        }

        // Guardamos la contraseña encriptada
        $usuario->contrasena = Hash::make($request->contrasena1);
        $usuario->save();

        // Limpieza absoluta de la sesión de recuperación
        session()->forget([
            'verificacion_codigo', 
            'verificacion_correo', 
            'verificacion_creado_en', 
            'codigo_verificado_exitosamente'
        ]);

        return redirect()->route('login')->with('success', 'Contraseña actualizada con éxito. Ya puedes iniciar sesión.');
    }

    /**
     * Función auxiliar para generar códigos numéricos aleatorios
     */
    private function num_aleatorio($longitud)
    {
        $caracteres = '0123456789';
        $numero = '';
        for ($i = 0; $i < $longitud; $i++) {
            $numero .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $numero;
    }
}