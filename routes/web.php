<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ResenasController;
use App\Http\Controllers\PedidosController;

Route::get('/', function () {
    return view('login');
});

Route::post('/', [UsuariosController::class, 'login']);

Route::get('/register', [UsuariosController::class, 'index']);

Route::post('/register', [UsuariosController::class, 'register']);

Route::get('/main', function () {
    return view('main');
});

Route::post('/main', function () {
    return view('main');
});

Route::get('/juegos', [ProductosController::class, 'listarjuegosuser'])->name('productos.listarjuegosuser');

Route::post('/juegos', [PedidosController::class, 'agregar'])->name('productos.agregar');

Route::get('/carrito', [PedidosController::class, 'listar'])->name('pedidos.listar');

Route::post('/Pedidos', [PedidosController::class, 'agregar'])->name('pedidos.agregar');

Route::get('/consolas', [ProductosController::class, 'listarconsolasuser'])->name('productos.listarconsolasuser');

Route::post('/consolas', [PedidosController::class, 'agregar'])->name('productos.agregar');

Route::get('/juegos-buscar', [ProductosController::class, 'buscarjuegos'])->name('juegos-buscar.buscar');

Route::get('/consolas-buscar', [ProductosController::class, 'buscarconsolas'])->name('consolas-buscar.buscar');

Route::get('/carrito', function () {
    return view('carrito');
});

Route::post('/carrito', function () {
    return view('carrito');
});

Route::get('/politicas', function () {
    return view('politicas');
});

Route::post('/politicas', function () {
    return view('politicas');
});

Route::get('/terminos-y-condiciones', function () {
    return view('terminos');
});

Route::post('/terminos-y-condiciones', function () {
    return view('terminos');
});

Route::get('/clave-olvidada', function () {
    return view('clave_olvidada');
});

Route::post('/clave-olvidada', function () {
    return view('login');
});

Route::get('/resenas', function () {
    return view('resenas');
});

Route::get('/juegos/{id}/resenas', [ResenasController::class, 'show'])->name('juegos.resenas');

// Rutas de administrador ---------------------------------------------------

Route::get('/admin/main', function () {
    return view('admin/main');
});

Route::post('/admin/main', function () {
    return view('admin/main');
});

Route::get('/admin/listausuarios', [UsuariosController::class, 'listarUsuarios'])->name('admin.usuarios.lista');

Route::post('/admin/listausuarios', [UsuariosController::class, 'delete'])->name('admin.usuarios.delete');

Route::get('/admin/editarusuario/{id}', [UsuariosController::class, 'editarUsuario'])->name('admin.usuarios.editar');

Route::post('/admin/editarusuario', [UsuariosController::class, 'actualizarUsuario'])->name('admin.usuarios.actualizar');

Route::get('/admin/juegos', [ProductosController::class, 'listarjuegos'])->name('admin.productos.listarjuegos');

Route::post('/admin/juegos', [ProductosController::class, 'delete'])->name('admin.productos.delete');

Route::get('/admin/consolas', [ProductosController::class, 'listarconsolas'])->name('admin.productos.listarconsolas');

Route::post('/admin/consolas', [ProductosController::class, 'delete'])->name('admin.productos.delete');

Route::get('/admin/agregarproducto/{tipo}', [ProductosController::class, 'agregarproducto'])->name('admin.productos.agregar');

Route::post('/admin/actualizarproducto', [ProductosController::class, 'actualizarproducto'])->name('admin.productos.actualizar');

Route::get('/admin/editarproducto/{tipo}/{id}', [ProductosController::class, 'editarproducto'])->name('admin.productos.editar');

Route::post('/admin/editarproducto', [ProductosController::class, 'guardarcambios'])->name('admin.productos.guardarcambios');

Route::get('/admin/auditorias', function () {

    return view('admin/auditorias');
});

Route::post('/admin/auditorias', function () {
    return view('admin/auditorias');
});

Route::get('/admin/juegos-buscar', [ProductosController::class, 'buscarjuegos'])->name('admin.juegos-buscar.buscar');

Route::get('/admin/consolas-buscar', [ProductosController::class, 'buscarconsolas'])->name('admin.consolas-buscar.buscar');
