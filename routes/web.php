<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

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

Route::get('/consolas', function () {
    return view('consolas');
});

Route::post('/consolas', function () {
    return view('consolas');
});

Route::get('/juegos', function () {
    return view('juegos');
});

Route::post('/juegos', function () {
    return view('juegos');
});

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

Route::get('/admin/juegos', function () {
    return view('admin/juegos');
});

Route::post('/admin/juegos', function () {
    return view('admin/juegos');
});

Route::get('/admin/consolas', function () {
    return view('admin/consolas');
});

Route::post('/admin/consolas', function () {
    return view('admin/consolas');
});

Route::get('/admin/auditorias', function () {
    return view('admin/auditorias');
});

Route::post('/admin/auditorias', function () {
    return view('admin/auditorias');
});