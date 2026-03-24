<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ResenasController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\Admin\ProductosController as AdminProductosController;
use App\Http\Controllers\Admin\AdminsController;

/*
| Rutas de Entrada y Redirección
*/
Route::get('/', function () { return redirect()->route('main'); })->name('home');

/*
| Rutas Públicas
*/
Route::get('/main', function () { return view('main'); })->name('main');

Route::post('/pedidos/guardar-pendiente', [App\Http\Controllers\PedidosController::class, 'guardarPendiente'])->name('pedidos.guardar.pendiente');

Route::prefix('productos')->group(function () {
    Route::get('/juegos', [ProductosController::class, 'listarjuegos'])->name('productos.juegos');
    Route::get('/consolas', [ProductosController::class, 'listarconsolas'])->name('productos.consolas');
    Route::get('/buscar-juegos', [ProductosController::class, 'buscarJuegos'])->name('productos.buscarjuegos');
    Route::get('/buscar-consolas', [ProductosController::class, 'buscarConsolas'])->name('productos.buscarconsolas');
    
    Route::get('/juegos/{id}/resenas', [ResenasController::class, 'show'])->name('productos.resenas');
});

/*
| Rutas de login/registro
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('login'); })->name('login');
    Route::post('/login', [UsuariosController::class, 'login'])->name('login.post');
    Route::get('/register', [UsuariosController::class, 'index'])->name('register');
    Route::post('/register', [UsuariosController::class, 'register']);
    Route::get('/clave-olvidada', [UsuariosController::class, 'clave_olvidada'])->name('password.request');
    Route::post('/clave-olvidada', [UsuariosController::class, 'validar_clave_olvidada']);
});

/*
| Rutas Protegidas para users registrados
*/
Route::middleware('auth')->group(function () {
    Route::get('/logout', [UsuariosController::class, 'cerrarsesion'])->name('logout');

    Route::post('/productos/juegos/{id}/resenas', [ResenasController::class, 'agregarresena'])->name('productos.resenas.agregar');

    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidosController::class, 'index'])->name('pedidos.index');
        Route::post('/agregar/{id}', [PedidosController::class, 'agregar'])->name('pedidos.agregar');
        Route::put('/{id}', [PedidosController::class, 'actualizar'])->name('pedidos.update');
        Route::delete('/vaciar', [PedidosController::class, 'vaciar'])->name('pedidos.clear');
        Route::delete('/{id}', [PedidosController::class, 'eliminar'])->name('pedidos.eliminar');
    });

    Route::get('/perfil', [UsuariosController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [UsuariosController::class, 'actualizarPerfil'])->name('perfil.actualizar');

    Route::get('/pagos', [PagosController::class, 'index'])->name('pagos.index');
    Route::post('/pagar', [PagosController::class, 'pagar'])->name('pagar');

    Route::get('/factura', [PagosController::class, 'factura'])->name('factura');

    Route::get('/mis-pedidos', [PagosController::class, 'historial'])->name('historial');
    Route::get('/mis-pedidos/{id}/factura', [PagosController::class, 'facturaHistorial'])->name('historial.factura');
});

/*
| Administración
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminsController::class, 'index'])->name('main');

    Route::get('/usuarios', [UsuariosController::class, 'listarUsuarios'])->name('usuarios.index');
    Route::get('/usuarios/{id}/editar', [UsuariosController::class, 'editarUsuario'])->name('usuarios.edit');
    Route::post('/usuarios/{id}/editar', [UsuariosController::class, 'actualizarUsuario'])->name('usuarios.update');
    Route::patch('/usuarios/{id}', [UsuariosController::class, 'actualizarUsuario'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuariosController::class, 'delete'])->name('usuarios.destroy');

    Route::resource('productos', AdminProductosController::class)->except(['show']);

    Route::get('/productos/buscar', [AdminProductosController::class, 'search'])->name('productos.search');
    
});

/*
| Páginas Estáticas
*/
Route::view('/politicas', 'politicas')->name('politicas');
Route::view('/terminos', 'terminos')->name('terminos');