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



