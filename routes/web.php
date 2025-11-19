<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;

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

Route::post('/juegos', [ProductosController::class, 'agregarAlCarrito'])->name('productos.agregarAlCarrito');

Route::get('/consolas', [ProductosController::class, 'listarconsolasuser'])->name('productos.listarconsolasuser');

Route::post('/consolas', [ProductosController::class, 'agregarAlCarrito'])->name('productos.agregarAlCarrito');

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

// Nuevas rutas para secciones de administrador (POR AHORA SOLO PARA LAS VISTAS) ------------

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

Route::get('/admin/politicas', function () {
    return view('admin/politicas');
});

Route::get('/admin/terminos-y-condiciones', function () {
    return view('admin/terminos');
});