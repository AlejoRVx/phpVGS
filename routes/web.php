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

Route::get('/juegos', function () {
    return view('juegos');
});

Route::post('/consolas', function () {
    return view('consolas');
});

Route::post('/juegos', function () {
    return view('juegos');
});



