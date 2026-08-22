<?php

namespace App\Http\Controllers;

use App\Domain\Cart\CartManager;
use App\Http\Requests\ActualizarPerfilRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\Usuarios;
use App\Services\Usuarios\RecuperacionClaveService;
use App\Services\Usuarios\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    public function __construct(
        private UsuarioService $usuarios,
        private RecuperacionClaveService $recuperacion,
        private CartManager $cart
    ) {}

    // ─── Registro ───────────────────────────────────────────

    public function index(): View
    {
        return view('register');
    }

    public function register(RegistroRequest $request): RedirectResponse
    {
        $this->usuarios->registrar($request->validated());

        return redirect()->route('login')->with('success', '¡Registro exitoso! Ya puedes iniciar sesión.');
    }

    // ─── Login ──────────────────────────────────────────────

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt([
            'correo' => $credentials['correo'],
            'password' => $credentials['contrasena'],
        ], $remember)) {
            return back()
                ->withErrors(['correo' => 'Clave o correo inválidos. Inténtalo de nuevo.'])
                ->onlyInput('correo');
        }

        $request->session()->regenerate();
        $usuario = Auth::user();

        if ($usuario->rol_id == 2) {
            return redirect()->route('admin.main');
        }

        $this->cart->loadFromDatabase($usuario->id);

        if (session()->has('pending_product_id')) {
            $productId = session()->pull('pending_product_id');
            $returnUrl = session()->pull('return_to', route('main'));

            return redirect($returnUrl)->with('auto_add_cart', $productId);
        }

        return redirect()->route('main');
    }

    // ─── Logout ─────────────────────────────────────────────

    public function cerrarsesion(Request $request): RedirectResponse
    {
        Session::forget(CartManager::SESSION_KEY);

        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ─── Perfil ─────────────────────────────────────────────

    public function perfil(): View
    {
        return view('perfil', ['usuario' => Auth::user()]);
    }

    public function actualizarPerfil(ActualizarPerfilRequest $request): RedirectResponse
    {
        $this->usuarios->actualizarPerfil(Auth::user(), $request->validated());

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente');
    }

    public function eliminarCuenta(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        $usuario->delete();

        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada permanentemente.');
    }

    // ─── Clave olvidada ─────────────────────────────────────

    public function clave_olvidada(): View
    {
        return view('clave_olvidada');
    }

    public function validar_verificacion(Request $request): RedirectResponse
    {
        $request->validate([
            'correo' => 'required|email|exists:usuarios,correo',
        ], [
            'correo.exists' => 'Este correo no está registrado en el sistema.',
        ]);

        if (! $this->recuperacion->solicitarCodigo($request->correo)) {
            return back()->withErrors(['correo' => 'No se pudo enviar el código. Intenta de nuevo.']);
        }

        return redirect()->route('verificacion')->with('success', 'Código de verificación enviado.');
    }

    public function verificacion(): View|RedirectResponse
    {
        if (! $this->recuperacion->tieneSolicitudPendiente()) {
            return redirect()->route('password.request')
                ->withErrors(['correo' => 'Debes solicitar un código de verificación primero.']);
        }

        return view('verificacion');
    }

    public function validar_clave_olvidada(Request $request): RedirectResponse
    {
        $request->validate([
            'correo' => 'required|string|size:6',
        ], [
            'correo.size' => 'El código de verificación debe contener 6 dígitos.',
        ]);

        $resultado = $this->recuperacion->validarCodigo($request->correo);

        if ($resultado['ok']) {
            return redirect()->route('nueva_clave');
        }

        $mensaje = match ($resultado['motivo'] ?? '') {
            'sin_sesion' => 'La sesión de recuperación no es válida o expiró.',
            'expirado' => 'El código ha expirado (límite 3 minutos). Solicita uno nuevo.',
            default => 'El código de verificación ingresado es incorrecto.',
        };

        if ($resultado['motivo'] === 'sin_sesion' || $resultado['motivo'] === 'expirado') {
            return redirect()->route('password.request')->withErrors(['correo' => $mensaje]);
        }

        return back()->withErrors(['correo' => $mensaje]);
    }

    public function nueva_clave(): View|RedirectResponse
    {
        $correo = session('verificacion_correo');

        if ($correo && $this->recuperacion->estaAutorizado($correo)) {
            $this->recuperacion->consumirAutorizacion();

            return view('nueva_clave', ['correoUsuario' => $correo]);
        }

        return redirect()->route('password.request')
            ->withErrors(['correo' => 'Acceso denegado. La sesión de verificación es inválida o intentas usar otro correo.']);
    }

    public function actualizar_clave(Request $request): RedirectResponse
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

        $this->recuperacion->actualizarClave($request->correo, $request->contrasena1);

        return redirect()->route('login')->with('success', 'Contraseña actualizada con éxito. Ya puedes iniciar sesión.');
    }

    // ─── Admin: Usuarios ────────────────────────────────────

    public function listarUsuarios(): View
    {
        $usuarios = $this->usuarios->listarClientes();

        return view('admin.listausuarios', compact('usuarios'));
    }

    public function editarUsuario(int $id): View
    {
        $usuario = Usuarios::findOrFail($id);

        return view('admin.editarusuario', compact('usuario'));
    }

    public function actualizarUsuario(Request $request): RedirectResponse
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:15',
            'rol_id' => 'required|integer|in:1,2',
        ]);

        $this->usuarios->actualizarDesdeAdmin((int) $request->usuario_id, [
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'rol_id' => $request->rol_id,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function delete(Request $request): RedirectResponse
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $this->usuarios->eliminar((int) $request->usuario_id);

        return back()->with('success', 'Usuario eliminado correctamente');
    }
}
