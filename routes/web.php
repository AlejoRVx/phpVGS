<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ResenasController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PagosController;

// Autenticación ------------------------------------------------------------
Route::get('/', function () {
    return view('login');
});

Route::post('/', [UsuariosController::class, 'login']);

Route::get('/logout', [UsuariosController::class, 'cerrarsesion']);

Route::get('/register', [UsuariosController::class, 'index']);

Route::post('/register', [UsuariosController::class, 'register']);

Route::get('/clave-olvidada', [UsuariosController::class, 'clave_olvidada']);

Route::post('/clave-olvidada', [UsuariosController::class, 'validar_clave_olvidada']);

// Páginas principales ------------------------------------------------------
Route::get('/main', function () {
    return view('main');
});

Route::post('/main', function () {
    return view('main');
});

// Productos (Usuario) ------------------------------------------------------
Route::get('/juegos', [ProductosController::class, 'listarjuegosuser'])->name('productos.listarjuegosuser');

Route::get('/consolas', [ProductosController::class, 'listarconsolasuser'])->name('productos.listarconsolasuser');

Route::get('/juegos-buscar', [ProductosController::class, 'buscarjuegos'])->name('juegos-buscar.buscar');

Route::get('/consolas-buscar', [ProductosController::class, 'buscarconsolas'])->name('consolas-buscar.buscar');

// Reseñas ------------------------------------------------------------------
Route::get('/resenas', function () {
    return view('resenas');
});

Route::post('/juegos/resenas', [ResenasController::class, 'agregarresena'])->name('juegos.agregarresena.resena');

Route::get('/juegos/{id}/resenas', [ResenasController::class, 'show'])->name('juegos.resenas');

// Carrito de compras (Pedidos) ---------------------------------------------
Route::post('/pedidos/agregar/{id}', [PedidosController::class, 'agregar'])->name('pedidos.agregar');

Route::get('/pedidos', [PedidosController::class, 'index'])->name('pedidos.index');

Route::put('/pedidos/actualizar/{id}', [PedidosController::class, 'actualizar'])->name('pedidos.actualizar');

Route::delete('/pedidos/eliminar/{id}', [PedidosController::class, 'eliminar'])->name('pedidos.eliminar');

Route::delete('/pedidos/vaciar', [PedidosController::class, 'vaciar'])->name('pedidos.vaciar');

// Pagos ----------------------------------------------------------
Route::get('/pagos', [PagosController::class, 'index'])->name('pagos.index');

Route::post('/pagar', [PagosController::class, 'pagar'])->name('pagar');

// Páginas legales ----------------------------------------------------------
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

// Rutas de administrador ---------------------------------------------------

// Dashboard admin
Route::get('/admin/main', function () {
    return view('admin/main');
});

Route::post('/admin/main', function () {
    return view('admin/main');
});

// Gestión de usuarios
Route::get('/admin/listausuarios', [UsuariosController::class, 'listarUsuarios'])->name('admin.usuarios.lista');

Route::post('/admin/listausuarios', [UsuariosController::class, 'delete'])->name('admin.usuarios.delete');

Route::get('/admin/editarusuario/{id}', [UsuariosController::class, 'editarUsuario'])->name('admin.usuarios.editar');

Route::post('/admin/editarusuario', [UsuariosController::class, 'actualizarUsuario'])->name('admin.usuarios.actualizar');

// Gestión de productos (Juegos)
Route::get('/admin/juegos', [ProductosController::class, 'listarjuegos'])->name('admin.productos.listarjuegos');

Route::post('/admin/juegos', [ProductosController::class, 'delete'])->name('admin.productos.delete');

Route::get('/admin/juegos-buscar', [ProductosController::class, 'buscarjuegos'])->name('admin.juegos-buscar.buscar');

// Gestión de productos (Consolas)
Route::get('/admin/consolas', [ProductosController::class, 'listarconsolas'])->name('admin.productos.listarconsolas');

Route::post('/admin/consolas', [ProductosController::class, 'delete'])->name('admin.productos.delete');

Route::get('/admin/consolas-buscar', [ProductosController::class, 'buscarconsolas'])->name('admin.consolas-buscar.buscar');

// CRUD de productos
Route::get('/admin/agregarproducto/{tipo}', [ProductosController::class, 'agregarproducto'])->name('admin.productos.agregar');

Route::post('/admin/actualizarproducto', [ProductosController::class, 'actualizarproducto'])->name('admin.productos.actualizar');

Route::get('/admin/editarproducto/{tipo}/{id}', [ProductosController::class, 'editarproducto'])->name('admin.productos.editar');

Route::post('/admin/editarproducto', [ProductosController::class, 'guardarcambios'])->name('admin.productos.guardarcambios');